<?php
session_start();
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
}
include "db.php";
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    echo "{$row['title']} <br>";
    echo "{$row['content']} <br>";
    echo "<img src='image/{$row['image']}'><br><hr>";
    echo "<a href='updatepost.php?post_id={$row['id']}'>Update</a> <a href='deletepost.php?post_id={$row['id']}'>Delete</a>";
    echo "<form action='insertcomment.php?post_id={$row['id']}' method='POST'>
            <textarea placeholder='Write your comment here' name='comment'></textarea>
            <input type='submit' name='submit' value='add comment'>
        </form>";
    $post_id = $row['id'];
    $sql2 = "SELECT * FROM comments WHERE post_id='$post_id'";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        echo "name: {$row2['user_name']} comment:{$row2['comment']} <br>";
    }
}