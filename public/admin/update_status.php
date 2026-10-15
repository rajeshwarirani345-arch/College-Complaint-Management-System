
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user"]) ||
    $_SESSION["user"]["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: complaints.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: complaints.php");
    exit;
}

if (isset($_POST["delete"])) {
    $stmt = $pdo->prepare(
        "DELETE FROM complaints WHERE id = ?"
    );
    $stmt->execute([$id]);
} else {
    $status = $_POST["status"] ?? "Pending";

    $allowed = [
        "Pending", "In Progress", "Resolved", "Closed"
    ];

    if (!in_array($status, $allowed, true)) {
        $status = "Pending";
    }

    $response = trim($_POST["admin_response"] ?? "");

    $stmt = $pdo->prepare(
        "UPDATE complaints
         SET status = ?, admin_response = ?
         WHERE id = ?"
    );

    $stmt->execute([$status, $response, $id]);
}

header("Location: complaints.php?updated=1");
exit;
?>
