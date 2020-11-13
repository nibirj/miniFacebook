<?php ?>

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
        <div class="col-md-4 offset-md-4 home-wrapper">
            <!-- Display messages -->
            <h4>Welcome, to <?php echo $_GET['id']; ?> profile.</h4>
            <a href="logout.php" style="color: red">Logout</a>
        </div>
    </div>
</div>

