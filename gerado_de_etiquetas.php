<?php
error_reporting(0);
session_start();

require_once "Conec_PDO.php";
if($_SESSION['acesso'] < 1){
  header("Location:index.php");
  die;
}

if(isset($_SESSION['query'])){
  $query = $_SESSION['query'];
  $etqs = "<!DOCTYPE html>
<html lang='pt-br'>
<head>
        <meta charset='utf-8'>
        <style>
          *{
	        font-family:Calibri,Arial Narrow,arial,helvetica;
          }
        .folha{
            page-break-after: always;
          }
        #Modelo_body{
            padding:0px 0px;
        background-color: inherit;
        }
        #Modelo_body table{
          padding:0px 0px;
        width:15.5cm;
        height:25.5cm;
        border-collapse:collapse;
        border:1px solid black;
        overflow: auto;
        }
        #Modelo_body .xl72{
        font-weight: bold;
        font-size: 45px;
        height:1.5cm;
        width:3.5cm;
        border:1px solid black;

        }
        #Modelo_body .xl73{
          width:4.5cm;
        border:1px solid black;
        }
        #Modelo_body td{
        border-right:.5pt solid black;
        border-bottom:.5pt solid black;
        }
        #Modelo_body .xl74{
          text-align:left;
          height:1cm;
        font-weight: bold;
        font-size: 30px;
        }
        #Modelo_body .xl76{
          height:1cm;
        }
        #Modelo_body .xl78{
          height:1cm;
          padding:0px 0px;
        }
        #Modelo_body .xl80{
          font-size: 11px;
          height:0.5cm;
        }
        </style>
<title>Etiquetas</title>
</head>
<body id ='Modelo_body'>

<div class ='div1'>";
$quant = $pdo->prepare("SELECT  COUNT(*) FROM Alunos WHERE $query ORDER BY Alunos.Cod_cur ASC, Num_mat ASC");
$quant->execute();
$quant = $quant->fetchAll(PDO::FETCH_ASSOC);
$quant = $quant[0]['COUNT(*)']/8;
$quant = ceil($quant);
$pd_at = 1;
$quant_atual = 1;

