<?php
session_start();
include "db.php";
if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error:{$conn->error}";
    } else {
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];
            $_SESSION['user_email'] = $row['email'];
            echo "Loged in successfully!<a href='dashboard.php'>Dashboard</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="./allstyle.css">
</head>

<body>
    <form action="login.php" method="POST">
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>