<?php
require_once "Conec_PDO.php";
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:tela_inicial.php");
  die;
}

$id_apagar = $_POST['id_para_apagar'];

if(isset($id_apagar)){
$veri_db  =$pdo->prepare("DELETE FROM mensa WHERE id LIKE $id_apagar");
$veri_db->execute();
echo "<div class='alert alert-success' role='alert'>Solicitação apagada com sucesso!!!</div>";
}
?>