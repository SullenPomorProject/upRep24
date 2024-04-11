<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    a {
        text-decoration: none;
        cursor: pointer;
    }
</style>
<body>
    <form action="showTable.php" method="get">
        <input type="radio" name="sortBy" <?php if(isset($_GET['sortBy']) && ($_GET['sortBy'] == 'name')) echo 'checked="checked"';?> value="name">name <br>
        <input type="radio" name="sortBy" <?php if(isset($_GET['sortBy']) && ($_GET['sortBy'] == 'price')) echo 'checked="checked"';?> value="price">price<br><br>
    
        <input type="number" name="price" placeholder="Введите цену" value=<?php if(isset($_GET['filter']) && ($_GET['filter'] == 'yes')) echo "". $_GET['price'].""; ?>>
        <input type="text" name="name" placeholder="Введите название" value=<?php if(isset($_GET['filter']) && ($_GET['filter'] == 'yes')) echo "". $_GET['name'].""; ?>>
        <input type="text" name="description" placeholder="Введите описание" value=<?php if(isset($_GET['filter']) && ($_GET['filter'] == 'yes')) echo "". $_GET['description'].""; ?>>
        <input type="submit" name="filter" value="yes">
        <input type="submit" name="filter" value="no">
    </form><br>
</body>
</html>


<?php
require_once('connection.php');

$filter = "";
$sortBy = "";

if(isset($_GET['filter'])){
    $filter = $_GET['filter'];
}
if(isset($_GET['sortBy'])){
    $sortBy = $_GET['sortBy'];
}

$orderBy = "";
$where = "";


if(isset($_GET['sortBy'])){
    $orderBy = " ORDER BY " . $_GET['sortBy'];
}
if ($filter == "yes"){
    if ($_GET['price'] && $_GET['name'] && $_GET['description']){
        $where =  "Where price <=" . $_GET['price'] ." and name LIKE '%". $_GET['name']."%' and description LIKE '%". $_GET['description']."%'";
    }
    else if ($_GET['price'] && $_GET['name']){
        $where =  "Where price <=" . $_GET['price'] ." and name LIKE '%". $_GET['name']."%'";
    }
    else if ($_GET['price'] && $_GET['description']){
        $where = "Where price <=" . $_GET['price'] ." and description LIKE '%". $_GET['description']."%'";
    }
    else if ($_GET['name'] && $_GET['description']){
        $where = "Where `name` LIKE '%". $_GET['name']."%' and description LIKE '%". $_GET['description']."%'";
    }
    else if ($_GET['price']){
        $where = "Where price <=" . $_GET['price'];
    }
    else if ($_GET['name']){
        $where = "Where `name` Like '%" . $_GET['name']."%'";
    }
    else if ($_GET['description']){
        $where = "Where `description` Like '%" . $_GET['description']."%'";
    }
}

$sql = 'SELECT * FROM `games` '. $where . " ". $orderBy. ";";

try{

    $stmt = $connect->prepare($sql);
    $stmt->execute();

    echo "
    <form action='editTable.php' method='post' >
        <button type='submit' name='ins' value='1'>Добавить</button>
    </form>
    <table>
            <tr>
                <td>Logo</td>
                <td><a href='showTable.php?sortBy=idGame'>Id</a></td>
                <td><a href='showTable.php?sortBy=name'>Name</a></td>
                <td><a href='showTable.php?sortBy=description'>Description</a></td>
                <td><a href='showTable.php?sortBy=category'>Category</a></td>
                <td><a href='showTable.php?sortBy=price'>Price</a></td>
            </tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $showImg = base64_encode($row['logo2']);
        echo "
            <tr>
                <td>
                    <img src='data:image/png;base64, " . $showImg . "' width = '50px' height = '50px'/>
                </td>
                <td>" . $row['idGame'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['description'] . "</td>
                <td>" . $row['category'] . "</td>
                <td>" . $row['price'] ."</td>
                <td>
                    <form action='editTable.php' method='post' >
                        <input type='hidden' name='idGame' value='".$row['']."'/>
                        <input type='hidden' name='idGame' value='".$row['idGame']."'/>
                        <input type='hidden' name='name' value='".$row['name']."'/>
                        <input type='hidden' name='description' value='".$row['description']."'/>
                        <input type='hidden' name='category' value='".$row['category']."'/>
                        <input type='hidden' name='price' value='".$row['price']."'/>
                        
                        <button type='submit' name='upd' value='".$row['idGame']."'>Редактировать</button>
                        <button type='submit' name='del' value='".$row['idGame']."'>Удалить</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} catch(PDOException $e){
    echo 'Error: ' . $e -> getMessage();
}
$connect = null;
?>
