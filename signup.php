<?php
include 'controllers/authController.php';
if (isset($_POST['signup-btn'])) {
    $errors = [];
    $email = $_POST['email'];
    $username = $_POST['username'];
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username required';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }
    if (isset($_POST['password']) && $_POST['password'] !== $_POST['passwordConf']) {
        $errors['passwordConf'] = 'The two passwords do not match';
    }
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if (mysqli_num_rows($result) > 0) {
        $errors['email'] = "Email already exists";
    }
    // Check if username already exists
    $sql2 = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result2 = mysqli_query($GLOBALS['conn'], $sql2);
    if (mysqli_num_rows($result2) > 0) {
        $errors['username'] = "Username already exists";
    }
    if(count($errors) === 0){
        singUpUser($_POST['username'],$_POST['email'],$_POST['password']);
    }
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
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-wrapper auth">
            <h3 class="text-center form-title">Register</h3>
            <form action="signup.php" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <label>Password Confirm</label>
                    <input type="password" name="passwordConf" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <button type="submit" name="signup-btn" class="btn btn-lg btn-block">Sign Up</button>
                </div>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>
    <!-- form title -->
    <h3 class="text-center form-title">Register</h3> <!-- or Login -->
    <?php if (count($errors) > 0): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <li>
                    <?php echo $error; ?>
                </li>
            <?php endforeach;?>
        </div>
    <?php endif;?>
</div>
</body>
</html>