while($pd_at <= $quant ){
    $lis = $pdo->prepare("SELECT * FROM Alunos WHERE $query ORDER BY Alunos.Cod_cur ASC, Num_mat ASC LIMIT $quant_atual,8");
    $lis->execute();
    $lis = $lis->fetchAll(PDO::FETCH_ASSOC);
   
$etqs .=  "  <!-- Inicio tabela-->
<table class='folha'>
  <tbody>
    <tr>
      <td class='xl72' >".$lis[0]['Cod_cur']."</td>
      <td class='xl73' >".$lis[0]['Nome_cur']."</td>
      <td class='xl72' >".$lis[1]['Cod_cur']."</td>
      <td class='xl73' >".$lis[1]['Nome_cur']."</td>
    </tr>
    <tr>
      <td class='xl74' colspan='2' >".$lis[0]['Num_mat']."</td>
      <td class='xl74' colspan='2' >".$lis[1]['Num_mat']."</td>
    </tr>
    <tr>
      <td class='xl76' colspan='2' >".$lis[0]['Nome_civil']."</td>
      <td class='xl76' colspan='2' >".$lis[1]['Nome_civil']."</td>
    </tr>
    <tr>
    <td class='xl80' colspan='2' >".$lis[0]['Fin']."</td>
      <td class='xl80' colspan='2' >".$lis[1]['Fin']."</td>
    </tr>
    <tr>
      <td class='xl80' colspan='2' >".$lis[0]['Ain']."</td>
      <td class='xl80' colspan='2' >".$lis[1]['Ain']."</td>
    </tr>
    <tr>
      <td class='xl80' colspan='2'>".$lis[0]['Fev']."</td>
      <td class='xl80' colspan='2'>".$lis[1]['Fev']."</td>
    </tr>
    <tr>
      <td class='xl80' colspan='2'>".$lis[0]['Aev']."</td>
      <td class='xl80' colspan='2'>".$lis[1]['Aev']."</td>
    </tr>
    <tr>
      <td class='xl80' colspan='2'>".$lis[0]['sistema']."</td>
      <td class='xl80' colspan='2'>".$lis[1]['sistema']."</td>
    </tr>
  </tbody>
  <tbody>
  <tr>
    <td class='xl72' >".$lis[2]['Cod_cur']."</td>
    <td class='xl73' >".$lis[2]['Nome_cur']."</td>
    <td class='xl72' >".$lis[3]['Cod_cur']."</td>
    <td class='xl73' >".$lis[3]['Nome_cur']."</td>
  </tr>
  <tr>
    <td class='xl74' colspan='2' >".$lis[2]['Num_mat']."</td>
    <td class='xl74' colspan='2' >".$lis[3]['Num_mat']."</td>
  </tr>
  <tr>
    <td class='xl76' colspan='2' >".$lis[2]['Nome_civil']."</td>
    <td class='xl76' colspan='2' >".$lis[3]['Nome_civil']."</td>
  </tr>
  <tr>
  <td class='xl80' colspan='2' >".$lis[2]['Fin']."</td>
    <td class='xl80' colspan='2' >".$lis[3]['Fin']."</td>
  </tr>
  <tr>
    <td class='xl80' colspan='2' >".$lis[2]['Ain']."</td>
    <td class='xl80' colspan='2' >".$lis[3]['Ain']."</td>
  </tr>
  <tr>
    <td class='xl80' colspan='2'>".$lis[2]['Fev']."</td>
    <td class='xl80' colspan='2'>".$lis[3]['Fev']."</td>
  </tr>
  <tr>
    <td class='xl80' colspan='2'>".$lis[2]['Aev']."</td>
    <td class='xl80' colspan='2'>".$lis[3]['Aev']."</td>
  </tr>
  <tr>
    <td class='xl80' colspan='2'>".$lis[2]['sistema']."</td>
    <td class='xl80' colspan='2'>".$lis[3]['sistema']."</td>
  </tr>
</tbody>

<tbody>
<tr>
  <td class='xl72' >".$lis[4]['Cod_cur']."</td>
  <td class='xl73' >".$lis[4]['Nome_cur']."</td>
  <td class='xl72' >".$lis[5]['Cod_cur']."</td>
  <td class='xl73' >".$lis[5]['Nome_cur']."</td>
</tr>
<tr>
  <td class='xl74' colspan='2' >".$lis[4]['Num_mat']."</td>
  <td class='xl74' colspan='2' >".$lis[5]['Num_mat']."</td>
</tr>
<tr>
  <td class='xl76' colspan='2' >".$lis[4]['Nome_civil']."</td>
  <td class='xl76' colspan='2' >".$lis[5]['Nome_civil']."</td>
</tr>
<tr>
    <td class='xl80' colspan='2' >".$lis[4]['Fin']."</td>
  <td class='xl80' colspan='2' >".$lis[5]['Fin']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2' >".$lis[4]['Ain']."</td>
  <td class='xl80' colspan='2' >".$lis[5]['Ain']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2'>".$lis[4]['Fev']."</td>
  <td class='xl80' colspan='2'>".$lis[5]['Fev']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2'>".$lis[4]['Aev']."</td>
  <td class='xl80' colspan='2'>".$lis[5]['Aev']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2'>".$lis[4]['sistema']."</td>
  <td class='xl80' colspan='2'>".$lis[5]['sistema']."</td>
</tr>
</tbody>
<tbody>
<tr>
  <td class='xl72' >".$lis[6]['Cod_cur']."</td>
  <td class='xl73' >".$lis[6]['Nome_cur']."</td>
  <td class='xl72' >".$lis[7]['Cod_cur']."</td>
  <td class='xl73' >".$lis[7]['Nome_cur']."</td>
</tr>
<tr>
  <td class='xl74' colspan='2' >".$lis[6]['Num_mat']."</td>
  <td class='xl74' colspan='2' >".$lis[7]['Num_mat']."</td>
</tr>
<tr>
  <td class='xl76' colspan='2' >".$lis[6]['Nome_civil']."</td>
  <td class='xl76' colspan='2' >".$lis[7]['Nome_civil']."</td>
</tr>
<tr>
<td class='xl80' colspan='2' >".$lis[6]['Fin']."</td>
  <td class='xl80' colspan='2' >".$li[7]['Fin']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2' >".$lis[6]['Ain']."</td>
  <td class='xl80' colspan='2' >".$lis[7]['Ain']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2'>".$lis[6]['Fev']."</td>
  <td class='xl80' colspan='2'>".$lis[7]['Fev']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2'>".$lis[6]['Aev']."</td>
  <td class='xl80' colspan='2'>".$lis[7]['Aev']."</td>
</tr>
<tr>
  <td class='xl80' colspan='2'>".$lis[6]['sistema']."</td>
  <td class='xl80' colspan='2'>".$lis[7]['sistema']."</td>
</tr>
</tbody>
</table>
<!--Fim tabela-->"  ;

$pd_at++;
$quant_atual = $quant_atual+8;

}
$etqs .="
</div>
  </body>

  </html>
";
echo $etqs;
}else{
  echo "ERRO!";
}
?>
