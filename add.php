<?php

$result = $_POST['list'];


$uploaddir = './img/';
$uploadfile = $uploaddir . basename($_FILES['file']['name']);

move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)){
    echo "Ошибка загрузки файла";
}
if (($result =='') or ($_FILES['file']['name']=='')) {
    header('Location: index.php');
}
require 'db.php';
date_default_timezone_set('Europe/Moscow');
$time = date("Y-d-m H:i:s");

$resultall = mysqli_query($db, "INSERT INTO posts (text,likes,dtime,image) VALUES('$result','0','$time','$uploadfile')");

header('Location: index.php');

