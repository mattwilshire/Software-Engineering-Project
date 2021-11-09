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

    if(!isset($_SESSION["username"])) {
        header('Location: home.php');
        exit();
    }

    require_once '../config.php';
    $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if(mysqli_connect_errno())
    {
        echo "Couldn't connect to the sql database.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['sendMoney'])) {

            $amount = intval($_POST['amount']);
            $personTo = $_POST['selection'];

            if($amount > 0) 
            {
                // Get the person you are sending to's information
                if($stmt = mysqli_prepare($SQL_Connection, "SELECT accId FROM Users WHERE username=?"))
                {
                    $stmt->bind_param("s", $personTo);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $array = $result->fetch_assoc();
                    if($array == null) {
                        $error = "Username doesn't exist ? Shouldn't be possible.";
                    } else {
                        $personToAccId = $array['accId'];
                        $_SESSION['balance'] -= $amount;
                        
                        if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance = balance + ? WHERE accId=?")) {
                            $stmt->bind_param('is', $amount, $personToAccId);
                            if($stmt->execute()) {
                                if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance = balance - ? WHERE accId=?")) {
                                    $stmt->bind_param('is', $amount, $accountNumber);
                                    if($stmt->execute()) {
                                        $_SESSION['balance'] -= $amount;
                                        $success = "Sent money to $personTo.";
                                    } else {
                                        echo $stmt->error;
                                    }
                                }
                            } else {
                                echo $stmt->error;
                            }
                        }
                    }
                }
            }
        }
    }
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
        	<form method="post" action="">
                <label for="selectUser">Select User</label><br>

                <select name="selection">
                	<option disabled selected>-- Select User --</option>
                    <?php
                        if($stmt = mysqli_prepare($SQL_Connection, "SELECT usernameTo FROM Contacts WHERE username=?"))
                        {
                            $stmt->bind_param("s", $username);
                            if($stmt->execute()) {
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $user = $row['usernameTo'];
                                    echo "<option value='$user'>$user</option>";

                                }
                            }
                        }
                    ?>
                </select><br>
                <a href="adduser.php">Add a User</a><br><br>
                
                <label for="amount">Amount to send</label><br>
                <input type="number" id="amount" name="amount" min="1"><br>
                <input type="submit" name="sendMoney" value="Send"><br>

                <?php
                    if(isset($success)) {
                        echo "<p class='success'>$success</p>";
                    }
                ?>
                
            </form>
        	
				<a href="home.php">Return Home.</a>
        </main>
    </body>
</html>