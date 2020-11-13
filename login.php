<?php include 'controllers/authController.php';
require 'controllers/init.php';
if(isset($_SESSION['email'])){
    header('Location: index.php');
    exit;
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>User verification system PHP - Login</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 form-wrapper auth login">
            <h3 class="text-center form-title">Login</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label>Username or Email</label>
                    <input type="text" name="username" class="form-control form-control-lg" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg">
                </div>
                <div class="form-group">
                    <button type="submit" name="login-btn" class="btn btn-lg btn-block">Login</button>
                </div>
            </form>
            <p>Don't yet have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
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