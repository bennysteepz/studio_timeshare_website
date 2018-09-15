<?php
session_start();
ob_start();
include('includes/init.php');
// Get values passed from form in index.html file
$user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

$result = $db->query("SELECT * FROM users WHERE username = '$user'");//don't need to check if password matches
$row = $result->fetch();

if($row && password_verify($pass, $row['password'])){//check if row is set then check password in one line
    $is_singer = $row['singer'];
    $is_writer = $row['writer'];
    $is_producer = $row['producer'];
    $_SESSION['user'] = $user;
    $_SESSION['singer'] = $is_singer;
    $_SESSION['writer'] = $is_writer;
    $_SESSION['producer'] = $is_producer;

    echo "Login Successful! Welcome ".$row['username']." :)";
    if ($user == "manager") {
        header ("Refresh: 1; managerhome.php");
    }
    else {
        header ("Location: userhome.php");
    }
} else {
    echo "Failed to login.";
    header ("Refresh: 1; index.php");
}
?>
