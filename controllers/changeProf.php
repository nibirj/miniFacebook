<?php
include 'authController.php';
$username = "";
$email = "";
$errors = [];

$conn = new mysqli('localhost', 'root', '', 'prax3');

if (!empty($_POST["description"]) && !empty($_POST["location"])) {
    $userToChange = $_SESSION["id"];
    $descriptionToChange = $_POST["description"];
    $locationToChange = $_POST["location"];
    $descriptionToChange = htmlspecialchars($descriptionToChange);
    $locationToChange = htmlspecialchars($locationToChange);
    $query = "UPDATE users SET description=?, location=? WHERE id='$userToChange'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $descriptionToChange, $locationToChange);
    $result = $stmt->execute();
    if ($result) {
        $stmt->close();
        header("location: ../index.php");
    }
} else if (!empty($_POST["description"])) {
    $userToChange = $_SESSION["id"];
    $descriptionToChange = $_POST["description"];
    $descriptionToChange = htmlspecialchars($descriptionToChange);
    $query = "UPDATE users SET description=? WHERE id='$userToChange'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $descriptionToChange);
    $result = $stmt->execute();
    if ($result) {
        $stmt->close();
        header("location: ../index.php");
    }
} else if (!empty($_POST["location"])) {
    $userToChange = $_SESSION["id"];
    $locationToChange = $_POST["location"];
    $locationToChange = htmlspecialchars($locationToChange);
    $query = "UPDATE users SET  location=? WHERE id='$userToChange'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $locationToChange);
    $result = $stmt->execute();
    if ($result) {
        $stmt->close();
        header("location: ../index.php");
    }
} else {
    header("location: ../index.php");
}