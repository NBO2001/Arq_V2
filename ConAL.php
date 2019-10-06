<?php
ini_set('default_charset','UTF-8');
$db_hos = "localhost";
$use = "root";
$pss = "";
$ban = "Al";
$conn = new mysqli("$db_hos","$use","$pss","$ban");
//$conn = mysqli_connect("$db_hos","$use","$pss","$ban");
$conn -> query("
SET NAMES UTF8
");

?>
