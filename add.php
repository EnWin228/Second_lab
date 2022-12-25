<?php

$result = $_POST['list'];

if ($result =='') {
    header('Location: index.php');
}
require 'db.php';
date_default_timezone_set('Europe/Moscow');
$time = date("Y-d-m H:i:s");

$resultall = mysqli_query($db, "INSERT INTO posts (text,likes,dtime) VALUES('$result','0','$time')");

header('Location: index.php');

