<?php
session_start();
$username = "";
$email = "";
$errors = [];

$conn = new mysqli('localhost', 'root', '', 'prax3');


function singUpUser($username, $email, $password) {
    $username = htmlspecialchars($username);
    $email = htmlspecialchars($email);
    $password = htmlspecialchars($password);
    $password = password_hash($password, PASSWORD_DEFAULT); //encrypt password
    $query = "INSERT INTO users SET username=?, email=?, password=?";
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->bind_param('sss', $username, $email, $password);
    $result = $stmt->execute();
    if ($result) {
        $user_id = $stmt->insert_id;
        $stmt->close();

        $_SESSION['id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['message'] = 'You are logged in!';
        $_SESSION['type'] = 'alert-success';
        header('location: index.php');
    } else {
        $_SESSION['error_msg'] = "Database error: Could not register user";
    }
}


function loginUser($username, $password) {
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);
    $query = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $GLOBALS['conn']->prepare($query);
    $stmt->bind_param('s', $username);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && password_verify($password, $user['password'])) { // if password matches
            $stmt->close();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['location'] = $user['location'];
            $_SESSION['description'] = $user['description'];
            $_SESSION["postID"] = null;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            header('location: index.php');
            exit(0);
        } else { // if password does not match
            $errors['login_fail'] = "Wrong username / password";
        }
    } else {
        $_SESSION['message'] = "Database error. Login failed!";
        $_SESSION['type'] = "alert-danger";
    }
}

function find_user_by_id($id){
    try{
        $id = htmlspecialchars($id);
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM `users` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc();
        }
        else{
            return false;
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
}


function find_post($id) {
    try{
        $id = htmlspecialchars($id);
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM `posts` WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc();
        }
        else{
            return false;
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }
}