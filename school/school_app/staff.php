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

$result = $conn->query("SELECT * FROM staff");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Staff</h2>
    <form method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Position</label>
            <input type="text" name="position" required>
        </div>
        <div>
            <label>Salary</label>
            <input type="number" step="0.01" name="salary" required>
        </div>
        <button type="submit">Add Staff</button>
    </form>
    <table>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Salary</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['position']; ?></td>
            <td><?php echo $row['salary']; ?></td>
            <td>
                <a href="update_staff.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete_staff.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
