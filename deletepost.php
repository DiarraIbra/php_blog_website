<?php
session_start();
$post_id = $_SESSION['post_id'];
include "db.php";
$sql = "DELETE FROM posts WHERE id='$post_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
    echo "Error:{$conn->error}";
} else {
    echo "Deleted successfully!";
}