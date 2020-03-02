<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
  die;
}
require_once 'Conec_PDO.php';
$nome = $_SESSION['usuarioname'];
$id_soli =  $_POST['passau_id'];
$msg = $_POST['msg'];
$resp = $pdo->prepare("UPDATE mensa SET sts = '0', a_nome = '$nome', msg_d = '$msg',vr='1' WHERE mensa.id =".$id_soli);
if($resp->execute()){
  $_SESSION['ifon']="<script>alert('Enviada com sucesso')</script>";
  header("Location:mensa_re.php");
}else{
  $_SESSION['ifon']="<script>alert('Erro')</script>";
  header("Location:mensa_re.php");
}
?>
