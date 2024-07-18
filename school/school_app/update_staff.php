<?php
session_start();
require 'db.php';
if (!isset($_SESSION['id'])) {
    header("Location: db.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM staff WHERE id = $id");
$staff = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("UPDATE staff SET name = ?, position = ?, salary = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $position, $salary, $id);
    $stmt->execute();
    header("Location: staff.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Staff</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Update Staff</h2>
    <form method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $staff['name']; ?>" required>
        </div>
        <div>
            <label>Position</label>
            <input type="text" name="position" value="<?php echo $staff['position']; ?>" required>
        </div>
        <div>
            <label>Salary</label>
            <input type="number" step="0.01" name="salary" value="<?php echo $staff['salary']; ?>" required>
        </div>
        <button type="submit">Update Staff</button>
    </form>
</body>
</html>
