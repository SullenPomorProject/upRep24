<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a <?php if((!isset($_GET['category'])) || $_GET['category'] != 'RPG') echo "href='showList.php?category=RPG'";?> name='link1'>RPG</a><br>
    <a <?php if((!isset($_GET['category'])) || $_GET['category'] != 'Шутер') echo "href='showList.php?category=Шутер'"; ?> name='link2'>Шутер</a><br>
    <a <?php if((!isset($_GET['category'])) || $_GET['category'] != 'Симулятор') echo "href='showList.php?category=Симулятор'";?> name='link3'>Симулятор</a><br>
</body>
</html>
<style>
    a {
        font-size: 50pt;
        text-decoration: none;
        cursor: pointer;
    }
</style>
<?php
require_once('connection.php');

try{

    $N = 3;
    $totalRows = $connect->prepare('SELECT COUNT(*) as total FROM `games`')->fetch(PDO::FETCH_ASSOC)['total'];


    $page = ceil($totalRows / $N);

    if (isset($_GET['page'])) {
        $currentPage = $_GET['page'];
        $limit = ($currentPage - 1) * $N;

        try{
            $sql = 'SELECT * FROM `games` ORDER BY `name` Limit '.$limit.','. $N;

            $stmt = $connect->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                echo "<h2>" . $row['name'] . "</h2><br>
                <p>" . $row['description'] . "</p><br>
                <p>" . number_format($row['price'], 2) . "руб.<p>";
            }
        } catch(PDOException $e){
            echo 'Error: ' . $e -> getMessage();
        }
    }
    else if (isset($_GET['category'])) {
        $sql = 'SELECT * FROM `games` WHERE category = "'.$_GET['category'].'"';

        $stmt = $connect->prepare($sql);
        $stmt->execute();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<h2>" . $row['name'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>" . number_format($row['price'], 2) . " руб.<p>";
        }
        
    }

    for($i = 1; $i <= $page; $i++) {
        echo '<a href="showList.php?page='.$i.'"> '.$i.' </a>';
    }
} catch(PDOException $e){
    echo 'Error: ' . $e -> getMessage();
}
$connect = null;
?>