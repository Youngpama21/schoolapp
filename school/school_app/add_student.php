<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $class = $_POST['class'];

    $stmt = $conn->prepare("INSERT INTO students (name, age, class) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $age, $class);
    $stmt->execute();
    header("Location: student.php");
    exit();
}
?>
