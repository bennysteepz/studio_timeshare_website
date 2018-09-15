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
    <title>Studios</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css"/>
</head>

<body id = "userhome">
<?php
echo "<p id='greetingWhite'>Hi $user!</p>";
?>

<p class="h2white">Click a role in a cell below to book a studio!</p>
<?php
$slotstr = slotToString();
$slotlist = slotList();

echo "<table id = 'usertable'>";

echo "<tr>";
echo "<th>Studio</th>";
foreach ($slotlist as $sl) {

    $open = $sl[0];
    $close = $sl[1];
    $opendate = substr($open, 0, 10);
    $closedate = substr($close, 0 , 10);
    $opentime = substr($open, 11);
    $closetime = substr($close, 11);
    $slotname = $opentime." to ".$closetime." ".$opendate;

    echo "<th>$slotname</th>";
}
echo "</tr>";

$studios = $db->query("SELECT name FROM studios ORDER BY ID ASC");
foreach ($studios as $stud) {
    $studio = $stud['name'];

    $liveinfo = $db->query("SELECT * FROM $studio");
    $getliveinfo = $liveinfo->fetch();

    echo "<tr>";
    echo '<td>'.$studio.'</td>';
    $i = 0;

    foreach ($slotstr as $str) {

        $open = $slotlist[$i][0];
        $close = $slotlist[$i][1];
        $opendate = substr($open, 0, 10);
        $closedate = substr($close, 0 , 10);
        $opentime = substr($open, 11);
        $closetime = substr($close, 11);

        $sql = "SELECT `$str` FROM '$studio' WHERE date = '$opendate' AND `$str` != ''";
        $records = exec_sql_query($db, $sql, array())->fetchAll();

        if (empty($records)) {
            $getpartners = $db->query("SELECT * FROM '$studio' WHERE date = '$opendate'
            AND '$str' <> null");
            //print_r($getpartners);
            //echo "<br>";


            $roles = array();
            foreach ($getpartners as $gp) {
                $partner = $gp[$str];
                print($partner);

                $getrole = $db->query("SELECT role FROM '$partner' WHERE slot = '$str' AND
                    studio = '$studio' AND date = '$opendate'");
                $role = $getrole->fetch();
                $role = $role['role'];
                array_push($roles,$role);
            }
            //print_r($roles);

            $partnerstr = "";
            $flippedroles = flipRoles($roles,$is_singer,$is_writer,$is_producer);

            foreach ($flippedroles as $fr) {
                $partnerstr .= '<a href="book.php?studio='.$studio.'&open='.$opentime.'
                    &close='.$closetime.'&date='.$opendate.'&str='."$str".'&
                        isjoin='.false.'&role='.$fr.'">'.$fr.'<br></a>';
            }

            if ($partnerstr != "") {
                echo '<td>'.$partnerstr.'</td>';
            }
            else {
                echo '<td>Booked</td>';
            }
        }

        if (!empty($records)) {
            $getpartners = $db->query("SELECT * FROM '$studio' WHERE date = '$opendate'
            AND `$str` != ''");

            $doublebook = 0;
            $roles = array();

            foreach ($getpartners as $gp) {
                $partner = $gp[$str];

                $getrole = $db->query("SELECT role FROM '$partner' WHERE slot = '$str' AND
                    studio = '$studio' AND date = '$opendate'");
                $role = $getrole->fetch();
                $role = $role['role'];
                array_push($roles,$role);

                if ($partner == $user) {
                    $doublebook = 1;
                }

            }
            $partnerstr = "";
            $flippedroles = flipRoles($roles,$is_singer,$is_writer,$is_producer);
            foreach ($flippedroles as $fr) {
                $partnerstr .= '<a href="book.php?studio='.$studio.'&open='.$opentime.'
                    &close='.$closetime.'&date='.$opendate.'&str='.$str.'&
                        isjoin='.true.'&role='.$fr.'">'.$fr.'<br></a>';
            }

            if ($doublebook == 1) {
                echo '<td>Booked</td>';
            }
            elseif ($partnerstr != "") {
                echo '<td>'.$partnerstr.'</td>';
            }
            else {
                echo '<td>Booked</td>';
            }
        }

        $i += 1;
    }
    echo "</tr>";
}
echo "</table>";

?>
</body>
