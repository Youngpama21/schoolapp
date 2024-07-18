<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("INSERT INTO staff (name, position, salary) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $position, $salary);
    $stmt->execute();
    header("Location: staff.php");
    exit();
}
?>
