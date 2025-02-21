<?php
session_start();
$user_id = $_SESSION['user_id'];
include "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
} else {
    if ($_SESSION['user_role'] == "author") {
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error:{$conn->error}";
        } else {
            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $category_name = $_POST['category_name'];
                $name = $_FILES['image']['name'];
                $temp_location = $_FILES['image']['tmp_name'];
                $our_location = "image/";
                if (!empty($name)) {
                    move_uploaded_file($temp_location, $our_location . $name);
                }
                $sql1 = "select id from categories where name='$category_name'";
                $result1 = mysqli_query($conn, $sql1);
                if ($result1->num_rows > 0) {
                    $row = mysqli_fetch_assoc($result1);
                    $idforcategory = $row['id'];
                }
                $sql2 = "INSERT INTO posts(title,content,author_id,category_id,image) VALUES('$title','$content','$user_id','$idforcategory','$name')";
                $result2 = mysqli_query($conn, $sql2);
                if ($result2) {
                    echo "Post added successfully!";
                }
            }
        }
    } else {
        header("Location: dashboard.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Post Page</title>
</head>

<body>
    <form action="insertpost.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Give the post title here" required><br>
        <textarea name="content" placeholder="Write your post here !" required></textarea><br>
        <select name="category_name">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?php echo "{$row['name']}"; ?>">
                <?php echo "{$row['name']}" ?></option>
            <?php
            }
            ?>
        </select><br>

        <input type="file" name="image"><br>
        <input type="submit" value="add post" name="submit">
    </form>
</body>

</html>