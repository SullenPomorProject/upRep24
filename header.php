<?php
require_once("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игры</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
</head>
<style>
    html{
        font-size: 20pt;
    }
    .active {
        color: red; /* Пример активного стиля */
        text-decoration: none;
    }

    .disabled{
        pointer-events: none;
        color: black;
        text-decoration: none;
    }
    .logo {
        width: 75px;
        height: 75px;
        margin-right: 10px;
    }
    img {
        width: 510px;
        height: 287px;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .info{
        display: flex;
        justify-content: center;
        align-items:center;
    }

</style>
<body>
    <header>
        <h1>Игры</h1>
        <ul id='myList'>
            <?php
            try{
                $sql = 'SELECT DISTINCT `category` FROM `games` ORDER BY `category`';
                $stmt = $connect->prepare($sql);
                $stmt->execute();

                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<li> <a class='elem' href='index.php?category=" . $row['category'] . "'>" . $row['category'] . "</a></li>";
                    }
            } catch(PDOException $e){
                echo 'Error: ' . $e -> getMessage();
            }
            ?>
        </ul>
    </header>
</body>
<script>
    var myList = document.getElementById('myList');
    var link = document.getElementsByClassName('elem');

    myList.onclick = function(event){
        for (let i = 0; i < link.length; i++) {
            link[i].classList.remove('disabled');     
        }
        event.target.classList.add('disabled');
    }
</script>
</html>

<?php



?>