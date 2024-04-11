<?php
//test text
require_once("connection.php");
if(isset($_POST['idGame']))
{
    $idGame = $_POST['idGame'];
    try {
        $sql = "INSERT INTO Cart (`idProduct`) VALUES (".$idGame.")";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
    } catch(PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
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
        if (isset($_POST['idGame'])) {
            $sql = 'SELECT * FROM `games` WHERE `idGame` = '.$_POST['idGame'].' ORDER BY `name`';
            $stmt = $connect->prepare($sql);
            $stmt->execute();

            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo "<div class='info'><img src='". $row['logo'] . "' class='logo' ><h2>" . $row['name'] . "</h2></div>"; 
                echo "<p>" . $row['description'] . "</p>";
                echo "<div class='#'><p>" . $row['price'] . " рублей</p>
                        <button disabled>Товар в корзине</button>
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