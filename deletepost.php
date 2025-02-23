<?php
session_start();
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    if ($_SESSION['user_role'] == "subscrider") {
        header("Location: dashboard.php");
    } else {
    }
    $post_id = $_SESSION['post_id'];
    $sql = "DELETE FROM posts WHERE id='$post_id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error:{$conn->error}";
    } else {
        echo "Deleted successfully!";
    }
}