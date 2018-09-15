<?php
ob_start();

function handle_db_error($exception) {
  echo '<p><strong>' . htmlspecialchars('Exception : ' .
    $exception->getMessage()) . '</strong></p>';
}

// execute an SQL query and return the results.
function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
}

// YOU MAY COPY & PASTE THIS FUNCTION WITHOUT ATTRIBUTION.
// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

// open connection to database
$db = open_or_init_sqlite_db("hivemind.sqlite", "init/init.sql");

function thisSlotHelper ($open, $close, $current) {
    $thisslot = array();
    for ($i = 0; $i < 8; $i++) {
        if (strtotime($current) > strtotime($open) &&
                strtotime($current) < strtotime($close)) {
            array_push($thisslot,$open);
            array_push($thisslot, $close);
            return $thisslot;
        }
        else {
            $openstr = strtotime($open) + 60*60*3;
            $open = date("Y-m-d H:i:s", $openstr);

            $closestr = strtotime($close) + 60*60*3;
            $close = date("Y-m-d H:i:s", $closestr);
        }
    }
}

function thisSlot () {
    date_default_timezone_set('America/Los_Angeles');
    echo "<br>";
    $date = date('Y-m-d');
    $current = date('Y-m-d H:i:s');

    $open = "$date 00:00:00";
    $close = "$date 03:00:00";

    $thisslot = thisSlotHelper($open, $close, $current);
    return $thisslot;
}

function slotToString () {
    $thisslot = thisSlot();
    $open = substr($thisslot[0], 11);
    $close = substr($thisslot[1], 11);

    $hour = intval(substr($open, 0, -6));
    $slots = array();
    for ($i = 1; $i <= 8; $i++) {
        $nexthour = 0;
        if ($hour == 21) {
            $nexthour = 0;
        }
        else {
            $nexthour = $hour + 3;
        }

        $slot = strval($hour)."_".(strval($nexthour));
        array_push($slots,$slot);

        if ($hour == 21) {
            $hour = 0;
        }
        else {
            $hour += 3;
        }
    }
    return $slots;
}

function isPast($slot) {
    $thisstr = slotToString();
    $thisstr = $thisstr[0];
    $ordered = array("0_3","3_6","6_9","9_12","12_15","15_18","18_21","21_0");
    $key = array_search($slot,$ordered);
    $past = array_slice($ordered, 0, $key+1);
    $future = array_slice($ordered, $key+1);
    return $past;
}

function slotList () {
    $thisslot = thisSlot();
    $open = $thisslot[0];
    $close = $thisslot[1];

    $closemod = strtotime($close) + 60*60*3;
    $newclose = date("Y-m-d H:i:s", $closemod);

    $slots = array();
    for ($i = 1; $i <= 8; $i++) {
        $slot = array();
        array_push($slot,$open);
        array_push($slot,$close);
        array_push($slots,$slot);

        $openmod = strtotime($open) + 60*60*3;
        $open = date("Y-m-d H:i:s", $openmod);

        $closemod = strtotime($close) + 60*60*3;
        $close = date("Y-m-d H:i:s", $closemod);

    }
    return $slots;
}

function flipRoles ($roles,$s,$w,$p) {
    $allroles = array("singer","writer","producer");
    if (!$s) {
        $key = array_search("singer",$allroles);
        unset($allroles[$key]);
    }
    if (!$w) {
        $key = array_search("writer",$allroles);
        unset($allroles[$key]);
    }
    if (!$p) {
        $key = array_search("producer",$allroles);
        unset($allroles[$key]);
    }
    foreach ($roles as $ro) {
        if (in_array($ro,$allroles)) {
            $key = array_search($ro,$allroles);
            unset($allroles[$key]);
        }
    }
    return $allroles;
}

function toRead($tim) {
  if ($tim == "0_3") { return "midnight to 3am"; }
  else if ($tim == "3_6") { return "3am to 6am"; }
  else if ($tim == "6_9") { return "6am to 9am"; }
  else if ($tim == "9_12") { return "9am to noon"; }
  else if ($tim == "12_15") { return "noon to 3pm"; }
  else if ($tim == "15_18") { return "3pm to 6pm"; }
  else if ($tim == "18_21") { return "6pm to 9pm"; }
  else if ($tim == "21_0") { return "9pm to midnight"; }
  else { return $tim; }
}
?>
