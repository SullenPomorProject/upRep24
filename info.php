<?php
require_once("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подробнее об игре</title>
</head>
<?php
require_once("header.php");
?>
<body>
    <?php
        if (isset($_POST['info'])) {
            $sql = 'SELECT * FROM `games` WHERE `idGame` = '.$_POST['idGame'].' ORDER BY `name`';
            $stmt = $connect->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo "<div class='info'><img src='". $row['logo'] . "' class='logo' alt='лого игры'><h2>" . $row['name'] . "</h2></div>"; 
                echo "<p>" . $row['description'] . "</p>";
                echo "<div class='#'><p>" . $row['price'] . " рублей</p>
                        <form method='post' action='cart.php'>
                            <input type='hidden' name='idGame' value='".$row['idGame']."'>
                            <button type='submit' name='nameGame' value='".$row['name']."'>Добавить в корзину</button>
                        </form>
                     </div>";

                $idGame = $row['idGame'];
                $sqlPhotos = "SELECT * FROM `Photos` WHERE IdGame = ". $_POST['idGame'];
                $stmtPhotos = $connect->prepare($sqlPhotos);
                $stmtPhotos->execute();

                while($rowPhoto = $stmtPhotos->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<img src='" . $rowPhoto['Path'] . "'>";
                }

            }
        }
    ?>
</body>
<?php
require_once("footer.php");
    
?>
</html>