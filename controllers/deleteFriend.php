<?php
session_start();
$username = "";
$email = "";
$errors = [];

$conn = new mysqli('localhost', 'root', '', 'prax3');

if ($_POST["deleteFriend"] > 0) {
    $adder = $_SESSION["id"];
    $adding = $_POST["deleteFriend"];
    $adder = htmlspecialchars($adder);
    $adding = htmlspecialchars($adding);
    $query = "DELETE FROM friends WHERE user1=? and user2=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $adder, $adding);
    $result = $stmt->execute();
    $query2 = "DELETE FROM friends WHERE user1=? and user2=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('ss', $adding, $adder);
    $result2 = $stmt2->execute();
    if ($result && $result2) {
        $stmt->close();
        header("location: ../friends.php");
    }
}
