<?php
session_start();
include "db.php";
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['title']} <br>";
    echo "{$row['content']} <br>";
    echo "<img src='image/{$row['image']}'><br><hr>";
    echo "<a href='updatepost.php?post_id={$row['id']}'>Update</a> <a href='deletepost.php?post_id={$row['id']}'>Delete</a>";
}