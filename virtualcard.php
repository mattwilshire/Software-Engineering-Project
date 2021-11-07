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

        // Clicked disable card
        if(isset($_POST['enableCard'])) {
            $disable = 0;
            if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET disabled=? WHERE accId=?"))
            {
                $stmt->bind_param("ss", $disable, $accountNumber);
                if($stmt->execute()) {
                    echo "Card Enabled !";
                    $_SESSION['disabledCard'] = 0;
                } else {
                    echo $stmt->error;
                }

                $stmt->close();
            }
        }
        else if(isset($_POST['disableCard'])) {
            $disable = 1;
            if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET disabled=? WHERE accId=?"))
            {
                $stmt->bind_param("ss", $disable, $accountNumber);
                if($stmt->execute()) {
                    echo "Card Disabled !";
                    $_SESSION['disabledCard'] = 1;
                } else {
                    echo $stmt->error;
                }

                $stmt->close();
            }
        } else if(isset($_POST['renewCard'])) {
            $randCardNo = rand(1000, 9999);
            $cardNo = "1111 2222 3333 " . $randCardNo;

            if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET cardNo=?, cvc=? WHERE accId=?"))
            {
                $stmt->bind_param("sss", $cardNo, $cvc, $accountNumber);
                if($stmt->execute()) {
                    echo "Card changed!!";
                    $_SESSION['cardNo'] = $cardNo;
                    $_SESSION['cvc'] = $cvc;
                } else {
                    echo $stmt->error;
                }

                $stmt->close();
            }
        }

    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Virtual Card</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <header>
        	<h1>Virtual Card</h1>
            <h2><a href="/index.php">Go Back</a></h2>
        </header>
        <main>
            <form action="/virtualcard.php" method="POST">
                <h3>Would you like to enable / disable your virtual card?: <h3>
                <?php
                    if(isset($_SESSION['disabledCard'])) {
                        if($_SESSION['disabledCard'] == 1) {
                            echo "<input type='submit' name='enableCard' value='Enable Card'>";
                        } else {
                            echo "<input type='submit' name='disableCard' value='Disable Card'>";
                        }
                    }
                ?>
            </form>

            <form action="/virtualcard.php" method="POST">
                <h3>Would you like to renew your virtual card?: <h3>
                <input type="submit" name="renewCard" value="Renew Card"></button>
            </form>
        </main>
    </body>
</html>