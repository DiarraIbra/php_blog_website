<?php
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $role = htmlspecialchars($_POST['role']);
    include "db.php";
    session_start();

    $sql = "INSERT INTO users(name,email,password,role) VALUES('$name','$email','$password','$role')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error:{$conn->error}";
    } else {
        echo "The registration done successfully";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="register.php" method="POST">
        Name: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Password: <input type="password" name="password" required><br>
        Role:
        <select name="role">
            <option value="subscriber">Subscriber</option>
            <option value="author">Author</option>
        </select><br>
        <input type="submit" name="submit" value="Register">
    </form>
</body>

</html>