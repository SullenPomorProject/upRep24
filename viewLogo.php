<?php
require_once('connection.php');

if(isset($_GET['idGame']))
{
    $idGame = $_GET['idGame'];

    try {
        $sql = "SELECT `logo2` FROM `games` WHERE idGame = " . $idGame;
        $stmt = $connect->prepare($sql);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $showImg = base64_encode($row['logo2']);
        echo '<img src="data:image/png;base64, ' . $showImg . '" width = "50px" height = "50px"/>';

    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>