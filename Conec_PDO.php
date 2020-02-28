<?php
$bd = 'Al';
$us = 'root';
$sn = 123;

$pdo = new PDO( 'mysql:host=localhost;dbname='.$bd, $us, $sn );
$pdo -> query("SET NAMES UTF8");
?>
