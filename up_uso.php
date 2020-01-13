<?php
session_start();
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
include_once "ConAL.php";
if(isset($_GET['id']) AND is_numeric($_GET['id'])){
    $ida = $_GET['id'];
    $usernome = filter_input(INPUT_POST,'usernome',FILTER_SANITIZE_STRING);
    $setor = filter_input(INPUT_POST,'setor',FILTER_SANITIZE_STRING);
    $acesso = filter_input(INPUT_POST,'acesso',FILTER_SANITIZE_STRING);

    $vl ="UPDATE log SET ursu = '$usernome', acesso = '$acesso', setor = '$setor' WHERE log.id =".$ida;
    $rvl = mysqli_query($conn, $vl);
    $_SESSION['ifon']="<script>alert('Alterado com sucesso')</script>";
    header("Location:alter_uso.php");
}else{
    header("Location:alter_uso.php");
    $_SESSION['ifon']="<script>alert('ERRO')</script>";
}
 ?>