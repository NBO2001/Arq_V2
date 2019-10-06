<?php
session_start();
$opc = $_GET['nome'];
if($opc == 'S'){
$varpes = $_GET['iddoc'];
$pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
$pdo -> query("SET NAMES UTF8");
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
