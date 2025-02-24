<?php
session_start();
session_destroy();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    echo "<div class='dashboard-container'>";
    echo "<h1>Welcome to Dashboard</h1>";
    echo "<p>Your name is: {$_SESSION['user_name']} and your role is: {$_SESSION['user_role']}</p>";
    echo "<a href='logout.php'>Log Out</a>";
    echo "</div>";
}
