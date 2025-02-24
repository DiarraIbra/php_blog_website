<?php
session_start();
include "db.php";
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    if ($_SESSION['user_role'] == "author") {
        header("Location: displaypost.php");
    } else {
        if (isset($_POST['submit'])) {
            $user_name = $_SESSION['user_name'];
            $user_email = $_SESSION['user_email'];
            $user_comment = $_POST['comment'];
            $sql = "INSERT INTO comments(post_id,user_name,email,comment)VALUES('$post_id','$user_name','$user_email','$user_comment')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo "<p style='color: red; font-weight: bold;'>Error: {$conn->error}</p>";
            } else {
                echo "<p style='color: green; font-weight: bold;'>Comment added successfully</p>";
            }
        }
    }
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    .comment-container {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .comment-container h2 {
        text-align: center;
        color: #333;
    }

    .comment-container textarea {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .comment-container input[type='submit'] {
        display: block;
        width: 100%;
        background: linear-gradient(45deg, #ff6b6b, #ffb400);
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        transition: background 0.3s, transform 0.2s;
    }

    .comment-container input[type='submit']:hover {
        background: linear-gradient(45deg, #ff4757, #ff9f1a);
        transform: scale(1.05);
    }
</style>

<div class='comment-container'>
    <h2>Leave a Comment</h2>
    <form method='POST'>
        <textarea placeholder='Write your comment here' name='comment'></textarea>
        <input type='submit' name='submit' value='Add Comment'>
    </form>
</div>