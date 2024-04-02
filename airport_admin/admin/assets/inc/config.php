<?php
// Имя пользователя для доступа к базе данных
$dbuser = "root";
// Пароль для доступа к базе данных
$dbpass = "";
// Хост, где находится база данных
$host = "localhost";
// Имя базы данных, к которой осуществляется подключение
$db = "airport";
// Создание нового объекта mysqli и установка соединения с базой данных
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);
// Проверка наличия ошибок подключения
if($mysqli->connect_error) {
    die('Ошибка подключения (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
?>
