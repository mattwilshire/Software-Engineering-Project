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
        <title>Send Money</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
        	<h1>Send money to another user</h1>
        </header>
        <main>
        		<form method="post" action="/">
                <label for="selectUser">Select User</label><br>
                <select>
                	<option disabled selected>-- Select User --</option>
                	<!--- some php to retrieve added users from db --->
                </select><br>
                <a href="adduser.php">Add a User</a><br><br>
                
                <label for="amount">Amount to send</label><br>
                <input type="number" id="amount" name="amount" min="1"><br>
                <input type="submit" name="sendMoney" value="Send"><br>
                
            </form>
        	
				<a href="home.php">Return Home.</a>
        </main>
    </body>
</html>