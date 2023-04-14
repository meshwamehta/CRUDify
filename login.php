<?php
    require_once "pdo.php";
    session_start();
    if ($_SERVER['REQUEST_METHOD']=="POST")
    {
        if(empty($_POST['email']) || empty($_POST['pass']))
        {
            $_SESSION['error']="User name and password are required";
            header('Location: login.php');
            return;
        }
        elseif(!preg_match('/@/',$_POST['email']))
        {
            $_SESSION['error']="Email must have an at-sign (@)";
            header('Location: login.php');
            return;
        }
        elseif($_POST['pass']==='php123')
        {
            $_SESSION['name']=$_POST['email'];
            $_SESSION['success']= "Logged in";
            header('Location: index.php');
            return;
        }
        else
        {
            $_SESSION['error']="Incorrect password";
            header('Location: login.php');
            return;
        }
    }
?>
<html>
    <head>
        <title>6637c91d</title>
        <style>
            a{
                text-decoration: none;
            }

           
        </style>
    </head>
    <body>
        <h1>Please Log In</h1>
        <?php
            if(isset($_SESSION['error']))
            {
                echo '<p style="color:red">'.$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }
        ?>
        <form method="post" action="<?= $_SERVER['PHP_SELF'];?>">
        <p>User Name <input type="text" name="email"><br/></p>
        <p>Password <input type="text" name="pass"><br/></p>
        <input type="submit" value="Log In">
        <a href="index.php">Cancel</a>
        </form>
    </body>
</html>