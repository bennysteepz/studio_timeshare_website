<?php
session_start();
ob_start();
include('includes/init.php');
// Get values passed from form in newaccount.php file

$newuser = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
$newpass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
$newpass2 = filter_var($_POST['pass2'], FILTER_SANITIZE_STRING);

if (isset($_POST['skill'])) {
    $skill = $_POST['skill'];
}

$art = 0;
$writ = 0;
$prod = 0;

if (isset($skill)) {
    foreach ($skill as $sk) {
        if ($sk == "singer") {
            $art = 1;
        }
        elseif ($sk == "writer") {
            $writ = 1;
        }
        elseif ($sk == "producer") {
            $prod = 1;
        }
    }
}

if ($newuser == null || $newpass == null ||
   $newpass2 == null || ($art == 0 && $writ == 0 && $prod == 0)) {//maybe todo: which field left blank
    echo "One or more field left blank.";
    header ("Refresh: 1; newaccount.php");
}
elseif ($newpass != $newpass2) {
    echo "Passwords do not match.";
    header ("Refresh: 1; newaccount.php");
}
else {
    $newpass = password_hash($newpass, PASSWORD_DEFAULT);//hash the password after checks because hashes aren't same
    $sql = "INSERT INTO users (username,password,singer,writer,producer)
        VALUES ('$newuser','$newpass','$art','$writ','$prod')";
    $db->exec($sql);

    $sql = "CREATE TABLE $newuser (
      ID integer NOT NULL,
      studio text,
      slot text,
      partner1 text,
      partner2 text,
      role text,
      date date,
      PRIMARY KEY(ID)
    );";
    $db->exec($sql);

    echo "Success! Back to log in...";
    header ("Refresh: 1; index.php");
}
?>
