<?php
session_start();
require_once 'Conec_PDO.php';
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
  die;
}
$aluno = $_GET['alid'];


if(isset($aluno)){
$soli = $_SESSION['id'];
$setor = $_SESSION['setor'];
$solicitacao = $aluno;
$obs = filter_input(INPUT_POST,'obs',FILTER_SANITIZE_STRING);
$destino = "Arquivo acadêmico";
$sts = 1;
$vr = 2;
$data = date('Y-m-d');
$urg = $_POST['urg'];
if(empty($urg)){$urg = 0;}

$vsoli = $pdo->prepare("SELECT * FROM mensa WHERE soli LIKE '$soli' AND setor LIKE '$setor' AND solicitacao LIKE '$solicitacao' AND sts LIKE '1'");
$vsoli->execute(array('id'));
$vsolir = $vsoli->fetchAll(PDO::FETCH_ASSOC);
if(empty($vsolir[0]['id'])){
  $env = $pdo->prepare("INSERT INTO mensa SET soli = '$soli',setor = '$setor',solicitacao = '$solicitacao',obv='$obs',destino='$destino',sts='$sts',a_nome = '',msg_d='',vr ='$vr',data = '$data',urg = '$urg'");
  if($env->execute()){
    header("Location:tela_inicial.php");
  }else{
    header("Location:tela_inicial.php");
    $_SESSION['ifon']="<script>alert('Falha ao tentar enviar')</script>";
    die;
  }
}else{
  header("Location:tela_inicial.php");
  $_SESSION['ifon']="<script>alert('Você já solicitou está pasta, aguarde a resposta do arquivo acadêmico.')</script>";
  die;
}
}
 ?>
