<?php
include 'controllers/authController.php';
// redirect user to login page if they're not logged in
if(isset($_POST["addComment"])) {
    $_SESSION["postID"] = $_POST["addComment"];
    $postId = $_POST["addComment"];
} else {
    $postId = $_SESSION["postID"];
}

if(isset($_SESSION['id']) && isset($_SESSION['email'])) {
    $post = find_post($postId);
    $user_data = find_user_by_id($_SESSION['id']);
    if($user_data ===  false){
        header('Location: logout.php');
        exit;
    }
}
if (empty($_SESSION['id'])) {
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>User verification system PHP</title>
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Fakebook</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="index.php">Profile</a>
        <a class="p-2 text-dark" href="friends.php">Friends</a>
        <a class="p-2 text-dark" href="news.php">News</a>
    </nav>
    <a class="btn btn-outline-primary" href="logout.php">Logout</a>
</div>
<h1 class="text-center">Post: "<?php echo $post["post"]?>"</h1>
<div class="text-center">
    <form name="test" method="post" action="controllers/addComment.php">
        <p>Add comment<Br>
            <textarea name="comment" cols="40" rows="3"></textarea></p>
        <p><button name="addPostCom" value="<?php echo $postId?>">Add comment</button></p>
        <p><input type="reset" value="reset"></p>
    </form>
</div>
<div class="text-center commentOwner">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'prax3');
        $stmt = $conn->query("SELECT * FROM comments ORDER BY created_at DESC LIMIT 25");
        if ($stmt -> num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                if ($row["post_id"] ==  $postId) {
                    $user = find_user_by_id($row["user_id"]);  ?>
    <ul class="comment2">
                    <li>Name: <?php echo $user["username"]?></li>
                    <li class="user_box"><span>Says: <?php echo $row["content"] ?></li>
                    <li> <?php echo $row["updated_at"]?></li>
    </ul>
                    <?php
                }
            }
        }
        ?>
</div>
</body>
</html>
