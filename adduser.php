<?php
	// All of these values are stored upon login, you can now use them in any page just copy this code.
	session_start();
	$username = $_SESSION['username'];
	$accountNumber = $_SESSION['accId'];
	$balance = $_SESSION['balance'];
	$cardNo = $_SESSION['cardNo'];
	$expMonth = $_SESSION['expMonth'];
	$expYear = $_SESSION['expYear'];
	$cvc = $_SESSION['cvc'];
	$created = $_SESSION['created'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add a User</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
        	<h1>Add a user</h1>
        </header>
        <main>
        		<a href="sendmoney.php" id="back">< Back.</a>
        		<form method="post" action="/">
                <label for="selectUser">Enter a username:</label><br>
                <input type="text" id="username" name="username" ><br>
                <input type="submit" name="addUser" value="Add"><br>
                
            </form>
        	
				<a href="home.php">Return Home.</a>
        </main>
    </body>
</html>