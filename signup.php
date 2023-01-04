<?php
include "connection.php";

session_start()

if (isset ($_SESSION['userName'])){

    header ("location: index.php");
}
$message = '';

if (isset ($_POST['signup'])) {
    $fname = $_POST['fname']
    $lname = $_POST['lname']
    $userName = $_POST['userName']
    $password = $_POST['password']

    $table_name = 'user';

    $sql = "SELECT * FROM $table_name WHERE userName = '$userName";
    $result = mysqli_query ($conn, $sql)

    $check_result = myslqi_num_rows ($result);

    if ($check_result > 0) {
        $_SESSION ['email_alert'] = '1';
    }
    else {
        $sql = "INSERT INTO $table_name (fname, lname, userName, user_password)
        VALUES ('$fname', '$lname', '$userName', '$password')";

        $result = mysqli_query ($conn, $sql);

        if($result){
            $_SESSION['success'] = '1';
             header("location: index.php");
        }
        else {
            echo "error!";
        }
    } 
}
if (isset ($_SESSION['email_alert'])) {
    $message = "email already in use!";
}

//close the connection:
mysqli_close ($conn);

?>

<!Doctype html>

<html>
    <head>
        <title>Sign Up</title>
        <link rel = 'stylesheet' href = "css/signup.css">
    </head>

    <body>
        <div class = "container">
            <div class = 'left'>
                <img src = 'images/todo.png' alt = ""
                style = "width: 100%">
            </div>
        </div>

        <div class = "signup">
            <h2> Sign Up </h2>
            <p id = 'error'> <?php echo "$message";?></p>

            <form action = '' method = "POST">
                <input id = 'fname' type = 'text' name = 'fname' placeholder = "First Name">
                <input id = 'lname' type = 'text' name = 'lname' placeholder = "Last Name">
                <input id = 'email' type = 'text' name = 'email' placeholder = "Example@email.com">
                <input id = 'password' type = 'text' name = 'password' placeholder = "Password">
                <input id = 'submit' type = 'submit' name = 'signup' valu = "Sign Up">
            </form>
            <p> Alrady Have an Account? <a id = 'link' href = 'index.php'></a></p>
        </div>
        <?php unset ($_SESSION['email_alert']);?>
    </body>

</html>