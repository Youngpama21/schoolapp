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

$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Students</h2>
    <form method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Age</label>
            <input type="number" name="age" required>
        </div>
        <div>
            <label>Class</label>
            <input type="text" name="class" required>
        </div>
        <button type="submit">Add Student</button>
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Class</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo $row['class']; ?></td>
            <td>
                <a href="update_student.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_student.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
