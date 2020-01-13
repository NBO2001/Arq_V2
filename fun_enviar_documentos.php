<?php
session_start();
if($_SESSION['acesso']== 1 or $_SESSION['acesso']== 2 or $_SESSION['acesso']== "" ) {
  header("Location:index.php");
  die;
}
require_once 'Conec_PDO.php' ;
date_default_timezone_set('America/Manaus');
ini_set('upload_max_filesize', '20000M');
ini_set('post_max_size', '20000M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);
set_time_limit(0);

$conf = fopen('conf.txt','r');
$conf = fgets($conf,1022);
$arquivo = isset($_FILES['pdf']) ? $_FILES['pdf'] : FALSE;
$tipodoc = $_POST['sele'];
$clasifica = $_POST['class'];
$complemento = $_POST['complemento'];
$ano = $_POST['ano'];
$id = $_GET['id'];
$matricula = $_GET['mat'];
$msg_erro = "";
for ($controle = 0; $controle < count($arquivo['name']); $controle++){
  $extenção = explode(".",$arquivo['name'][$controle]);
  if ($extenção[1] == "pdf"){
    $classicacao = explode (' ',$clasifica[$controle]);
    $classicacao = $classicacao[0];
    $conect = $pdo->prepare("SELECT * FROM Ife WHERE cod LIKE '$classicacao'");
    $conect->execute();
    $result = $conect->fetchAll(PDO::FETCH_ASSOC);
    if (isset($result[0]['cod'])){
      $data = date('Y-m-d', time());
      $fasecorrente = explode(" ",$result[0]['fase_con']);
      $fasecorrente = is_numeric($fasecorrente[0])?$fasecorrente[0]:0;
      $faseintermediaria = explode(" ",$result[0]['fase_in']);
      $faseintermediaria = is_numeric($faseintermediaria[0])?$faseintermediaria[0]:0;
      if (($faseintermediaria+$fasecorrente)>0){
        $guardar=$ano[$controle]+($faseintermediaria+$fasecorrente);
      }else{
        $guardar=0;
      }

      if(!is_dir($conf."/In/pdf/".$id)){
      	mkdir($conf."/In/pdf/".$id);
        chmod ($conf."/In/pdf/".$id,0777);
      }
      $nomedocumento = "$matricula-".$result[0]['id']."-$controle-".date('His').".pdf";

      $destino = $conf."/In/pdf/".$id.'/'.$nomedocumento;
      $cla = $result[0]['cod']." -- ".$result[0]['nome_doc'];
      $can = $id."/".$nomedocumento;
      $fase1 = $result[0]['fase_con'];
      $fase2 = $result[0]['fase_in'];
      $fase3 = $result[0]['destin_fin'];
      $usuario = $_SESSION['usuarioname'];
      if (move_uploaded_file($arquivo['tmp_name'][$controle], $destino)) {
        $ise = $pdo->prepare("INSERT INTO Ko SET nome = '$complemento[$controle]',imagem = '$id',nome_pdf='$nomedocumento',
          tipo_doc='$cla',ano_doc='$ano[$controle]',data_inserido='$data',can='$can',fase_con='$fase1',fase_in='$fase2',
          destin_fin='$fase3',ano_ex='$guardar',usuarioname='$usuario',class_doc='$tipodoc[$controle]'");
        $ise->execute();
      }else {
        $msg_erro .="-ERRO NO DOCUMENTO $nomedocumento - $controle <br>";
      }
    }else{
      $msg_erro .="-ERRO NO DOCUMENTO - $controle - classificação inexistente! <br>";
    }
  }else{
    $msg_erro .="-ERRO NO DOCUMENTO - $controle - não é pdf! <br>";
  }
}
if(isset($msg_erro)){
$_SESSION['msg_erro'] = "<span>$msg_erro</span>";
}
header("Location:pg_res_pes_mat.php?alid=$id");
?>
