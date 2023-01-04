<?php
require "connection.php";
include 'config.php';


if (isset ($_SESSION['code'])){

    $token = $client->fetchAccessTokenWithAuthCode ($_GET['code']);
    if (isset ($token['error'])) {
        $client0>setAccessToken($token['access_token']);

        //get profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        //storing the information into the database

        $id = mysqli_real_escape_string($conn, $google_account_info->id);
        $full_Name = mysqli_real_escape_string($conn, trim($google_account_info->full_name));
        $fname = mysqli_real_escape_string($conn, trim($google_account_info->givenName));
        $email = mysqli_real_escape_string($conn, $google_account_info->email);
        $prfile_image = mysqli_real_escape_string($conn, $google_account_info->profile_image);
        
        //the database table to stor the data when users use google sign in 
        $table = 'google_users';

        $sql = "SELECT * FROM $table WHERE google_id = '$id";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result)== 1) {
            $_SESSION['login_id'] = $id;
            $_SESSION['fname'] = $fname;
            $_SESSION['email'] = $email;
            
            $user = mysqli_fetch_assoc($result);

            $_SESSION['user_id'] = $user ['user_id'];
            $_SESSION['profile_image'] = $user ['profile_image'];

            header ("location: main.php");
        }
        else {
            $sql = "INSERT INTO $table (google_id, name, email, profile_image)
            VALUES ('$id', '$full_Name', '$email', '$profile_image')";
            $result = mysqli_query($conn, $sql);

            if($result) {
                $_SESSION['login_id'] = $id;
                header ("location: main.php");
            }
            else {
                echo "sign up failed";
            }
        }
    
    }
    else {
        header ("location: index.php");
    }
    
}
else:
?>
<?php endif; ?>

<?php

include "connection.php";

$message = "";
$success = "";

if (isset ($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $table_name = 'google_users';

    $sql = "SELECT * FROM $table_name WHERE email = '$email' and password = '$password'";
    $result = mysqli_query($conn, $result);

    //check to see if that email exist

    $count = mysqli_num_rows($result);

    if ($cound == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['fname'] = $row['fname'];

        header ("location: main.php");
    }
    else {
        $_SESSION['email_alert'] = '1';
    }
}
//if wrong credentials are entered
if (isset($_SESSION['email_alert'])) {
    $message = "email or password doesn't match! Please try again"
}
if (isset ($_SESSION['success'])) {
    $success = 'Account Successfully Created! Please Login to your Account'
}



//close the connection:
mysqli_close ($conn);

?>

<!Doctype html>

<html>
    <head>
        <title>Sign Up</title>
        <link rel = 'stylesheet' href = "css/signup.css">
        <link rel = 'stylesheet' 
        href = "https //cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div class = "container">
            <div class = 'left'>
                <img src = 'images/todo.png' alt = ""
                style = "width: 100%">
            </div>
        </div>

        <div class = "login">
            <h3> Login </h3>
            <p id = 'error'> <?php echo "$message";?></p>
            <p id = 'yes'> <?php echo "$success";?></p>

            <form action = 'index.php' method = "POST">
                <input id = 'email' type = 'text' name = 'email' placeholder = "Example@email.com">
                <input id = 'password' type = 'text' name = 'password' placeholder = "Password">
                <input id = 'submit' type = 'submit' name = 'login' valu = "Login">
            </form>
            <p> New Here? </p>
            <a href = "signup.php">
                <input id = 'create' type = 'submit' bame = 'create' value = 'Create Account'>
            </a>
        </div>
        <?php unset ($_SESSION['email_alert']);?>
        <?php unset ($_SESSION['success']);?>

        <div class = 'image'>
            <p> Other Login Option </p>
            <a class = "login-btn" href - "<?php echo $client->createAuthUrl(); ?>">
                <img src = "images/sign-in-with-google.png" alt - "">
            </a>
            <img src = 'images/todo.png' alt = ""
            style = "width: 100%">
        </div>

        <div class = 'navbar'>
            <div class = 'dropdown'>
                <butoon class = 'dropbtn'>Explore
                    <i class = 'fa fa-caret-down'></i>
                    <div class = 'dropdown-content'>
                        <a href = 'navigation/about.php'>About</a>            
                        <a href = 'navigation/about.php'>About</a>            
                    </div>
                </button>
            </div>
        </div>

    </body>

</html>