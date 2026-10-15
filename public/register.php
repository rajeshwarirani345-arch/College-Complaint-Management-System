<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name == "" || $email == "" || $password == "") {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must contain at least 6 characters.";
    } else {
        try {
            $check = $pdo->prepare(
                "SELECT id FROM users WHERE email = ?"
            );
            $check->execute([$email]);

            if ($check->fetch()) {
                $error = "This email is already registered.";
            } else {
                $hashedPassword = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, password, role)
                     VALUES (?, ?, ?, 'student')"
                );
                $stmt->execute([$name, $email, $hashedPassword]);

                header("Location: login.php?registered=1");
                exit;
            }
        } catch (PDOException $e) {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CampusCare</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef2ff, #dff7f2);
            min-height: 100vh; display: flex;
            justify-content: center; align-items: center;
        }
        .card {
            background: white; width: 90%; max-width: 430px;
            padding: 35px; border-radius: 18px;
            box-shadow: 0 10px 35px #0001;
        }
        h1 { color: #3730a3; margin-bottom: 8px; }
        p { color: #64748b; }
        label { display: block; margin-top: 17px; }
        input {
            width: 100%; padding: 13px; margin-top: 7px;
            border: 1px solid #cbd5e1; border-radius: 8px;
        }
        button {
            width: 100%; padding: 14px; margin-top: 24px;
            background: #4f46e5; color: white; border: 0;
            border-radius: 8px; cursor: pointer; font-size: 16px;
        }
        button:hover { background: #3730a3; }
        .error { color: #b91c1c; background: #fee2e2;
                 padding: 10px; border-radius: 7px; }
        a { color: #4f46e5; text-decoration: none; }
        .center { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
<div class="card">
    <h1>Create Account</h1>
    <p>Join CampusCare and share your concerns.</p>

    <?php if ($error != ""): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password"
               minlength="6" required>

        <button type="submit">Create Account</button>
    </form>

    <div class="center">
        Already registered?
        <a href="login.php">Login here</a>
    </div>
    <div class="center">
        <a href="index.php">Back to Home</a>
    </div>
</div>
</body>
</html>