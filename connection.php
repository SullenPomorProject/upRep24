<?php
$hostdb = 'mysql:host=localhost;dbname=Market';
$login = 'root';
$password = '';

$connect = new PDO($hostdb, $login, $password);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!$connect){
    die('Error connect to DataBase');
}
?>