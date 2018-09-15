<?php
ob_start();
session_start();
include('includes/init.php');
include('includes/header.php');

$user = $_SESSION['user'];
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Manager</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css"/>
</head>

<body id = "managerhome">
<?php
echo "<p id='greeting'>Hi $user!</p>";
echo "<br>";
?>
<h2>All Studios:</h2>

<?php
$studios = $db->query("SELECT name FROM studios ORDER BY ID ASC");
echo "<ul id = 'studiotable'>";
$studList = [];
foreach ($studios as $studio) {
    echo "<li id='studiolist'>".$studio['name']."</li>";
    array_push($studList,$studio['name']);
}
echo "</ul>";
?>

<h2>Add a Studio:</h2>
<form id = "addStudioForm" method="GET">
    <label id="managerLabel">Studio Name:</label><br>
    <input type="text" class="bar" name="studioname"><br>
    <input type="submit" id="managerBtn" value="Add Studio">
</form>
<?php


if (isset($_GET['studioname'])) {
    $studioname = filter_var($_GET['studioname'], FILTER_SANITIZE_STRING);
    $studioname = preg_replace('/\s+/', '', $studioname);

    if (in_array($studioname,$studList)) {
      echo "<p id='warning'>Studio name taken!</p>";
    }
    else {
      $db->exec("INSERT INTO studios (name) VALUES ('$studioname')");

      $sql = "CREATE TABLE $studioname (
      ID integer NOT NULL,
      `0_3` text,
      `3_6` text,
      `6_9` text,
      `9_12` text,
      `12_15` text,
      `15_18` text,
      `18_21` text,
      `21_0` text,
      date date NOT NULL,
      PRIMARY KEY (ID)
      )";
      $db->exec($sql);

      header("Location: managerhome.php");
    }
}

?>
</body>
