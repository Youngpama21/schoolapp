<?php
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM courses WHERE id = $id");
$course = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE courses SET course_name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $course_name, $description, $id);
    $stmt->execute();
    header("Location: courses.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Course</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Update Course</h2>
    <form method="post">
        <div>
            <label>Course Name</label>
            <input type="text" name="course_name" value="<?php echo $course['course_name']; ?>" required>
        </div>
        <div>
            <label>Description</label>
            <textarea name="description" required><?php echo $course['description']; ?></textarea>
        </div>
        <button type="submit">Update Course</button>
    </form>
</body>
</html>
