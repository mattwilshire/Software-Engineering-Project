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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (isset($_POST['addUser'])) 
        {
            $user = $_POST['username'];
            
            require_once '../config.php';
            $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            if(mysqli_connect_errno())
            {
                echo "Couldn't connect to the sql database.";
                exit();
            }

            if($stmt = mysqli_prepare($SQL_Connection, "SELECT id, username FROM Users WHERE username=?"))
            {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $array = $result->fetch_assoc();
                if($array == null) 
                {
                    echo "Couldn't find the user you typed.";
                } else {
                    if($stmt = mysqli_prepare($SQL_Connection, "INSERT INTO Contacts (username,  usernameTo) VALUES (?, ?)"))
                    {
                        $stmt->bind_param("ss", $username, $user);
                        if($stmt->execute()) 
                        { 
                            echo "Added $user to contacts!";
                            $stmt->close();
                        } else {

                        }
                    } 
                    else 
                    {
                        echo "Something went wrong.";
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add a User</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
        	<h1>Add a user</h1>
        </header>
        <main>
        	<a href="sendmoney.php" id="back">< Back.</a>
        		
            <form method="post" action="">
                <label for="selectUser">Enter a username:</label><br>
                <input type="text" id="username" name="username" ><br>
                <input type="submit" name="addUser" value="Add"><br>
            </form>

            <?php
                if(isset($success)) {
                    echo "<p class='success'>$success</p>";
                }

                if(isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
            ?>
        	
			<a href="home.php">Return Home.</a>
        </main>
    </body>
</html>