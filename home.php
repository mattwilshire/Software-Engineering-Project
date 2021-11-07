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
	$disabledCard = $_SESSION['disabledCard'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/home.css">
    </head>
    <body>
        <header>
        	<h1>Welcome, <?php echo $username; ?></h1>
        	<h1 id="accNo">Account No: #<?php echo $accountNumber; ?></h1>
        </header>
        <main>
        	<h2>Card Number: <span class="value"><?php echo $cardNo; ?></span></h2>
        	<h2>Expiry Month: <span class="value"><?php echo $expMonth; ?></span></h2>
        	<h2>Expiry Year: <span class="value"><?php echo $expYear; ?></span></h2>
        	<h2>CVC: <span class="value"><?php echo $cvc; ?></span></h2>

        	<a href="/virtualcard.php">Renew / Disable Card</a>

        </main>
    </body>
</html>