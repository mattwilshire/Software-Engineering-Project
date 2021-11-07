
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



<?php
        payment()
            $username = $_POST['reciever'];
            $payment = $_POST['payment'];
            $date = new DateTime('2021-11-05');



            if($stmt = mysqli_prepare($SQL_Connection, "SELECT id, username, email, Users.accId, balance, cardNo, expMonth, expYear, cvc, Users.created FROM Users JOIN Accounts ON Users.accId=Accounts.accId WHERE username=?))
            {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $array = $result->fetch_assoc();
                if($array == null) {
                    $loginError = "This User does not exist :(!";}
            }
            else {
                    $stmt=mysqli prepare ($SQL_Connection, 
            {


                    "UPDATE=Users
                     SET=balance =balance-payment
                     Users.created FROM Users JOIN Accounts ON Users.accId=Accounts.accId 
                     WHERE username=username")            

                    "UPDATE=Users
                     SET=balance =balance+payment
                     Users.created FROM Users JOIN Accounts ON Users.accId=Accounts.accId 
                     WHERE username=reciever")

            }
            }
            ?>



?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sceduled Transfer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <header>
        	<h1>Sceduled Transfer</h1>
        </header>
        <main>
        	<h2>Would you like to transfer a scehduled amouint of money: <span h2>
            <button onclick="showForm()">Schedule Transfer</button>
            <script type="text/javascript">
                function showForm() {
                document.getElementById('formElement').style.display = 'block';}
            </script>
            <form id="formElement" style="display: none;">
        	
            <input type="text" id="reciever" name="reciever" placeholder=" Reciever's Username"><br>
            <input type="payment" id="payment" name="payment" placeholder="Amount to pay"><br>
            <label for="Often">How Often:</label>

            <select name="How Often" id="Often">
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="biAnnualy">Bi-Annualy</option>
                <option value="Annualy">Annualy</option>
                <input type="submit" value="Submit">
            </select>
            <?php
    schedule()
    $date = new DateTime('2021-11-05');
    $billingType = 'monthly';
    switch ($billingType) {
    case 'monthly':
        $interval = new DateInterval('P1M');
        payment()
        break;

    case 'quarterly':
        $interval = new DateInterval('P3M');
        payment()
        break;

    case 'biannually':
        $interval = new DateInterval('P6M');
        payment()
        break;
    }
    case 'annually':
        $interval = new DateInterval('P6M');
        payment()
        break;
    }

    $newDate = clone $date;
    $newDate->add($interval);

    echo $date->format('Y-m-d'); 
    echo $newDate->format('Y-m-d'); 
?>
      </form>


        </main>
    </body>
</html>