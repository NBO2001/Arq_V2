<?php
session_start();
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
include_once "ConAL.php";
$ida = filter_input(INPUT_POST,'ida',FILTER_SANITIZE_STRING);
$usernome = filter_input(INPUT_POST,'usernome',FILTER_SANITIZE_STRING);
$setor = filter_input(INPUT_POST,'setor',FILTER_SANITIZE_STRING);
$senhauso = filter_input(INPUT_POST,'senhauso',FILTER_SANITIZE_STRING);
$acesso = filter_input(INPUT_POST,'acesso',FILTER_SANITIZE_STRING);

$vl ="UPDATE log SET ursu = '$usernome', senha = '$senhauso', acesso = '$acesso', setor = '$setor' WHERE log.id =".$ida;
$rvl = mysqli_query($conn, $vl);
$_SESSION['ifon']="<script>alert('Alterado com sucesso')</script>";
header("Location:alter_uso.php");
 ?>
