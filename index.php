<?php
include('includes/header.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css"/>
</head>
<body id="index">
    <div id="frm">
        <h1>HIVEMIND</h1>
        <form action="process.php" method="POST">
            <p>
                <label>Username:<br></label>
                <input type="text" class="bar" name="user">
            </p>
            <p>
                <label>Password:<br></label>
                <input type="password" class="bar" name="pass">
            </p>
            <p>
                <input type="submit" class="btn" value="Login">
            </p>
        </form>
    </div>
</body>
</html>
