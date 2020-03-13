<?php
error_reporting(0);
session_start();
include_once 'Conec_PDO.php';
if(isset($_GET['alid'])){
  $if =  $_GET['alid'];
}
?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
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
<body id="Modelo_body">

<div class="div1">
  <!-- Inicio tabela-->
<table class="folha">
  <tbody>
    
<?php
$stmt = $pdo->prepare("SELECT * FROM Alunos WHERE id LIKE $if");
$stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Fin','Fev','Ain','Aev','sistema'));
foreach($stmt as $res){
$curso = $res['Cod_cur'];
$Num_mat = $res['Num_mat'];
$Nome_civil = $res['Nome_civil'];
$Fin = $res['Fin'];
$Fev = $res['Fev'];
$Ain = $res['Ain'];
$Nome_cur = $res['Nome_cur'];
$Aev = $res['Aev'];
$sistema = $res['sistema'];
}
$tabela = "<tr>
<td class='xl72' >$curso</td>
<td class='xl73' >$Nome_cur</td>
<td class='xl72' ></td>
<td class='xl73' ></td>
 </tr>
 <tr>
<td class='xl74' colspan='2' >$Num_mat</td>
<td class='xl74' colspan='2' ></td>
 </tr>
 <tr>
 <td class='xl76' colspan='2' >$Nome_civil</td>
  <td class='xl76' colspan='2' ></td>
 </tr>
 <tr>
<td class='xl78' colspan='2' >$Fin</td>
<td class='xl78' colspan='2' ></td>
 </tr>
<tr >
<td class='xl80' colspan='2' >$Ain</td>
<td class='xl80' colspan='2' ></td>
</tr>
<tr >
<td class='xl80' colspan='2'>$Fev</td>
<td class='xl80' colspan='2'></td>
</tr>
<tr >
<td class='xl80' colspan='2'>$Aev</td>
<td class='xl80' colspan='2'></td>
</tr>
<tr>
<td class='xl80' colspan='2'>$sistema</td>
<td class='xl80' colspan='2'></td>
</tr>";
echo $tabela;
?>
</tbody>


   

  <tbody>
  <tr>
    <td class="xl72"></td>
    <td class="xl73"></td>
    <td class="xl72"></td>
    <td class="xl73"></td>
  </tr>
  <tr>
    <td class="xl74" colspan="2"></td>
    <td class="xl74" colspan="2"></td>
  </tr>
  <tr>
    <td class="xl76" colspan="2"></td>
    <td class="xl76" colspan="2"></td>
  </tr>
  <tr>
  <td class="xl80" colspan="2"></td>
    <td class="xl80" colspan="2"></td>
  </tr>
  <tr>
    <td class="xl80" colspan="2"></td>
    <td class="xl80" colspan="2"></td>
  </tr>
  <tr>
    <td class="xl80" colspan="2"></td>
    <td class="xl80" colspan="2"></td>
  </tr>
  <tr>
    <td class="xl80" colspan="2"></td>
    <td class="xl80" colspan="2"></td>
  </tr>
  <tr>
    <td class="xl80" colspan="2"></td>
    <td class="xl80" colspan="2"></td>
  </tr>
</tbody>

<tbody>
<tr>
  <td class="xl72"></td>
  <td class="xl73"></td>
  <td class="xl72"></td>
  <td class="xl73"></td>
</tr>
<tr>
  <td class="xl74" colspan="2"></td>
  <td class="xl74" colspan="2"></td>
</tr>
<tr>
  <td class="xl76" colspan="2"></td>
  <td class="xl76" colspan="2"></td>
</tr>
<tr>
    <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
</tbody>
<tbody>
<tr>
  <td class="xl72"></td>
  <td class="xl73"></td>
  <td class="xl72"></td>
  <td class="xl73"></td>
</tr>
<tr>
  <td class="xl74" colspan="2"></td>
  <td class="xl74" colspan="2"></td>
</tr>
<tr>
  <td class="xl76" colspan="2"></td>
  <td class="xl76" colspan="2"></td>
</tr>
<tr>
<td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
<tr>
  <td class="xl80" colspan="2"></td>
  <td class="xl80" colspan="2"></td>
</tr>
</tbody>
</table>
<!--Fim tabela-->
</div>
  

  
</body>
</html>

<?php
/*
 include_once 'ConAL.php';
 $style = "#Modelo_body{
 	background-color: inherit;
 }
 #Modelo_body table{
   padding:0px 0px;
 width:8cm;
 height:7cm;
 border-collapse:collapse;
 border:1px solid black;
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
 font-size: 20px;
 	border:1px solid black;
 }
 #Modelo_body td{
 	border-right:.5pt solid black;
 	border-bottom:.5pt solid black;
 	border-bottom-style:hairline;
 }
 #Modelo_body .xl74{
   text-align:left;
    height:1cm;
 	font-weight: bold;
 	font-size: 30px;


 }
 #Modelo_body .xl76{
   height:1cm;
   font-size:18px;

 }
 #Modelo_body .xl78{
    height:1cm;
 font-size:15px;

 }
 #Modelo_body .xl80{
   font-size:11px;
    height:0.5cm;
 }
 ";

      $html  = "<!DOCTYPE html><html lang='pt-br'>\n";
      $html .= "\t<head><meta charset='utf-8'><style>$style</style>\n";
      $html .= "\t\t<title>Etiquetas</title>\n";
      $html .= "\t</head>\n";
      $html .= "\t<body id ='Modelo_body'>\n";
      $html .= "$tabela";
      $html .= "\t</body>\n";
      $html .= "</html>\n";
echo  $html;


 $arquivo = "Etiqueta.html";
 // Configurações header para forçar o download
file_put_contents($arquivo, $html);

set_time_limit(0);
$arquivoLocal = '/var/www/html/'.$arquivo;
if (!file_exists($arquivoLocal)) {
exit;
}
$novoNome = 'Etq_geradas.html';
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename="'.$novoNome.'"');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($arquivo));
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Expires: 0');
// Envia o arquivo para o cliente
readfile($arquivo);
exit;
header("Location:pg_res_pes_mat.php");
*/

?>
