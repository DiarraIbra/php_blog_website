<?php
// session_start();
// if (isset($_SESSION['user_name'])) {
//     $user_name = $_SESSION['user_name'];
// }
include "allheader.php";
include 'db.php'; // Ensure database connection

$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='post-container'>";
    echo "<h2>{$row['title']}</h2>";
    echo "<p>{$row['content']}</p>";
    echo "<img src='image/{$row['image']}' alt='Post Image'>";
    echo "<hr>";
    echo "<a href='updatepost.php?post_id={$row['id']}'>Update</a> ";
    echo "<a href='deletepost.php?post_id={$row['id']}'>Delete</a>";

    echo "<div class='comment-section'>";
    echo "<form action='insertcomment.php?post_id={$row['id']}' method='POST'>";
    echo "<textarea placeholder='Write your comment here' name='comment'></textarea>";
    echo "<input type='submit' name='submit' value='Add Comment'>";
    echo "</form>";

    $post_id = $row['id'];
    $sql2 = "SELECT * FROM comments WHERE post_id='$post_id'";
    $result2 = mysqli_query($conn, $sql2);

    while ($row2 = mysqli_fetch_assoc($result2)) {
        echo "<p><strong>{$row2['user_name']}:</strong> {$row2['comment']}</p>";
    }
    echo "</div>"; // Close comment-section
    echo "</div>"; // Close post-container
}
