<?php
session_start();
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
include_once "ConAL.php";
if(is_numeric($_GET['id'])){
    $ida = $_GET['id'];
    $vl ="DELETE FROM log WHERE log.id =".$ida;
    $rvl = mysqli_query($conn, $vl);
    $_SESSION['ifon']="<script>alert('Removido com sucesso')</script>";
    header("Location:alter_uso.php");
}
 ?>
