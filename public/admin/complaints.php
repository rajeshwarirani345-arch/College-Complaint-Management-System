

<?php
require_once "../config/database.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"]) ||
    $_SESSION["user"]["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$pageTitle = "Manage Complaints";

$stmt = $pdo->query(
    "SELECT c.*, u.name AS student_name, u.email AS student_email
     FROM complaints c
     JOIN users u ON c.user_id = u.id
     ORDER BY c.created_at DESC"
);

$complaints = $stmt->fetchAll();

require_once "../includes/header.php";
?>

<div class="page-heading">
    <div>
        <span class="eyebrow">ADMINISTRATION</span>
        <h1>Manage Complaints</h1>
        <p>Review complaints and update their status.</p>
    </div>

    <a href="dashboard.php" class="btn btn-light">
        ← Admin Dashboard
    </a>
</div>

<?php if (isset($_GET["updated"])): ?>
    <div class="alert alert-success">
        Complaint updated successfully.
    </div>
<?php endif; ?>

<?php if (!$complaints): ?>
    <section class="content-card empty-state">
        <h3>No complaints found</h3>
        <p>New student complaints will appear here.</p>
    </section>
<?php else: ?>

    <div class="admin-list">
    <?php foreach ($complaints as $c): ?>

        <article class="admin-complaint content-card">
            <div class="admin-complaint-top">
                <div>
                    <span class="status status-<?= strtolower(
                        str_replace(" ", "-", $c["status"])
                    ) ?>">
                        <?= htmlspecialchars($c["status"]) ?>
                    </span>

                    <h2><?= htmlspecialchars($c["subject"]) ?></h2>

                    <p class="muted">
                        Student: <?= htmlspecialchars($c["student_name"]) ?>
                        · <?= htmlspecialchars($c["student_email"]) ?>
                    </p>
                </div>

                <span class="category-chip">
                    <?= htmlspecialchars($c["category"]) ?>
                </span>
            </div>

            <p class="complaint-description">
                <?= nl2br(htmlspecialchars($c["description"])) ?>
            </p>

            <form method="post" action="update_status.php"
                  class="admin-update-form">

                <input type="hidden" name="id"
                       value="<?= (int)$c["id"] ?>">

                <label>Complaint Status
                    <select name="status" required>
                        <?php
                        $statuses = [
                            "Pending", "In Progress",
                            "Resolved", "Closed"
                        ];

                        foreach ($statuses as $status):
                        ?>
                            <option value="<?= $status ?>"
                                <?= $c["status"] === $status
                                    ? "selected" : "" ?>>
                                <?= $status ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>Admin Response
                    <textarea name="admin_response" rows="3"
                        placeholder="Enter response for the student..."><?= htmlspecialchars(
                            $c["admin_response"] ?? ""
                        ) ?></textarea>
                </label>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Save Update
                    </button>

                    <button type="submit" name="delete" value="1"
                        class="btn btn-danger"
                        onclick="return confirm('Delete this complaint?')">
                        Delete Complaint
                    </button>
                </div>
            </form>
        </article>

    <?php endforeach; ?>
    </div>

<?php endif; ?>

<?php require_once "../includes/footer.php"; ?>