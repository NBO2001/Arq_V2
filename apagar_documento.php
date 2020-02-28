<?php
session_start();
require_once 'Conec_PDO.php';
$opc = $_GET['nome'];
if($opc == 'S'){
$varpes = $_GET['iddoc'];
$stmt = $pdo->prepare("SELECT can FROM Ko WHERE id LIKE $varpes");
$stmt->execute(array('can'));
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $item){
$caminho = $item['can'];
if(unlink("/home/arquivo/Área de Trabalho".$caminho)){
$stmtapagar = $pdo->prepare("DELETE FROM Ko WHERE Ko.id = $varpes");
$stmtapagar->execute();
header("Location:pg_res_pes_mat.php?alid=".$_GET['alid']);
}else{
  $_SESSION['ifon'] = "<script>alert('Falha!!')</script>";
  header("Location:pg_res_pes_mat.php?alid=".$_GET['alid']);
  die;
}
}
}else{
  header("Location:pg_res_pes_mat.php?alid=".$_GET['alid']);
}
 ?>
