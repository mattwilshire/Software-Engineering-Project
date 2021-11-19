<?php
	session_start();

    if(!isset($_SESSION['username'])) {
        header("Location: /index.php");
        exit();
    }

    $username = $_SESSION['username'];
    $accountNumber = $_SESSION['accId'];
    $balance = $_SESSION['balance'];
    $cardNo = $_SESSION['cardNo'];
    $expMonth = $_SESSION['expMonth'];
    $expYear = $_SESSION['expYear'];
    $cvc = $_SESSION['cvc'];
    $created = $_SESSION['created'];
	//need to be added to db
	$USDBalance = $_SESSION['USDBalance'];
	$GBPBalance = $_SESSION['GBPBalance'];

	$EURUSD = 1.15;
	$EURGBP = 0.85;
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../config.php';
        $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        if(mysqli_connect_errno())
        {
            echo "Couldn't connect to the sql database.";
            exit();
        }

		if(isset($_POST['buy'])) {
			$currency = $_POST['currency'];
			$balance = intval($balance) - intval($_POST['amount']);
			if ($currency == "USD") {
				$USDBalance += intval($_POST['amount']) * $EURUSD;
				if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance=?, USDBalance=? WHERE accId=?")) {
					$stmt->bind_param('iis', $balance, $USDBalance, $accountNumber);
					if($stmt->execute()) {
						echo "Success1 !";
						$_SESSION['USDBalance'] = $USDBalance;
					} else {
						echo $stmt->error;
					}
					$stmt->close();
				}
			}
			if ($currency == "GBP") {
				$GBPBalance += intval($_POST['amount']) * $EURGBP;
				if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance=?, GBPBalance=? WHERE accId=?")) {
					$stmt->bind_param('iis', $balance, $GBPBalance, $accountNumber);
					if($stmt->execute()) {
						echo "Success !";
					} else {
						echo $stmt->error;
					}
					$stmt->close();
				}
			}
		}
		
		if(isset($_POST['sell'])) {
			$currency = $_POST['currency'];
			if ($currency == "USD") {
				$USDBalance -= intval($_POST['amount']);
				$balance += intval($_POST['amount']) / $EURUSD;
				if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance=?, USDBalance=? WHERE accId=?")) {
					$stmt->bind_param('iis', $balance, $USDBalance, $accountNumber);
					if($stmt->execute()) {
						echo "Success !";
					} else {
						echo $stmt->error;
					}
					$stmt->close();
				}
			}
			if ($currency == "GBP") {
				$GBPBalance -= intval($_POST['amount']);
				$balance += intval($_POST['amount']) / $EURGBP;
				if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance=?, GBPBalance=? WHERE accId=?")) {
					$stmt->bind_param('iis', $balance, $GBPBalance, $accountNumber);
					if($stmt->execute()) {
						echo "Success !";
					} else {
						echo $stmt->error;
					}
					$stmt->close();
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Exchange Currency</title>
		<meta name="viewport", content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<header>
			<h1>Exchange Currencies</h1>
		</header>
		<main>
			<form method="post" action="/exchange">
				<label for="amount">Amount:</label>
				<input type="tel" id="amount" name="amount" min="0" max="<?php $balance ?>">
				
				<select name="currency" id="choosecurrency">
					<option value="USD">U.S. Dollar</option>
					<option value="GBP">Pound Sterling</option>
				</select><br>

				<input type="submit" name="buy" value="Buy">
				<input type="submit" name="sell" value="Sell">
			</form>
			<table>
				<tr>
					<th>Currency</th>
					<th>Rate</th>
					<th>Balance</th>
				</tr>
				<tr>
					<th>U.S. Dollar</th>
					<th><?php echo $EURUSD; ?></th>
					<th><?php echo $USDBalance; ?></th>
				</tr>
				<tr>
					<th>Pound Sterling</th>
					<th><?php echo $EURGBP; ?></th>
					<th><?php echo $GBPBalance; ?></th>
				</tr>
			</table>
			<a href="home.php">Back to home</a>
		</main>
	</body>
</html>