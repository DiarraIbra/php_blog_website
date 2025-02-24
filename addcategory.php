<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) {
    echo "You are not an admin";
    header("Location: login.php");
} else {
    if ($_SESSION['user_role'] == "admin") {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $sql = "INSERT INTO categories(name)VALUES('$name')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "Error:{$conn->error}";
            } else {
                echo "Category added successfully";
            }
        }
    } else {
        header("Location: dashboard.php");
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category</title>
    <link rel="stylesheet" href="./allstyle.css">
</head>

<body>
    <form action="addcategory.php" method="POST">
        <input type="text" name="name">
        <input type="submit" value="add category" name="submit">
        <a href='dashboard.php'>Dashboard</a>
    </form>
</body>

</html>