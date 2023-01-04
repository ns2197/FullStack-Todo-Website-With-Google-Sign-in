<?php

require_once "connectin.php";

if (isset ($_SESSION['email'])) {
    $error = "";

    If (isset($_POST['submit'])) {
        $input = $_POST['task-input'];

        if (empty ($input)) {
            $error = "Please Write a Task to add";
        }
        else {
            //you can see the column name in the task table called new task
            // the status column is for whether the task is complete or incomplete
            $sql = "INSERT INTO newtask (user_id, task_list, status)
            VALUES ('$_SESSION[user_id]', '$input', '0')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header ("location: main.php");
            }
        }
    }

    if (isset ($_GET['dlt_task'])) {
        $task_id = $_GET['dlt_task'];

        $sql = "DELETE FROM newtask WHERE task_id = '$task_id' ";
        $result = mysqli_query($conn, $sql);
    }

    if (isset ($_GET['finish_task'])) {
        $task_id = $_GET['finish_task'];

        $sql = "UPDATE newtask SET status = '1' WHERE task_id = '$task_id' ";
        $result = mysqli_query($conn, $sql);
    }
    //View the incomplete task
    $sql1 = "SELECT * FROM newtask WHERE 
    user_id = '[$_SESSION_id]' and stautus='0'";
    $result1 = mysqli_query($conn, $sql1;


    $sql2 = "SELECT * FROM newtask WHERE 
    user_id = '[$_SESSION_id]' and stautus='1'";
    $result2 = mysqli_query($conn, $sql2);


?>
<!Doctype html>

<html>
    <head>
        <title>MyToDoList</title>
        <link rel = 'stylesheet' href = 'css/style.css'>
        <link rel = 'stylesheet' 
        href = "https //cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <div class = "navbar">
            <div class = 'dropdown'>
                <button class = 'dropbtn'>
                    <i class = 'fa fa-carcet-down'></i>
                    <div class = "container">
                        <div class = "img">
                            <img src = " <php echo $_SESSION['profile_image']; ?>" alt = "<?php ?>">
                        </div>
                    </div>
                </button>
                <div class = "dropdown-content">
                    <a href = "navigation/logout.php">Logout</a>
                </div>

                <?php echo "<p id = 'taskHeading'> " .$_SESSION['fname']. "'s To Do List </p>"; ?>

                <div class = "dropdown">
                    <button class = 'dropdown1'> Info
                        <i class = 'fa fa-carcet-down'></i>
                    </button>

                    <div class = "dropdown-content">
                        <a href = "navigation/about.php">About</a>
                        <a href = "navigation/contact.php">Contact</a>
                    </div>
                </div>
        </div>

        <header>
            <form action = "main.php" method = "POST" id = "task-form">
                <input type = 'text' id = 'task-input' name = 'task-input'
                placeholder = "Type your Task here and Click the + Button to Add">

                <button id = "submit-task" type = "submit" name = "submit">
                    <i class = "fa fa-plus"></i>>
                </button>
            </form> 

            <div id = 'task-list'>
                <h2> To-Do List </h2>
            </div>

            <table
            style = "text-align: center; background: none; margin: auto" 
            width = "60%">

            <tr>
            </tr>

            <?php
                while ($row = mysqli_fetch_assoc($result1)) { ?>
                    <tr>
                        <td class = "TaskList"> <?php echo $row ['task_list'];?> </td>


                        <td>
                            <a href = "main.php?finish_task=<?php echo $row['task_id'];?>">
                                <button name = 'check' class = "complete"><i class = "fa fa-check"></i>
                                </button>
                            </a>
                        </td>

                        <td>
                            <a href = "main.php?dlt_task=<?php echo $row['task_id'];?>">
                                <button name = 'delete' class = "delete"><i class = "fa fa-trash"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
            <?php }?>            
            </table>

            <h2> Complted </h2>

            <table
            style = "text-align: center; background: none; margin: auto" 
            width = "60%">

            <tr>
            </tr>

            <?php
                while ($row = mysqli_fetch_assoc($result2)) { ?>
                    <tr>
                        <td class = "TaskList"> <?php echo $row ['task_list'];?> </td>


                        <td>
                            <a href = "main.php?finish_task=<?php echo $row['task_id'];?>">
                                <button name = 'check' class = "complete"><i class = "fa fa-check"></i>
                                </button>
                            </a>
                        </td>

                        <td>
                            <a href = "main.php?dlt_task=<?php echo $row['task_id'];?>">
                                <button name = 'delete' class = "delete"><i class = "fa fa-trash"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
            <?php }?>            
            </table>



        </header>

    </body>

</html>





<?php
}
//if the session is not active
else {
    header ("location: index.php")
}
?>