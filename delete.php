<?php
require "db.php";
$row=$_POST['id'];
$results = mysqli_query($db,"DELETE FROM posts WHERE id=".$row."");
?>