<?php
require_once "Conec_PDO.php";
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}
$id_apagar = $_POST['id_para_apagar'];

if(isset($id_apagar)){
$atualizar  = $pdo->prepare("UPDATE log SET acesso = '0' WHERE log.id =".$id_apagar);
if($atualizar->execute()){
  echo "<div class='alert alert-success' role='alert'>Usuário desativado com sucesso!!!</div>";
}else{
  echo "<div class='alert alert-danger' role='alert'>Falhaaaa!!!</div>";
}

}
?>