<?php
require_once("connection.php");

if (isset($_POST['submit'])) {
    $gameId = $_POST['game'];

    // Обработка загрузки логотипа
    $logoTmpName = $_FILES['logo2']['tmp_name'];

    $img = addslashes(file_get_contents($_FILES['logo2']['tmp_name']));

    try {
        $sql = "UPDATE `games` SET `logo2` = '".$img."' WHERE `idGame` = " . $gameId;
        $stmt = $connect->prepare($sql);
        $stmt->execute();

        echo "Логотип успешно добавлен к товару.";
        echo "
            <form action='viewLogo.php' method='GET'>
                <input type='hidden' name='idGame' value='" . $gameId . "'>
                <button type='submit'>
                    Посмотреть лого
                </button>
            </form>";

    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }

    $connect = null; // Закрытие соединения с базой данных
}
?>
