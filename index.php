<?php
include 'controllers/authController.php';
// redirect user to login page if they're not logged in
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
<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 home-wrapper">
            <!-- Display messages -->
            <h4>Welcome, <?php echo $_SESSION['username']; ?></h4>
            <a href="logout.php" style="color: red">Logout</a>
            <form method="post">
                Search: <input type="text" class="search-box" name="term" /><br />
                <input type="submit" name="submit" value="Submit" />
            </form>
        </div>
    </div>
</div>
<div id="results-container">
<?php
$conn = new mysqli('localhost', 'root', '', 'prax3');
if (!empty($_REQUEST['term'])) {
    $username = ($_POST['term']);
    $query = "SELECT * FROM users WHERE username LIKE '%".$username."%'";
    $stmt = $conn->prepare($query);
    //$stmt->bind_param('s', $username);
    if ($stmt -> execute()) {
        $result = $stmt->get_result();
        "<ul>";
        mysqli_fetch_row($result);
        while ($row = $result->fetch_assoc()) {
            if ($row["id"] !== $_SESSION["id"]) {
                echo "<table id='suggest'><tr><td id='friendData'>Name: <a href='http://localhost/prax3/userprofile.php'>".$row['username']."<a/></td><br></tr></table>";
                echo "<li>Email: " . $row["email"] ."</li>";
            }
        }
        "<ul />";
    }
}
?>
</div>
</body>
</html>
