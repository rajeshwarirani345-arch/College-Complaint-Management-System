
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

$pageTitle = "Admin Dashboard";

$total = $pdo->query(
    "SELECT COUNT(*) FROM complaints"
)->fetchColumn();

$pending = $pdo->query(
    "SELECT COUNT(*) FROM complaints WHERE status='Pending'"
)->fetchColumn();

$progress = $pdo->query(
    "SELECT COUNT(*) FROM complaints WHERE status='In Progress'"
)->fetchColumn();

$resolved = $pdo->query(
    "SELECT COUNT(*) FROM complaints
     WHERE status IN ('Resolved','Closed')"
)->fetchColumn();

require_once "../includes/header.php";
?>

<div class="page-heading">
    <div>
        <span class="eyebrow">ADMINISTRATION</span>
        <h1>Admin Dashboard</h1>
        <p>Manage complaints submitted by students.</p>
    </div>

    <a href="complaints.php" class="btn btn-primary">
        Manage Complaints →
    </a>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div><p>Total Complaints</p><h2><?= $total ?></h2></div>
    </div>

    <div class="stat-card">
        <div><p>Pending</p><h2><?= $pending ?></h2></div>
    </div>

    <div class="stat-card">
        <div><p>In Progress</p><h2><?= $progress ?></h2></div>
    </div>

    <div class="stat-card">
        <div><p>Resolved / Closed</p><h2><?= $resolved ?></h2></div>
    </div>
</div>

<section class="content-card">
    <div class="card-heading">
        <div>
            <h2>Quick Actions</h2>
            <p>Manage student complaints from one place.</p>
        </div>
    </div>

    <div class="quick-grid">
        <a class="quick-link" href="complaints.php">
            <span class="feature-icon purple">☷</span>
            <div>
                <b>View Complaints</b>
                <small>Read complaints submitted by students.</small>
            </div>
            <span class="quick-arrow">→</span>
        </a>

        <a class="quick-link" href="complaints.php">
            <span class="feature-icon mint">✓</span>
            <div>
                <b>Update Complaints</b>
                <small>Change status and add responses.</small>
            </div>
            <span class="quick-arrow">→</span>
        </a>
    </div>
</section>

<?php require_once "../includes/footer.php"; ?>