<?php
session_start();
$username = "";
$email = "";

$conn = new mysqli('localhost', 'root', '', 'prax3');

if (!empty($_POST["comment"])) {

    $content = $_REQUEST["comment"];
    $postId = $_POST["addPostCom"];
    $content = htmlspecialchars($content);
    $postId = htmlspecialchars($postId);
    $myId = $_SESSION['id'];
    $myId = htmlspecialchars($myId);
    $query = "INSERT INTO comments SET user_id=?, post_id=?, content=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $myId, $postId, $content);
    $result = $stmt->execute();
    if ($result) {
        $stmt->close();
        header("location: ../news.php");
    }
}
