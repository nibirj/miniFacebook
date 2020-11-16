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
        <div class="col-md-4 offset-md-4 home-wrapper">
            <!-- Display messages -->
            <h2>Welcome, <?php echo $user_data['username']; ?></h2>
            <h4>Email: <?php echo $user_data['email']; ?></h4>
            <h4>Location: <?php echo $user_data['location']; ?></h4>
            <h4>Description: <?php echo $user_data['description']; ?></h4>
        </div>
    </div>
</div>
<div class="text-center">
    <form  name="test" method="post" action="controllers/changeProf.php">
        <p>Description<Br>
            <textarea name="description" cols="40" rows="3"></textarea></p>
        <p><input type="submit" value="submit">
            <input type="reset" value="reset"></p>
        <p>Location<Br>
            <textarea name="location" cols="20" rows="1"></textarea></p>
        <p><input type="submit" value="submit">
            <input type="reset" value="reset"></p>
    </form>
</div>
</body>
</html>
