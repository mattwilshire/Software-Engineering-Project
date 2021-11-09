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

    if(!isset($_SESSION["accId"])) {
        header('Location: index.php');
        exit();
    }

    require_once '../config.php';
    $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if(mysqli_connect_errno())
    {
        echo "Couldn't connect to the sql database.";
        exit();
    }
?>

<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="transactions.css">
</head>

<body>
    <header>
      <h1>Account Transactions</h1> 
    </header>

    <main>
	<h2>Select account to view transactions:</h2>
	
	<div class="div1">
	<p>Current Account</p>
	<button id="but1" onclick="showCurrent();">Current Account</button>	
	</div>
	
	<div class="div1>
	<p>Savings Account</p>
	<button id= "but2" onclick="showSavings();"> Savings Account</button>
	</div>
		
	<table id="t1"> 
	<caption>Current Account Transactions</caption>
	<tr>
	  <th>Date</th>
	  <th>In/Out</th>
	  <th>Transaction Amount</th>
	  <th>Transaction Message</th>
	</tr>

	<?php

	if($stmt = mysqli_prepare($SQL_Connection, "SELECT * FROM Transactions WHERE accId=?"))
    {
        $stmt->bind_param("i", $accountNumber);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $type = $row['type'];

                if($type == 0) {
                	$type = "In (+)";
                } else {
                	$type = "Out (-)";
                }

                $amount = $row['amount'];
                $message = $row['message'];
                $date = $row['created'];

                echo "<tr>";
                echo "<td>$date</td>";
                echo "<td>$type</td>";
                echo "<td>$amount</td>";
                echo "<td>$message</td>";
                echo "</tr>";
            }
        }
    }


	?>
	
	<!--
	
	<table id="t2">
	<caption>Savings Account Transactions</caption> 
	<tr>
	  <th>Date</th>
	  <th>In/Out</th>
	  <th>Transaction Amount</th>
	  <th>Transaction Message</th>
	  <th>Balance</th>
	</tr>
	<tr>
	  <td>1/11/2021</td>
	  <td>In(+)</td>
	  <td>100.00</td>
	  <td>From Current A/C</td>
	  <td>100.00</td>
	</tr>
	<tr>
	  <td>2/11/2021</td>
	  <td>Out(-)</td>
	  <td>50.00</td>
	  <td>To Current A/C</td>
	  <td>50.00</td>
	</tr>

	</table>-->

	<script>
	  function showCurrent() {
  	    var p = document.getElementById("t1");
	    var displaySetting = p.style.display;
	    var button = document.getElementById('but1');
	    if (displaySetting == 'block') {
	        p.style.display = 'none';
		button.innerHTML = 'Show Transactions';
	    }
	    else{
		p.style.display = 'block';
		button.innerHTML = 'Hide Transactions';
  	    }
	}
	
	function showSavings() {
  	    var p = document.getElementById("t2");
	    var displaySetting = p.style.display;
	    var button = document.getElementById('but2');
	    if (displaySetting == 'block') {
	        p.style.display = 'none';
		button.innerHTML = 'Show Transactions';
	    }
	    else{
		p.style.display = 'block';
		button.innerHTML = 'Hide Transactions';
  	    }
	}

	</script>
    </main>
</body>
