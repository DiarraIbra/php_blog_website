<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['post_id'])) {
    die("Post ID is missing!");
}

$post_id = $_GET['post_id'];

if ($_SESSION['user_role'] !== "author") {
    header("Location: dashboard.php");
    exit();
}

// Récupérer les catégories
$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error fetching categories: " . mysqli_error($conn));
}

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    // Gestion de l'image
    $name = $_FILES['image']['name'];
    $temp_location = $_FILES['image']['tmp_name'];
    $our_location = "image/";

    if (!empty($name)) {
        if (!move_uploaded_file($temp_location, $our_location . $name)) {
            die("Image upload failed!");
        }
    }

    // Récupérer l'ID de la catégorie
    $sql1 = "SELECT id FROM categories WHERE name='$category_name'";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $idforcategory = $row['id'];
    } else {
        die("Category not found!");
    }

    // Mettre à jour le post
    $sql2 = "UPDATE posts SET title='$title', content='$content', author_id='$user_id', category_id='$idforcategory' WHERE id='$post_id'";
    $result2 = mysqli_query($conn, $sql2);

    if ($result2) {
        echo "Post updated successfully!";
    } else {
        die("Error updating post: " . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post Page</title>
</head>

<body>
    <form action="updatepost.php?post_id=<?php echo $post_id ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Give the post title here" required><br>
        <textarea name="content" placeholder="Write your post here!" required></textarea><br>
        <select name="category_name">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select><br>
        <input type="file" name="image"><br>
        <input type="submit" value="Update Post" name="submit">
    </form>
</body>

</html>