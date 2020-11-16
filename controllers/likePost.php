<?php
session_start();
$username = "";
$email = "";

$conn = new mysqli('localhost', 'root', '', 'prax3');
$post_id = $_POST["likePost"];
$user_id = $_SESSION["id"];
$post_id = htmlspecialchars($post_id);
$user_id = htmlspecialchars($user_id);
$query2 = "SELECT * FROM reactions WHERE post_id='$post_id' and user_id='$user_id'";
$result2  = $conn->query($query2);
if ($result2->num_rows > 0) {
    $query = "DELETE FROM reactions WHERE post_id=? and user_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $post_id, $user_id);
    $result = $stmt->execute();
    if ($result) {
        $stmt->close();
    }
    header("location: ../news.php");
    exit(0);
}
$query = "INSERT INTO reactions SET post_id=?, user_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $post_id, $user_id);
$result = $stmt->execute();
if ($result) {
    header("location: ../news.php");
    exit(0);
}
