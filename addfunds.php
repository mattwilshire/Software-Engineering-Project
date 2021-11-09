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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../config.php';
        $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        if(mysqli_connect_errno())
        {
            echo "Couldn't connect to the sql database.";
            exit();
        }

		if(isset($_POST['addfunds'])) 
		{
			if(isset($_POST['amount'])) 
			{
				$amount = intval($_POST['amount']);
				$balance += intval($_POST['amount']);
		
				if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance=? WHERE accId=?"))
				{
					$stmt->bind_param('is', $balance, $accountNumber);
					if($stmt->execute()) {
						if($stmt = mysqli_prepare($SQL_Connection, "INSERT INTO Transactions (accid, type, message, amount) VALUES (?, ?, ?, ?)")) {
		                    $type = 0;
		                    $message = "Added money using credit / debit card.";
		                    $stmt->bind_param('iisi', $accountNumber, $type, $message, $amount);
		                    if($stmt->execute()) {
		                        echo "Added Funds !";
		                    }
		                } else {
		                    echo $stmt->error;
		                }
					} 
					else 
					{
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
		<title>Add Funds</title>
		<meta name="viewport", content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<header>
			<h1>Add funds to account.</h1>
		</header>
		<main>
			<form method="post" action="addfunds.php">
				<label for="amount">Amount:</label>
				<input type="payment" id="amount" name="amount" min="0"><br>
				<label for="cardnumber">Card Number:</label>
				<input type="tel" id="cardnumber" name="cardnumber" placeholder="XXXXXXXXXXXXXXXX" maxlength="16"><br>
				<label for="cvvcvc">CVV/CVC:</label>
				<input type="tel" id="cvvcvc" name="cvvcvc" maxlength="4"><br>
				<span>
					<label for="cardmonth">Expiry date:</label?>
					<input type="tel" id="cardmonth" name="cardmonth" placeholder="MM" maxlength="2" size="2" />
					<span>/</span>
					<input type="tel" id="cardyear" name="cardyear" placeholder="YY" maxlength="2" size="2" />
				</span> <br>
				<input type="submit" name="addfunds" value="Add funds">
			</form>
			<a href="home.php">Back to home</a>
		</main>
	</body>
</html>