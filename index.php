<?php
require_once("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игры</title>
</head>
<?php
require_once("header.php");
?>
<body>
    <h1>Список Игр</h1>
    <?php
    try{
        $where = '';

        if(isset($_GET['category']))
        {
            $category = $_GET['category'];
            $where = " WHERE category = '".$category."'";
        }

        $sql = 'SELECT * FROM `games` ' . $where . ' ORDER BY `name`';
        $stmt = $connect->prepare($sql);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo '<h2>' . $row['name'] . '</h2>'; 
            echo "<p>" . $row['description'] . "</p>";
            echo "<form action='info.php' method='post' >
                    <input type='hidden' name='info' value='".$row['idGame']."'>
                    <button type='submit' name='idGame' value='".$row['idGame']."'>Подробнее</button>
                </form>";
        }
    } catch(PDOException $e){
        echo 'Error: ' . $e -> getMessage();
    }
    $connect = null;
    ?>
</body>
<?php
require_once("footer.php");
?>
</html>

