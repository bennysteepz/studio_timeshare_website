<?php
ob_start();
session_start();
include('includes/init.php');
include('includes/header.php');

$user = $_SESSION['user'];
$is_singer = $_SESSION['singer'];
$is_writer = $_SESSION['writer'];
$is_producer = $_SESSION['producer'];
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Book</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css"/>
</head>

<body id="book">
<?php
$num_partners = 0;
$parts = array();
$studio = $_GET['studio'];
$open = $_GET['open'];
$close = $_GET['close'];
$date = $_GET['date'];
$str = $_GET['str'];
$isjoin = $_GET['isjoin'];
$role = $_GET['role'];

echo "<p id='greeting'>Hi $user!</p>";
echo "<br>";
?>

<div id="bookinfo">
<?php
$getpartners = $db->query("SELECT `$str` FROM '$studio' WHERE date = '$date'
AND `$str` != ''");

if (!$isjoin) {
    echo "No other people in this session. You are the first to book it!<br>";
}
elseif ($isjoin) {
    echo "People in this session:<br>";
    foreach ($getpartners as $gp) {
        $partner = $gp[$str];
        $getuserrole = $db->query("SELECT role FROM $partner WHERE slot = '$str'
            AND studio = '$studio' AND date = '$date'");
        $userrole = $getuserrole->fetch();
        $urole = $userrole['role'];

        echo $partner." - ".$urole;
        echo "<br>";
        $num_partners += 1;
        array_push($parts,$partner);
    }
}

echo "Book $studio as a $role from $open to $close on $date?";
?>

<form method="POST">
    <input type="submit" name="book" id="bookbtn" value="Book Session!">
</form>

  </div>
<?php
if (isset($_POST['book'])) {
  echo $str;
  echo "isempty??";
    $db->exec("INSERT INTO $studio ('$str',date) VALUES ('$user','$date')");
    $db->exec("INSERT INTO $user (studio,slot,role,date)
        VALUES ('$studio','$str','$role','$date')");

    if ($isjoin) {
        if ($num_partners == 1) {
            $onepart = $parts[0];
            $db->exec("UPDATE $onepart SET partner1 = '$user' WHERE slot = '$str'
                AND studio = '$studio' AND date = '$date'");
            $db->exec("UPDATE $user SET partner1 = '$onepart' WHERE slot = '$str'
                AND studio = '$studio' AND date = '$date'");
        }
        elseif ($num_partners == 2) {
            $firstpart = $parts[0];
            $secondpart = $parts[1];
            $db->exec("UPDATE $firstpart SET partner2 = '$user' WHERE slot = '$str'
                AND studio = '$studio' AND date = '$date'");
            $db->exec("UPDATE $secondpart SET partner2 = '$user' WHERE slot = '$str'
                AND studio = '$studio' AND date = '$date'");
            $db->exec("UPDATE $user SET partner1 = '$firstpart' WHERE slot = '$str'
                AND studio = '$studio' AND date = '$date'");
            $db->exec("UPDATE $user SET partner2 = '$secondpart' WHERE slot = '$str'
                AND studio = '$studio' AND date = '$date'");
        }
    }

    header("location: mysessions.php");
}
?>
</body>
