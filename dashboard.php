<?php
session_start();
session_destroy();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    echo "Welcome to dashboard your name is : {$_SESSION['user_name']} and your role is as : {$_SESSION['user_role']}<a href='logout.php'> Log Out</a>";
}
