<?php
    require_once "pdo.php";
    session_start();
    
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        if(empty($_POST['make']) || empty($_POST['model']) || empty($_POST['year']) || empty($_POST['mileage']))
        {
            $_SESSION['error'] = "All fields are required";
            header("Location: add.php");
            return;
          
        }
        elseif(!is_numeric($_POST['year']) )
        {
            $_SESSION['error'] = "Year must be an integer";  
            header("Location: add.php");
            return;
 
        }
        elseif(!is_numeric($_POST['mileage']))
        {
            $_SESSION['error'] = "Mileage must be an integer";  
            header("Location: add.php");
            return;   
        }
        else
        {
            $pdo->beginTransaction();
            $state=$pdo->prepare("Insert into autos (make,model,year,mileage) values ( :make, :model, :year, :mileage);");
            $state->bindParam(':make',$_POST['make']);
            $state->bindParam(':model',$_POST['model']);
            $state->bindParam(':year',$_POST['year']);
            $state->bindParam(':mileage',$_POST['mileage']);
            $state->execute();
            $pdo->commit();
            $_SESSION['success']="Record added";
            header("Location: index.php");
            return;
        }
    }
    
/*}
catch(PDOException $e)
{
    $pdo->rollBack();
    echo $e->getMessage();
}*/

?>
<html>
    <head>
    <title>6637c91d</title>
    </head>
    <body>
        <?php 
            if(!isset($_SESSION['name']))
            {
                die("ACCESS DENIED");
            }
        ?>
        <h1>Tracking Automobiles for <?= $_SESSION['name'];?></h1>
        <?php
            if(isset($_SESSION['error']))
            {
                echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']);
              
            }
        ?>
        <form method="post" action="<?= $_SERVER['PHP_SELF'];?>">
        <label>Make:</label>
        <input type="text" name="make"><br>
        <label>Model:</label>
        <input type="text" name="model"><br>
        <label>Year:</label>
        <input type="text" name="year"><br>
        <label>Mileage:</label>
        <input type="text" name="mileage"><br>
        <input type="submit" value="Add">
        <input type="submit" value="Cancel" formaction="index.php">
        </form>
    </body>
</html>
