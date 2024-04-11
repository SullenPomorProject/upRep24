<?php
require_once('connection.php');

if(isset($_POST['del'])){
    $idGame = $_POST['idGame'];
    echo "
    <form action='saveTable.php' method='POST'>
        <h2>Подтвердить удаление</h2>
        <input type='hidden' name='idGame' value='".$idGame."'/>
        <button type='submit' name='confirm' value='".$idGame."'>Да</button>
        <button type='submit' name='cancel' value='".$idGame."'>Нет</button>
    </form>
    ";
}
else if(isset($_POST['ins'])){
    echo "
    <form action='saveTable.php' method='post' enctype='multipart/form-data'>
        <input type='file' name='logo2' id='logo2'>
        <input type='text' name='nameGame' placeholder='Введите название игры'>
        <input type='text' name='description' placeholder='Введите описание'>
        <input type='text' name='category' placeholder='Введите категорию'>
        <input type='number' name='price' placeholder='Введите цену'>
        <button type='submit' name='add'>Сохранить</button>
    </form>
    ";
}
else if (isset($_POST['upd'])){
    $idGame = $_POST['idGame'];

    $sql = "SELECT `logo2` FROM `games` WHERE idGame = " . $idGame;
    $stmt = $connect->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $showImg = base64_encode($row['logo2']);

    echo "
    <form action='saveTable.php' method='post' enctype='multipart/form-data'>
        <img src='data:image/png;base64, " . $showImg . "' width = '50px' height = '50px'/>
        <input type='file' name='logo2' id='logo2'>
        <input type='text' name='nameGame' value='".$_POST['name']."'>
        <input type='text' name='description' value='".$_POST['description']."'>
        <input type='text' name='category' value='".$_POST['category']."'>
        <input type='number' name='price' value='".$_POST['price']."'>
        <button type='submit' name='upd' value='".$idGame."'>Обновить</button>
    </form>
    ";
}
?>