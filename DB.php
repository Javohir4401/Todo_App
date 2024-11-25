<?php

$dsn = "mysql:host=localhost;dbname=todo_app;charset=utf8mb4";
$username = "root";
$password = "1112";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ma'lumotlar bazasiga ulanishda xatolik: " . $e->getMessage());
}
