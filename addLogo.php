<?php
require_once("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Добавить логотип</title>
</head>
<body>
    <h1>Добавить логотип к игре</h1>

    <form method="post" action="uploadLogo.php" enctype="multipart/form-data">
        <label for="game">Выберите игру:</label>
        <select name="game" id="game">
            <?php
            try {
                // Запрос для получения списка товаров
                $sql = "SELECT `idGame`, `name` FROM `games`";
                $stmt = $connect->query($sql);

                // Вывод списка товаров в выпадающем списке
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['idGame'] . "'>" . $row['name'] . "</option>";
                }

            } catch(PDOException $e) {
                echo "Ошибка: " . $e->getMessage();
            }

            $connect = null; // Закрытие соединения с базой данных
            ?>
        </select>

        <br><br>

        <label for="logo2">Выберите файл логотипа:</label>
        <input type="file" name="logo2" id="logo2">

        <br><br>

        <button type="submit" name="submit">Сохранить</button>
    </form>
</body>
</html>
