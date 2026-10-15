
<?php
$host = "db01.dbhost.dev";
$dbname = "db_453dmwfsq";
$username = "user_453dmwfsq";
$password = "p453dmwfsq";
$port=5051;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch (PDOException $e) {
    die("Database connection failed. Check database settings.");
}
?>