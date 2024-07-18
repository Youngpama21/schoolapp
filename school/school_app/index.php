<?php
session_start();
require('db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement with parameter binding
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $username);

    // Execute query
    if ($stmt->execute()) {
        // Store result
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($id, $db_username, $db_password);

            // Fetch the result
            $stmt->fetch();

            // Verify password 
            if ($password === $db_password) {
                //  start session
                $_SESSION['username'] = $db_username;
                $_SESSION['user_id'] = $id;
                header("Location: dashboard.php");
                exit();
            } else {
                // Password incorrect
                echo "Password does not match.<br>";
            }
        } else {
            // Username not found
            echo "Username not found.<br>";
        }
    } else {
        // Query execution failed
        echo "SQL query failed: " . $stmt->error . "<br>";
    }

    // Close statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>
