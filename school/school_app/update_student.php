<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE id = $id");
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $class = $_POST['class'];

    $stmt = $conn->prepare("UPDATE students SET name = ?, age = ?, class = ? WHERE id = ?");
    $stmt->bind_param("sisi", $name, $age, $class, $id);
    $stmt->execute();
    header("Location: student.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Student</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Update Student</h2>
    <form method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $student['name']; ?>" required>
        </div>
        <div>
            <label>Age</label>
            <input type="number" name="age" value="<?php echo $student['age']; ?>" required>
        </div>
        <div>
            <label>Class</label>
            <input type="text" name="class" value="<?php echo $student['class']; ?>" required>
        </div>
        <button type="submit">Update Student</button>
    </form>
</body>
</html>
