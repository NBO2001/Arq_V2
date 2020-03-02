<?php
require_once "Conec_PDO.php";
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}
$id_apagar = $_POST['id_para_apagar'];

if(isset($id_apagar)){
 
$veri_db  =$pdo->prepare("DELETE FROM log WHERE id LIKE $id_apagar");
$veri_db->execute();
echo "<div class='alert alert-success' role='alert'>Usuário apagado com sucesso!!!</div>";
}
?>