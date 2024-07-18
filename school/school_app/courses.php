<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO courses (course_name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $course_name, $description);
    $stmt->execute();
    header("Location: courses.php");
    exit();
}

$result = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Courses</h2>
    <form method="post">
        <div>
            <label>Course Name</label>
            <input type="text" name="course_name" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>
        <button type="submit">Add Course</button>
    </form>
    <table>
        <tr>
            <th>Course Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['course_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>
                <a href="update_course.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_course.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
