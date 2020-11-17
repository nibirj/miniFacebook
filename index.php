<?php
include 'controllers/authController.php';
// redirect user to login page if they're not logged in
if(isset($_SESSION['id']) && isset($_SESSION['email'])) {
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
<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-6 B home-wrapper rowfix">
            <!-- Display messages -->
            <div class="text-center">
                <img src="assets/prof.jpg" width="175" height="150">
            </div>
            <h2>Welcome, <?php echo $user_data['username']; ?></h2>
            <h4>Email: <?php echo $user_data['email']; ?></h4>
            <h4>Location: <?php echo $user_data['location']; ?></h4>
            <div class="text-center">
                <p>Location<Br>
                <form name="test" method="post" action="controllers/changeProf.php">
                        <textarea class="description" name="location" cols="20" rows="1"></textarea></p>
                    <p><input type="submit" value="submit">
                        <input type="reset" value="reset"></p>
                </form>
            </div>
            <h4 style="word-wrap: break-word;">Description: <?php echo $user_data['description']; ?></h4>
            <div class="text-center">
                <form  name="test" method="post" action="controllers/changeProf.php">
                    <p>Description<Br>
                        <textarea maxlength = "200" class="description" name="description" cols="40" rows="3"></textarea></p>
                    <p><input type="submit" value="submit">
                        <input type="reset" value="reset"></p>
                </form>
            </div>
        </div>
        <div id="results-container" class="col-md-4 col-lg-3 G">
            <h2>My posts:</h2>
            <?php
            $conn = new mysqli('localhost', 'root', '', 'prax3');
            $stmt = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
            if ($stmt -> num_rows > 0) {
                while ($row = $stmt->fetch_assoc()) {
                    if ($row["userPost"] == $_SESSION["id"]) {
                        $human = find_user_by_id($row["userPost"]);
                        $post_id = $row["id"];
                        $query = "SELECT COUNT(*) FROM reactions WHERE post_id ='$post_id'";
                        $size_result = $conn->query($query)->fetch_array(); ?>
                        <ul class="comment2">
                            <li>Author: <?php echo $human["username"]?></li>
                            <li><?php echo $row["post"]?></li>
                            <li class="user_box"><form action="comment.php" method="post"><button name="addComment" value="<?php echo $row["id"] ?>">View comments</button></form></li>
                            <li><form action="controllers/likePost.php" method="post"><a>Likes: <?php echo $size_result[0]?></form></li>
                            <li>Date: <?php echo $row["created_at"]?></li>
                        </ul>
                    <?php }
                }
            } else { ?>
                <h2>No posts have been made by you or your friends.</h2>
                <?php
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
