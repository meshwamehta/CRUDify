<?php
    require_once 'pdo.php';
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
           // $pdo->beginTransaction();
            $st=$pdo->prepare("update autos set make=:make,model= :model,year= :year,mileage=:mileage where auto_id=:id");
            $st->execute(array(':make' => $_POST['make'],
                                'model'=> $_POST['model'],
                                ':year'=> $_POST['year'],
                                ':mileage'=> $_POST['mileage'],
                                ':id' => $_POST['auto_id']));
            //$pdo->commit();
            $_SESSION['success']="     Record edited";
            header('Location: index.php');
            return;                  
        }
    }
       //echo "here you are".$_GET['nisheet'];
        $pdo->beginTransaction();
        $state=$pdo->prepare("select * from autos where auto_id=:id;");
        $state->bindParam(':id',$_GET['autos_id']);
        $state->execute();
        $result=$state->fetch(PDO::FETCH_ASSOC);
        if ($result==false)
        {
            $_SESSION['error']="Bad value for id";
            header('Location :index.php');
            return;
        }
        //print_r($result);
        $pdo->commit();
        $make=htmlentities($result['make']);
        $model=htmlentities($result['model']);
        $year=htmlentities($result['year']);
        $mileage=htmlentities($result['mileage']);
        $auto_id=$_GET['autos_id'];
    

?>
<html>
    <head>
        <title>6637c91d</title>
    </head>
    <body>
        <h1>Editing Automobile</h1>
        <form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
        <label>Make:</label>
        <input type="text" name="make" value="<?= $make;?>"><br>
        <label>Model:</label>
        <input type="text" name="model" value="<?= $model;?>"><br>
        <label>Year:</label>
        <input type="text" name="year" value="<?= $year;?>"><br>
        <label>Mileage:</label>
        <input type="text" name="mileage" value="<?= $mileage;?>"><br>
        <input type="hidden" name="auto_id" value="<?= $auto_id;?>">
        <input type="submit" value="Save">
        <input type="submit" value="Cancel" formaction="index.php">
        </form>
    </body>
    
</html>