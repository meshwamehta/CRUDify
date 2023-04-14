<?php
    require_once 'pdo.php';
    session_start();
?>
<?php
    if(isset($_POST['delete']) && $_POST['auto_id'])
    {
        $pdo->beginTransaction();
        $sql="delete from autos where auto_id=:id;";
        $delete=$pdo->prepare($sql);
        $delete->bindParam(':id',$_POST['auto_id']);
        $delete->execute();
        $pdo->commit();
        $_SESSION['success']="Record deleted";
        header('Location: index.php');
        return;
    }
    elseif(!isset($_GET['autos_id']))
    {
        $_SESSION['error']="Missing auto id";
        header("Location: index.php");
        return;

    }
    else
    {
        $state=$pdo->prepare("select make,auto_id from autos where auto_id=:id");
        $state->bindParam(':id',$_GET['autos_id']);
        $state->execute();
        $row=$state->fetch();
        print_r($row);
        if($row===false)
        {
            $_SESSION['error']="Bad auto id";
            header("Location: index.php");
            return;
    
        }

    }

?>
<html>
    <head>
        <title>6637c91d</title>
    </head>
    <body>
        <h1>hiiiii</h1>
        <form method="post" action="<?= $_SERVER['PHP_SELF'];?>">
        <p>confirm: <?php echo $row['make'] ;?></p>
        <input type="hidden" value="<?= $row['auto_id']; ?>" name="auto_id">
        <input type="submit" value="Delete" name="delete">
        <a href="index.php">Cancel</a>
        </form>
    </body>
</html>

