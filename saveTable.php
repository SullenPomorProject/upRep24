<?php
require_once('connection.php');

if(isset($_POST['confirm'])){
    $idGame = $_POST['idGame'];
    $sql = 'DELETE FROM `games` WHERE idGame = '.$idGame;
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    echo "<h1>Данные удалены</h1>";
    if(!$stmt){
        echo 'Технические шоколадочки';
    }
}
else if(isset($_POST['add'])){
    $sql = "INSERT INTO `games`(`name`, `description`, `category`, `price`)
            VALUES(
                '".$_POST['nameGame']."', 
                '".$_POST['description']."', 
                '".$_POST['category']."', 
                ".$_POST['price']."
                )";
    $stmt = $connect->prepare($sql);
    $stmt->execute();

    $logoTmpName = $_FILES['logo2']['tmp_name'];
    $img = addslashes(file_get_contents($_FILES['logo2']['tmp_name']));

    $sql = "UPDATE `games` SET `logo2` = '".$img."' 
    WHERE `idGame` = (SELECT `idGame` 
                        FROM `games` 
                        ORDER BY `idGame` DESC LIMIT 1)";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    echo "<h1>Данные добавлены</h1>";
}
else if(isset($_POST['upd'])){
    $logoTmpName = $_FILES['logo2']['tmp_name'];
    $img = addslashes(file_get_contents($_FILES['logo2']['tmp_name']));

    $sql = "UPDATE `games`
            SET
                `name` = '".$_POST['nameGame']."',
                `description` = '".$_POST['description']."', 
                `category` = '".$_POST['category']."', 
                `logo2` = '".$img."', 
                `price` = ".$_POST['price']."
            WHERE idGame = ".$_POST['upd']."
            ";

    $stmt = $connect->prepare($sql);
    $stmt->execute();

    echo "<h1>Данные обновлены</h1>";
}
else if(isset($_POST['cancel'])){
    header("Location: showTable.php");   
}

$sql = 'SELECT * FROM `games`';
$stmt = $connect->prepare($sql);
$stmt->execute();

echo '<a href="showTable.php">Вернуться</a>';


    
?>