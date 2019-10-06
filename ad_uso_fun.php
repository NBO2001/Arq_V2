<?php
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:index.php");
}
include_once "ConAL.php";

$usernome = filter_input(INPUT_POST,'usernome',FILTER_SANITIZE_STRING);
if($usernome <> ""){
  $setor = filter_input(INPUT_POST,'cli',FILTER_SANITIZE_STRING);
  $senha = filter_input(INPUT_POST,'senhauso',FILTER_SANITIZE_STRING);
  $acesso = filter_input(INPUT_POST,'acesso',FILTER_SANITIZE_STRING);
  $sql = "INSERT INTO log (ursu,senha,acesso,setor) VALUES ('$usernome','$senha','$acesso','$setor')";
  $rs = mysqli_query($conn,$sql);
  header("Location:ad_uso.php");
  $_SESSION['ifon']="<script>alert('Adcionado com sucesso')</script>";
}else{
  header("Location:ad_uso.php");
  $_SESSION['ifon']="<script>alert('falha ao tentar')</script>";

}

 ?>
