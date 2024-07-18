<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Contact Us</h2>
    <form method="post" action="contact.php">
        <div>
            <label>Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Message</label>
            <textarea name="message" required></textarea>
        </div>
        <button type="submit">Send Message</button>
    </form>
</body>
</html>
