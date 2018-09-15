<?php
ob_start();
session_start();
include('includes/init.php');
include('includes/header.php');

$user = $_SESSION['user'];
$is_singer = $_SESSION['singer'];
$is_writer = $_SESSION['writer'];
$is_producer = $_SESSION['producer'];
date_default_timezone_set('America/Los_Angeles');

echo "<p id='greetingWhite'>Hi $user!</p>";
echo "<br>";
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>My Sessions</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css"/>
</head>

<body id="mysessions">
<?php

$thisslot = thisSlot();
$open = strtotime($thisslot[0]);
$close = strtotime($thisslot[1]);
$now = date('Y-m-d');
$nowstr = strtotime($now);

$thisstr = slotToString();
$thisstr = $thisstr[0];
$ispast = isPast($thisstr);
?>
<div id="sessionsCont">
  <div id="pastCont">
    <h2>Past Sessions:</h2>
    <?php
    $pastFlag = 0;
    $pastbookings = $db->query("SELECT * FROM '$user'");
    foreach ($pastbookings as $pb) {
        $date = $pb['date'];
        $datestr = strtotime($date);
        $slot = $pb['slot'];
        $studio = $pb['studio'];
        $partner1 = $pb['partner1'];
        $partner2 = $pb['partner2'];
        $role = $pb['role'];

        $pstring = "with ";
        if ($partner1 == '') {
            $pstring = "alone";
        }
        elseif ($partner1 != '' && $partner2 == '') {
            $pstring .= $partner1;
        }
        elseif ($partner1 != '' && $partner2 != '') {
            $pstring .= $partner1." and ".$partner2;
        }

        if ($datestr < $nowstr) {
            $pastFlag = 1;
            echo $studio ." ".
              $pstring ." as a ".
              $role ." from ".
              toRead($slot) ." on ".
              $date;
            echo "<br/>";
            echo "<br/>";
        }
        elseif ($datestr == $nowstr) {
            if (in_array($slot,$ispast)) {
            $pastFlag = 1;
            echo $studio ." ".
              $pstring ." as a ".
              $role ." from ".
              toRead($slot) ." on ".
              $date;
            echo "<br/>";
            echo "<br/>";
            }
        }
    }
    if ($pastFlag == 0) {
      echo "No past bookings to show.";
      echo "<br/>";
    }
    ?>
  </div>
  <div id="futureCont">
    <h2>Future Sessions:</h2>
    <?php
    $futureFlag = 0;
    $futurebookings = $db->query("SELECT * FROM '$user'");
    foreach ($futurebookings as $fb) {
        $date = $fb['date'];
        $datestr = strtotime($date);
        $slot = $fb['slot'];
        $studio = $fb['studio'];
        $partner1 = $fb['partner1'];
        $partner2 = $fb['partner2'];
        $role = $fb['role'];

        if ($datestr > $nowstr) {
          $futureFlag = 1;
          echo $studio ." ".
            $pstring ." as a ".
            $role ." from ".
            toRead($slot) ." on ".
            $date;
          echo "<br/>";
          echo "<br/>";
        }
        elseif ($datestr == $nowstr) {
            if (!in_array($slot,$ispast)) {
              $futureFlag = 1;
              echo $studio ." ".
                $pstring ." as a ".
                $role ." from ".
                toRead($slot) ." on ".
                $date;
              echo "<br/>";
              echo "<br/>";
            }
        }
    }
    if ($futureFlag == 0) {
      echo "No future bookings to show.";
      echo "<br/>";
    }
    ?>
  </div>
</div>
</body>
</html>
