<?php
session_start();
require_once 'Conec_PDO.php';
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
set_time_limit(0);

if(!empty($_FILES['up_xml']['tmp_name'])){
  $proc = new DomDocument('utf-8');
  $proc->load($_FILES['up_xml']['tmp_name']);
  $linhas = $proc->getElementsByTagName('Row');
  $cabecalho = true;
  $cont = 0;
  $encoding = 'UTF-8';
  $msg_erro = "";
  foreach ($linhas as $linha) {
    if($cabecalho <> true){
      $id_sie = isset($linha->getElementsByTagname('Data')->item(0)->nodeValue)
      ?$linha->getElementsByTagname('Data') -> item(0)->nodeValue : "null";

      $nome_aluno = isset($linha->getElementsByTagname('Data') -> item(1)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(1)->nodeValue : "null";

      $forma_ingresso = isset($linha->getElementsByTagname('Data')->item(2)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(2)->nodeValue : "null";

      $cod_curso = isset($linha->getElementsByTagname('Data')->item(4)->nodeValue)
      ?$linha -> getElementsByTagname('Data') -> item(4)->nodeValue : "null";

      $nome_curso = isset($linha->getElementsByTagname('Data')->item(5)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(5)->nodeValue : "null";

      $forma_evasao = isset($linha->getElementsByTagname('Data')->item(3)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(3)->nodeValue : "null";

      $matricula = isset($linha->getElementsByTagname('Data')->item(6)->nodeValue)
      ?$linha->getElementsByTagname('Data') -> item(6)->nodeValue : "null";

      $periodo_ingesso = isset($linha->getElementsByTagname('Data')->item(7)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(7)->nodeValue : "null";

      $periodo_evasao = isset($linha->getElementsByTagname('Data')->item(8)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(8)->nodeValue : "null";

      $nome_social = isset($linha->getElementsByTagname('Data')->item(9)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(9)->nodeValue : "null";

      $sistema = isset($linha->getElementsByTagname('Data')->item(10)->nodeValue)
      ?$linha->getElementsByTagname('Data')->item(10)->nodeValue : "null";
      
      $verid = $pdo->prepare("SELECT COUNT(*) AS total FROM Alunos WHERE Num_mat LIKE '$matricula'");
      $verid->execute();
      $total = $verid->fetchALL(PDO::FETCH_ASSOC);
      $total = $total[0]['total'];
      if($total == 0){
        $cod_curso=mb_convert_case($cod_curso, MB_CASE_UPPER, $encoding); 
        $matricula=mb_convert_case($matricula, MB_CASE_UPPER, $encoding);
        $nome_aluno=mb_convert_case($nome_aluno, MB_CASE_UPPER, $encoding);
        $nome_curso=mb_convert_case($nome_curso, MB_CASE_UPPER, $encoding);
        $forma_ingresso=mb_convert_case($forma_ingresso, MB_CASE_UPPER, $encoding);
        $forma_evasao=mb_convert_case($forma_evasao, MB_CASE_UPPER, $encoding);
        $periodo_ingesso=mb_convert_case($periodo_ingesso, MB_CASE_UPPER, $encoding);
        $periodo_evasao=mb_convert_case($periodo_evasao, MB_CASE_UPPER, $encoding);
        $sistema=mb_convert_case($sistema, MB_CASE_UPPER, $encoding);
        $nome_social=mb_convert_case($nome_social, MB_CASE_UPPER, $encoding);
        $envia_banck = $pdo->prepare( "INSERT INTO Alunos SET Cod_cur='$cod_curso',id_sie='$id_sie',
        Num_mat='$matricula', Nome_civil='$nome_aluno',Nome_cur='$nome_curso',
        Fin='$forma_ingresso',Fev='$forma_evasao',Ain='$periodo_ingesso',
        Aev='$periodo_evasao',sistema='$sistema',Nome_social='$nome_social'");
        $envia_banck->execute();

      }else{
        $msg_erro .= "# $id_sie - $nome_aluno - $forma_ingresso - $cod_curso  - $nome_curso - $forma_evasao - $matricula - $periodo_ingesso - $periodo_evasao - $nome_social - $sistema<br>";
      }

    }else{
      $cabecalho = false;
    }
  }
}
if($msg_erro == ""){
  $_SESSION['ifon'] = "<script>alert('Todos os dados alterados com sucesso!!')</script>";
}else{
  $_SESSION['ifon'] = "<span><----- REGISTROS NÃO ADICIONADOS -----><br>$msg_erro</span>";
}
header('Location:upload_por_xml.php');
?>
