<?php
session_start();
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
include_once "ConAL.php";
$ida = filter_input(INPUT_POST,'ida',FILTER_SANITIZE_STRING);

$vl ="DELETE FROM log WHERE log.id =".$ida;
$rvl = mysqli_query($conn, $vl);
$_SESSION['ifon']="<script>alert('Removido com sucesso')</script>";
header("Location:rev_uso.php");
 ?>
