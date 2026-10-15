<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = $pageTitle ?? "CampusCare";
$user = $_SESSION['user'] ?? null;

// Pages inside the admin folder need a different relative path.
$base = (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false)
    ? '../'
    : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | CampusCare</title>
    <link rel="stylesheet" href="<?= $base ?>css/style.css">
</head>
<body>

<header class="topbar">
    <a class="brand" href="<?= $base ?>index.php">
        <span class="brand-mark">C</span>
        <span>
            CampusCare
            <small>College Complaint Portal</small>
        </span>
    </a>

    <nav>
        <a href="<?= $base ?>index.php">Home</a>

        <?php if ($user): ?>
            <a href="<?= $base ?>dashboard.php">Dashboard</a>

            <?php if ($user['role'] === 'student'): ?>
                <a href="<?= $base ?>complaint.php">New Complaint</a>
            <?php endif; ?>

            <?php if ($user['role'] === 'admin'): ?>
                <a href="<?= $base ?>admin/dashboard.php">Admin</a>
            <?php endif; ?>

            <a class="nav-cta" href="<?= $base ?>logout.php">Logout</a>
        <?php else: ?>
            <a href="<?= $base ?>login.php">Login</a>
            <a class="nav-cta" href="<?= $base ?>register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
