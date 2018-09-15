<?php
include('includes/header.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="/styles/all.css"/>
</head>
<body id="newacc">
    <div id="frm">
        <form action="processaccount.php" method="POST">
            <p>
                <label>Username:</label><br>
                <input type="text" class="bar" name="user">
            </p>
            <p>
                <label>Password:</label><br>
                <input type="password" class="bar" name="pass">
            </p>
            <p>
                <label>Retype password:<br></label>
                <input type="password" class="bar" name="pass2">
            </p>

            <label>I am a:</label><br>
            <div id="roles">
              <p id="s">Singer</p>
              <p id="w">Writer</p>
              <p id="p">Producer</p>
            </div>
            <div class="checkCont">
                <div class="checkbox">
                    <input type="checkbox" id="skill1" name="skill[]" value="singer">
                    <label for="skill1"></label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="skill2" name="skill[]" value="writer">
                    <label for="skill2"></label>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="skill3" name="skill[]" value="producer">
                    <label for="skill3"></label>
                </div>
            </div>
            <input type="submit" class="btn" value="Create Account">
        </form>
    </div>
</body>
</html>
