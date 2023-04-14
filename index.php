<?php
    require_once 'pdo.php';
    session_start();
?>
<html>
    <head>
        <title>6637c91d</title>
        <style>
            .index{
                margin-left: 36px;
            }
            a{
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <?php
        if(!isset($_SESSION['name']))
        { ?>
            <div class="index">
                <h1>Welcome to the Automobiles Database</h1>
                <a href="login.php">Please log in</a>
                <p>Attempt to <a href="add.php">add data</a> without logging in</p>
            </div>
        <?php 
        } 
        else
        {
        ?>
            <h1>Welcome to the Automobiles Database</h1>
        <?php
            if(isset($_SESSION['success']))
            {
                 echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']))
            {
                 echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']);
            }
            
            $results=$make=$model=$year=$mileage="";
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $result=$pdo->query("SELECT * FROM autos;");
            $results=$result->fetchAll(PDO::FETCH_ASSOC);
            //echo"Printing ".count($results);
            //$results= NULL;

            if(count($results)>0)
            {

                echo '<table border=1>
                        <tr>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Mileage</th>
                        <th>Action</th>
                        </tr>';
                foreach($results as $row)
                {
                    $make=htmlentities($row['make']);
                    $model=htmlentities($row['model']);
                    $year=htmlentities($row['year']);
                    $mileage=htmlentities($row['mileage']);
                    $auto_id=htmlentities($row['auto_id']);

                    echo '<tr>';
                    echo '<td>';

                    echo 
                        $make.'</td><td>'.
                        $model.'</td><td>'.$year.'</td><td>'.
                        $mileage.'</td><td>';
                     
                        echo '<a href="edit.php?autos_id='.$auto_id.'">Edit </a> /';
                        echo '<a href="delete.php?autos_id='.$auto_id.'">Delete </a>';

                    echo '</td>';
                    echo '</tr>';
                    
                }
                echo "</table>";                            
                
            }
            else
            {
                echo "No rows found <br>";
            }
            ?>
            <a href="add.php">Add New Entry</a><br>
            <a href="logout.php">Logout</a>
        <?php    
        }
        
        ?>
    </body>
</html>