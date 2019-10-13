<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
  die;
}
include_once "Conec_PDO.php";

$soli = filter_input(INPUT_POST,'soli',FILTER_SANITIZE_STRING);
if($soli <> ""){
  $setor = filter_input(INPUT_POST,'setor',FILTER_SANITIZE_STRING);
  $solicitacao = $_GET['numat'];
  $obv = filter_input(INPUT_POST,'obv',FILTER_SANITIZE_STRING);
  $destino = "Arquivo acadêmico";

$query_verificação="SELECT * FROM mensa WHERE soli LIKE '$soli' AND setor LIKE '$setor' AND solicitacao LIKE '$solicitacao' AND sts LIKE '1'";
$stmt = $pdo->prepare("$query_verificação");
$stmt->execute(array('id'));
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach($resultado as $item){
    $sre = $item['id'];
  }
if(isset($sre)){
  header("Location:tela_inicial.php");
  $_SESSION['ifon']="<script>alert('Você já solicitou está pasta, aguarde a resposta do arquivo acadêmico.')</script>";
  die;
}else{
  $sql = "INSERT INTO mensa (soli,setor,solicitacao,obv,destino,sts,a_nome,msg_d,vr) VALUES ('$soli','$setor','$solicitacao','$obv','$destino','1','','','2')";
  $inse = $pdo->prepare("$sql");
  if($inse->execute()){
   header("Location:tela_inicial.php");
   $solicitacao = explode('.',$solicitacao);
   $solicitacao = $solicitacao[0];
   $solicitacao = substr($solicitacao, 0,3);
   $data=date('Y')-11;
   $rest = substr($data, 0,1).substr($data, 2,2);

   if($solicitacao<=$rest){
     $_SESSION['ifon']="<script>alert('Pasta física localizada no arquivo sul a resposta poderá demorar alguns dias')</script>";
   }else{
     $_SESSION['ifon']="<script>alert('Mensagen enviada com sucesso')</script>";
   }
    die;
  }else{
    header("Location:tela_inicial.php");
    $_SESSION['ifon']="<script>alert('Falha ao tentar enviar')</script>";
    die;
  }

}

}



 ?>
