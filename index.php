<?php
    session_start();

    /*
        The user is already logged in.
        Send them to the home page.
    */
    if(isset($_SESSION["username"]) && isset($_SESSION["accId"])) {
        header('Location: home.php');
        exit();
    }

    //The user clicked either the login or create account button
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once '../config.php';
        //Connect to the database using the variables from the config file
        $SQL_Connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        
        //Check if the connection was successful
        if(mysqli_connect_errno())
        {
            echo "Couldn't connect to the sql database.";
            exit();
        }

        if (isset($_POST['loginBtn'])) {
            /*
                Clicked the login button.
            */
            
            // This is the username text they posted in the login form.
            $username = $_POST['username'];
            $password = $_POST['password'];

            if($stmt = mysqli_prepare($SQL_Connection, "SELECT id, username, email, Users.accId, balance, cardNo, expMonth, expYear, cvc, Users.created FROM Users JOIN Accounts ON Users.accId=Accounts.accId WHERE username=? AND password=?"))
            {
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $result = $stmt->get_result();
                $array = $result->fetch_assoc();
                if($array == null) {
                    $loginError = "Username and Password did not match!";
                } else {
                    $_SESSION["id"] = $array['id'];
                    $_SESSION["username"] = $array['username'];
                    $_SESSION["accId"] = $array['accId'];
                    $_SESSION["balance"] = $array['balance'];
                    $_SESSION["cardNo"] = $array['cardNo'];
                    $_SESSION["expMonth"] = $array['expMonth'];
                    $_SESSION["expYear"] = $array['expYear'];
                    $_SESSION['cvc'] = $array['cvc'];
                    $_SESSION["created"] = $array['created'];
                    header('Location: home.php');
                    //echo json_encode($array);
                    exit();
                }
                $stmt->close();
            }

            
        } else if (isset($_POST['createAccountBtn'])) {
            /*
                Clicked the create account button.
            */
            $username = $_POST['usernameCA'];
            $email = $_POST['email'];
            $password = $_POST['passwordCA'];
            $password2 = $_POST['password2CA'];
            $accId = rand(1000, 9999);

            if($password != $password2) {
                $createError = "Passwords didn't match!";
            } else {
                if($stmt = mysqli_prepare($SQL_Connection, "INSERT INTO Users (username, email, password, accId) VALUES (?, ?, ?, ?)"))
                {
                    $stmt->bind_param("ssss", $username, $email, $password, $accId);
                    if($stmt->execute()) {
                        if($stmt = mysqli_prepare($SQL_Connection, "INSERT INTO Accounts (accid, balance, cardNo, expMonth, expYear, cvc) VALUES (?, ?, ?, ?, ?, ?)"))
                        {
                            $randCardNo = rand(1000, 9999);
                            $cardNo = "1111 2222 3333 " . $randCardNo;
                            $expMonth = 1;
                            $expYear = 2025;
                            $cvc = rand(100, 999);
                            $balance = 0;
                            $stmt->bind_param("ssssss", $accId, $balance, $cardNo, $expMonth, $expYear, $cvc);
                            if($stmt->execute()) {
                                $success = "Account was created! You can now login using the username and password.";
                            } else {
                                echo $stmt->errno;
                            }
                        }
                    } else {
                        //We got an error from the table, check it!
                        if($stmt->errno == 1062) {
                            if (strpos($stmt->error, '\'email\'') !== false) {
                                $createError = "Email already exists, please try another one!";
                            } else {
                                $createError = "Username already exists, please try another one!";
                            }
                        }
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
        <title>Login / Create Account</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <header>
        </header>
        <main>
            <!-- This form will post to this page again, as it will do error checking above in the php section. 
                If everything is fine it will redirect them to the home page  -->
            <form method="post" action="/">
                <h2>Login</h2>
                <input type="text" id="username" name="username" placeholder="Username" autocomplete="off"><br>
                <input type="password" id="password" name="password" placeholder="Password" autocomplete="off"><br>
                <input type="submit" name="loginBtn" value="Login">
                <?php
                    if(isset($loginError)) {
                        echo "<p class='error'>$loginError</p>";
                    }
                ?>
            </form>

            <form method="post" action="/">
                <h2>Create Account</h2>
                <input type="text" id="usernameCA" name="usernameCA" placeholder="Username" autocomplete="off"><br>
                <input type="email" id="email" name="email" placeholder="Email" autocomplete="off"><br>
                <input type="password" id="passwordCA" name="passwordCA" placeholder="Password"><br>
                <input type="password" id="password2CA" name="password2CA" placeholder="Password x2"><br>
                <input type="submit" name="createAccountBtn" value="Create Account"><br>
                <?php
                    if(isset($success)) {
                        echo "<p class='success'>$success</p>";
                    }

                    if(isset($createError)) {
                        echo "<p class='error'>$createError</p>";
                    }
                ?>
            </form>
        </main>
    </body>
</html>