<?php
	// All of these values are stored upon login, you can now use them in any page just copy this code.
	session_start();
	$username = $_SESSION['username'];
	$accountNumber = $_SESSION['accId'];
	$cardNo = $_SESSION['cardNo'];
	$expMonth = $_SESSION['expMonth'];
	$expYear = $_SESSION['expYear'];
	$cvc = $_SESSION['cvc'];
	$created = $_SESSION['created'];
	$disabledCard = $_SESSION['disabledCard'];

	if(!isset($_SESSION['username'])) {
        header("Location: /index.php");
        exit();
    }

    require_once '../config.php';
    //Connect to the database using the variables from the config file
    $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    //Check if the connection was successful
    if(mysqli_connect_errno())
    {
        echo "Couldn't connect to the sql database.";
        exit();
    }

    //Always update balance when user goes to home screen.
    if($stmt = mysqli_prepare($SQL_Connection, "SELECT balance, USDBalance, GBPBalance FROM Accounts WHERE accId=?"))
    {
        $stmt->bind_param("s", $accountNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = $result->fetch_assoc();
        if($array != null) {
            $_SESSION["balance"] = $array['balance'];
            $_SESSION['USDBalance'] = $array['USDBalance'];
            $_SESSION['GBPBalance'] = $array['GBPBalance'];
        }
        $stmt->close();
    } else {
    	echo "stmt";
    }

    $balance = $_SESSION['balance'];
    $USDBalance = $_SESSION['USDBalance'];
	$GBPBalance = $_SESSION['GBPBalance'];
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
        	<section class="balance">
                <h1>Balance</h1>
                <section>
                	<section>
	                    <h1>Euro</h1>
	                    <h2><?php echo $balance; ?></h2>
	                </section>
	                <section>
	                    <h1>USD</h1>
	                    <h2><?php echo $USDBalance; ?></h2>
	                </section>
	                <section>
	                    <h1>GBP</h1>
	                    <h2><?php echo $GBPBalance; ?></h2>
	                </section>
                </section>

           </section>

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
        		<a href="/addfunds.php">ADD MONEY</a>
        		<a href="/sendmoney.php">SEND MONEY</a>
        		<a href="/virtualcard.php">RENEW / DISABLE</a>
        		<a href="/exchange.php">CURRENCY EXCHANGE</a>
        	</section>

        </main>
    </body>
</html>