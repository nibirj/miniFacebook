<?php
include 'controllers/authController.php';
$all_my_friends = [];
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
        <div class="col-md-4 offset-md-4 home-wrapper">
            <h2>If you want to find a friend type below :)</h2>
            <!-- Display messages -->
            <form method="post">
                Search: <input type="text" class="search-box" name="term" /><br />
                <input type="submit" name="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>
<div id="results-container" class="float-left friendContainerLeft">
    <?php
    $conn = new mysqli('localhost', 'root', '', 'prax3');
    $stmt = $conn->query("SELECT * FROM friends");
    if ($stmt -> num_rows > 0) {
    while ($row = $stmt->fetch_assoc()) {
        if ($row["user1"] ==  $_SESSION["id"]) {
            array_push($all_my_friends, $row["user2"]);
            }
        }
    }
    if (!empty($_REQUEST['term'])) {
        $username = ($_POST['term']);
        $username = htmlspecialchars($username);
        $stmt = $conn->query("SELECT * FROM users");
        if ($stmt -> num_rows > 0) { ?>
            <h2>Search friends:</h2>
     <?php
            while ($row = $stmt->fetch_assoc()) {
                if (strpos(strtolower($row["username"]), strtolower($username)) !== false && $row["id"] != $_SESSION["id"] && !in_array($row["id"], $all_my_friends)
                    || strpos(strtolower($row["location"]), strtolower($username)) !== false && $row["id"] != $_SESSION["id"] && !in_array($row["id"], $all_my_friends)) {?>
                    <ul class="comment3 text-center">
                        <li>Name: <?php echo $row["username"]?></li>
                        <li>Email: <?php echo $row["email"]?></li>
                        <li><form action="controllers/addFriend.php" method="post"><button name="addFriend" value="<?php echo $row["id"]?>">Add friend</button></form></li>
                    </ul>
                <?php
                }
            }
        } else {
    ?> <h2>No such user.</h2>
            <?php
        }
    }
    ?>
</div>
<div id="results-container" class="float-right friendContainerRight">
    <h2>My friends:</h2>
    <?php
    $conn = new mysqli('localhost', 'root', '', 'prax3');
    $stmt = $conn->query("SELECT * FROM friends");
    if ($stmt -> num_rows > 0) {
        while ($row = $stmt->fetch_assoc()) {
            if ($row["user1"] ==  $_SESSION["id"]) {
                $my_fiend = find_user_by_id($row["user2"]); ?>
            <ul class="comment3 text-center">
                <li class="user_box"><span><a>Name: <?php echo $my_fiend["username"]?></a></li>
                <li class="user_box"><span><a>Email: <?php echo $my_fiend["email"]?></a></li>
                <li><form action="controllers/deleteFriend.php" method="post"><button name="deleteFriend" value="<?php echo $row["user2"]?>">Remove friend</button></form></li>
            </ul>
            <?php }
        }
    }
    ?>
</div>
</body>
</html>
