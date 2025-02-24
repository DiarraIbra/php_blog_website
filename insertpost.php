<?php
session_start();
$user_id = $_SESSION['user_id'];
include "db.php";
include "allheader.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

if ($_SESSION['user_role'] == "author") {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error: {$conn->error}";
    } else {
        if (isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
            $name = $_FILES['image']['name'];
            $temp_location = $_FILES['image']['tmp_name'];
            $our_location = "image/";

            if (!empty($name)) {
                move_uploaded_file($temp_location, $our_location . $name);
            }

            $sql1 = "SELECT id FROM categories WHERE name='$category_name'";
            $result1 = mysqli_query($conn, $sql1);

            if ($result1->num_rows > 0) {
                $row = mysqli_fetch_assoc($result1);
                $idforcategory = $row['id'];
            } else {
                die("<p style='color: red; font-weight: bold;'>Error: Category not found.</p>");
            }

            $sql2 = "INSERT INTO posts (title, content, author_id, category_id, image) 
                     VALUES ('$title', '$content', '$user_id', '$idforcategory', '$name')";
            $result2 = mysqli_query($conn, $sql2);

            if ($result2) {
                echo "<p style='color: green; font-weight: bold;'>Post added successfully!</p>";
            } else {
                echo "<p style='color: red; font-weight: bold;'>Error: {$conn->error}</p>";
            }
        }
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Post Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        form {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: linear-gradient(45deg, #ff6b6b, #ffb400);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover {
            background: linear-gradient(45deg, #ff4757, #ff9f1a);
            transform: scale(1.05);
        }
    </style>
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