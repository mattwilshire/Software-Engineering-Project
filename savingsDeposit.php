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

    if(isset($_POST['submit'])) {
        require_once '../config.php';
        $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if(mysqli_connect_errno())
        {
            echo "Couldn't connect to the sql database.";
            exit();
        }

        $amount = intval($_POST['deposit']);
        $message = $_POST['depositmsg'];

        if($stmt = mysqli_prepare($SQL_Connection, "UPDATE Accounts SET balance = balance - ?, savings = savings + ? WHERE accId=?")) {
            $stmt->bind_param('iis', $amount, $amount, $accountNumber);
            if($stmt->execute()) {
              if($stmt = mysqli_prepare($SQL_Connection, "INSERT INTO Transactions (accid, type, message, amount) VALUES (?, ?, ?, ?)")) {
                    $type = 1;
                    $stmt->bind_param('iisi', $accountNumber, $type, $message, $amount);
                    if($stmt->execute()) {
                        echo "Added money to savings account!";
                    }
                } else {
                    echo $stmt->error;
                }
            }
        } else {
            echo $stmt->error;
        }
    }

?>

<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/deposits.css">
</head>

<body>
    <header>
      <h1>Deposits</h1> 
    </header>
    
    <main>
      <h2>Deposit money to savings below:</h2>
      <button onclick="showForm()">Deposit Money</button>
      
      <script type="text/javascript">
        function showForm() {
          document.getElementById('depositsForm').style.display = 'block';
        }
      </script>
      
      <form id="depositsForm" method="post" action="" style="display: none;">
        <label for= "deposit"> Deposit Amount: </label> 
        <input type="deposit" id="depsoit" name="deposit" required> <br>
        <label for= "msg"> Deposit Message: </label>
        <input type="text" id="msg" name="depositmsg" placeholder="Message"> <br>
        <label for="Account"> Select Savings Account:</label>
        
        <!--<select id="Account" required>
          <option value=""> None </option>
          <option value="General"> General Savings </option>
          <option value="Student"> Student Savings </option>
          <option value="Personal"> Personal Savings</option> 
        </select> <br>-->
        
        <label>Do you wish to confirm deposit?</label> <br>
        <input type="submit" name="submit" value="Yes">
        <input type="reset" value="No">
      </form>

        <p>
            <a href="home.php">Back to home</a>
        </p>
    </main>
    
</body>
</html>
