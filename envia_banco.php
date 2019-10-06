<?php
session_start();
if($_SESSION['acesso']== 1 or $_SESSION['acesso']== 2 or $_SESSION['acesso']== "" ) {
  header("Location:index.php");
  die;
}

  unset ($_SESSION['ifon']);

include_once 'ConAL.php';

  $nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
  $ano = filter_input(INPUT_POST,'ano',FILTER_SANITIZE_STRING);
  $tipo_doc =filter_input(INPUT_POST,'assunto',FILTER_SANITIZE_STRING);
  $tipo_docu = strtoupper( filter_input(INPUT_POST,'sele',FILTER_SANITIZE_STRING));
  $nome_arq =  $_FILES['pdf']['name'];
  $nome_arq  = explode('.',$nome_arq);
  $tipo_doc = explode (' ',$tipo_doc);
  $tipo_doc = $tipo_doc[0];
  $result_usuario = "SELECT * FROM Ife WHERE cod LIKE '$tipo_doc'";
  $resultado_usuario = mysqli_query($conn, $result_usuario);
  $row_usuario = mysqli_fetch_array($resultado_usuario);


  date_default_timezone_set('America/Sao_Paulo');
  $dataLocal = date('d-m-Y', time());
  $dataL = date('Y-m-d', time());
  $data=date('H:i:s');
  $data=explode(':',$data);
  $horari = $data[0]-1;
  $horari = $horari = $dataLocal." -- ".$horari.":".$data[1].":".$data[2];
  $usuarioname = $_SESSION['usuarioname'];
  $nun = $_SESSION['id'];
if ($tipo_docu =="FICHA CADASTRAL" ){
$coman = "SELECT * FROM Ko WHERE imagem LIKE '$nun' AND class_doc LIKE 'FICHA CADASTRAL'";
$ver = mysqli_query($conn,$coman);
$verificador = mysqli_fetch_array($ver);
$dois = $verificador['id'];
}

if ($nun==""){
 header("Location:Pesquisa.php");
 $_SESSION['ifon']="<script>alert('Campo vazio!!')</script>";

}else if($row_usuario['id'] == ""){
header("Location:pg_res_pes_mat.php");
$_SESSION['ifon']="<script>alert('Tipo do documento invalido!!')</script>";
$_SESSION['ref'] = "<script>window.location.reload();</script>";
}else if($nome_arq[1] <> "pdf"){
  header("Location:pg_res_pes_mat.php");
  $_SESSION['ifon'] = "<script>alert('Arquivo não suportado!!')</script>";
  $_SESSION['ref'] = "<script>window.location.reload();</script>";
}else if($verificador['id']<>""){
    header("Location:pg_res_pes_mat.php");
    $_SESSION['ifon']="<script>alert('O Aluno já tem ficha cadastral!!')</script>";
    $_SESSION['ref'] = "<script>window.location.reload();</script>";

}else {
  $tipo_doc = $row_usuario['cod']." -- ".$row_usuario['nome_doc'];
  $fase_con =$row_usuario['fase_con'];
  $fase_con =explode(' ',$fase_con);
  $ano_va = $fase_con[0];
  $fase_in = $row_usuario['fase_in'];
  $fase_in = explode(' ',$fase_in);
  $ano_vb = $fase_in[0];
  if ($ano_va > 0){
    if ($ano_vb>0){
      $ano_ex = $ano_va+$ano_vb;
      $ano_ex = $ano + $ano_ex;
      $ano_ex ="'".$ano_ex."'";
      $fase_con =$row_usuario['fase_con'];
      $fase_in = $row_usuario['fase_in'];
    }else{
      $ano_ex = $ano_va;
      $ano_ex = $ano + $ano_ex;
      $ano_ex ="'".$ano_ex."'";
      $fase_con =$row_usuario['fase_con'];
      $fase_in = $row_usuario['fase_in'];

    }
  }else {
    if ($ano_vb>0){
      $ano_ex = $ano_vb;
      $ano_ex =$ano + $ano_ex;
      $ano_ex ="'".$ano_ex."'";
      $fase_con =$row_usuario['fase_con'];
      $fase_in = $row_usuario['fase_in'];

    }else{
      $ano_ex ="NULL";
      $fase_con =$row_usuario['fase_con'];
      $fase_in = $row_usuario['fase_in'];
    }
  }

  $destin_fin = $row_usuario['destin_fin'];
  $dire = "/home/arquivo/Área de Trabalho/In/pdf/".$nun."/";
  mkdir($dire);
  chmod ($dire,0777);
  if(move_uploaded_file($_FILES['pdf']['tmp_name'],$dire.$tipo_docu." -- ".$horari.".pdf")){
    $fp = fopen("test.sh","a+");
      $fop = "test.sh";
      chmod ($fop,0777);
    $nome_pdf = $tipo_docu." -- ".$horari.".pdf";
    $can = "/In/pdf/".$nun."/".$nome_pdf;
    $tes = "
      git add pdf/".$nun."/
      git commit -m '".$nome."'";

      fwrite($fp, $tes);
      fclose($fp);

      $sql = "INSERT INTO Ko (id,nome, imagem,nome_pdf,tipo_doc,ano_doc,data_inserido,can,fase_con,fase_in,destin_fin,ano_ex,usuarioname,class_doc) VALUES (NULL,'$nome', '$nun','$nome_pdf','$tipo_doc','$ano','$dataL','$can','$fase_con','$fase_in','$destin_fin',$ano_ex,'$usuarioname','$tipo_docu')";
      $rs = mysqli_query($conn,$sql);
      //passthru('sh test.sh');

      header("Location:pg_res_pes_mat.php?alid=$nun");
      $_SESSION['retorno'] = $_SESSION['id'];

      unset ($_SESSION['id']);
      $_SESSION['ifon'] = "<script>alert('Salvo com sucesso!!')</script>";
  }else{
    header("Location:pg_res_pes_mat.php?alid=$nun");
    $_SESSION['ifon'] = "<script>alert('Falha!!')</script>";
  }

}

?>
