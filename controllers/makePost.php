<?php
include 'authController.php';
$username = "";
$email = "";
$errors = [];

$conn = new mysqli('localhost', 'root', '', 'prax3');

if(!empty($_POST["newPost"])) {
    $userWhosPost = $_SESSION["id"];
    $post = $_POST["newPost"];
    $userWhosPost = htmlspecialchars($userWhosPost);
    $post = htmlspecialchars($post);
    $query = "INSERT INTO posts SET userPost=?, post=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $userWhosPost, $post);
    $result = $stmt->execute();
    if($result) {
        $stmt->close();
        header("location: ../news.php");
    }
}
