<?php
require_once "Conec_PDO.php";
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}
$id_para_ativar = $_POST['id_para_ativar'];

if(isset($id_para_ativar)){
$atualizar  = $pdo->prepare("UPDATE log SET acesso = '1' WHERE log.id =".$id_para_ativar);
if($atualizar->execute()){
  echo "<div class='alert alert-success' role='alert'>Usuário ativado com sucesso!!!</div>";
}else{
  echo "<div class='alert alert-danger' role='alert'>Falhaaaa!!!</div>";
}

}

?>