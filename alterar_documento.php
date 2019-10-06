<?php
session_start();
if($_SESSION['acesso']<>4){
 header("Location:index.php");
 die;
}
if(isset($_SESSION['ifon'])){
  echo $_SESSION['ifon'];
  unset ($_SESSION['ifon']);
}
include_once "ConAL.php";

$classfi = filter_input(INPUT_POST,'classfi',FILTER_SANITIZE_STRING);
$sele = filter_input(INPUT_POST,'sele',FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST,'descricao',FILTER_SANITIZE_STRING);
$ano = filter_input(INPUT_POST,'ano',FILTER_SANITIZE_STRING);
$classfi = explode (' ',$classfi);
$classfi = $classfi[0];

$result_usuario = "SELECT * FROM Ife WHERE cod LIKE '$classfi'";
$resultado_usuario = mysqli_query($conn, $result_usuario);
$row_usuario = mysqli_fetch_array($resultado_usuario);
$classfi = $row_usuario['cod']." -- ".$row_usuario['nome_doc'];
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
$encoding = 'UTF-8'; // ou ISO-8859-1...

$descricao=mb_convert_case($descricao, MB_CASE_UPPER, $encoding);
$sele=mb_convert_case($sele, MB_CASE_UPPER, $encoding);
$vl ="UPDATE Ko SET nome = '$descricao', tipo_doc = '$classfi', ano_doc = '$ano', fase_con = '$fase_con', fase_in = '$fase_in', destin_fin = '$destin_fin', ano_ex = $ano_ex, class_doc = '$sele' WHERE Ko.id =".$_GET['id'];
$rvl = mysqli_query($conn, $vl) or die(mysqli_error($conn));

header("Location:pg_res_pes_mat.php?alid=".$_GET['alid']);
$_SESSION['ifon'] = "<script>alert('Alterado com sucesso!!')</script>";

?>
