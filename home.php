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
        	<h1 id="accNo">Account No: <span style="font-family: 'Roboto', sans-serif">#<?php echo $accountNumber; ?></span></h1>
        </header>
        <main>
        	<section class="card">
        		<h1>Credit Card</h1>
        		<section class="cardNo"><?php echo $cardNo; ?></section>
        		<section class="bottom-line">
        			<section class="expiry">EXP: <?php echo "0" . $expMonth . "/" . $expYear; ?></section>
        			<section class="cvc">CVC: <?php echo $cvc; ?></section>
        		</section>
        	</section>

        	<section class="options">
        		<h1>Card Options</h1>
        		<a href="/virtualcard.php">RENEW / DISABLE</a>
        	</section>

        </main>
    </body>
</html>