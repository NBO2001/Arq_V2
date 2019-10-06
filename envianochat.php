<?php
session_start();
include_once 'ConAL.php';
$nome = $_SESSION['usuarioname'];
$msg = filter_input(INPUT_POST,'msg',FILTER_SANITIZE_STRING);
if($msg<>""){
  $quer = "INSERT INTO chat (id, uso, msg) VALUES (NULL, '$nome', '$msg')";
  $rexe = mysqli_query($conn, $quer)or die(mysqli_error($conn));
}
header("Location:tela_inicial.php");

?>
