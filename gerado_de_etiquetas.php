<?php
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:index.php");
  die;
}
include_once "Conec_PDO.php";
if(isset($_SESSION['query'])){
  $query = $_SESSION['query'];
}
$stmt = $pdo->prepare("$query ORDER BY Alunos.Cod_cur ASC, Num_mat ASC");
$stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Fin','Fev','Ain','Aev','sistema'));

$tabela = "";
$tbodya1 = "<tr style='height:46.50pt;mso-height-source:userset;mso-height-alt:930;'>";

$tbodya2 = "<tr style='height:31.50pt;mso-height-source:userset;mso-height-alt:630;' height='42'>";

$tbodya3 = "<tr style='height:25.50pt;mso-height-source:userset;mso-height-alt:510;' height='34'>";
$tbodya4 ="<tr style='height:24.00pt;mso-height-source:userset;mso-height-alt:480;' height='32'>";
$tbodya5 ="<tr style='height:15.00pt;mso-height-source:userset;mso-height-alt:300;' height='20'>";
$tbodya6="<tr style='height:15.00pt;mso-height-source:userset;mso-height-alt:300;' height='20'>";


$linha1 = "";
$linha3 = "";
$linha4 = "";
$linha5 = "";
$linha6 = "";
$linha7 = "";
$linha8 = "";
$linha9 = "";
$valorfinal="";
$tabelat = "";
$contagem = 1;
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
if($contagem <= 2){
  $linha1 = $linha1."<td class='xl72' >$curso</td>
        <td class='xl73' >$Nome_cur</td>";
  $linha3 = $linha3."<td class='xl74' colspan='2' >$Num_mat</td>";
  $linha4 = $linha4."<td class='xl76' colspan='2' >$Nome_civil</td>";
  $linha5 = $linha5."<td class='xl78' colspan='2' >$Fin</td>";
  $linha6 = $linha6."<td class='xl78' colspan='2' >$Ain</td>";
  $linha7 = $linha7."<td class='xl78' colspan='2'>$Fev</td>";
  $linha8 = $linha8."<td class='xl80' colspan='2'>$Aev</td>";
  $linha9 = $linha9."<td class='xl80' colspan='2'>$sistema</td>";
  $contagem++;
}else{
  $linha9 =$linha9."<td colspan='2' style='mso-ignore:colspan;'></td>";
  $valorfinal =$valorfinal.$tbodya1.$linha1."</tr>".$tbodya2.$linha3."</tr>".$tbodya4.$linha4."</tr>".$tbodya5.$linha5."</tr>".$tbodya5.$linha6."</tr>".$tbodya5.$linha7."</tr>".$tbodya5.$linha8."</tr>".$tbodya6.$linha9."</tr>";
  $valorfinal = $valorfinal."|";
  $linha1 = "";
  $linha3 = "";
  $linha4 = "";
  $linha5 = "";
  $linha6 = "";
  $linha7 = "";
  $linha8 = "";
  $linha9 = "";

  $linha1 = $linha1."<td class='xl72' >$curso</td>
        <td class='xl73' >A$Nome_cur</td>";
  $linha3 = $linha3."<td class='xl74' colspan='2' >$Num_mat</td>";
  $linha4 = $linha4."<td class='xl76' colspan='2' >$Nome_civil</td>";
  $linha5 = $linha5."<td class='xl78' colspan='2' >$Fin</td>";
  $linha6 = $linha6."<td class='xl78' colspan='2' >$Ain</td>";
  $linha7 = $linha7."<td class='xl78' colspan='2'>$Fev</td>";
  $linha8 = $linha8."<td class='xl80' colspan='2'>$Aev</td>";
  $linha9 = $linha9."<td class='xl80' colspan='2'>$sistema</td>";
  $contagem = 2;
}

 }
$valorfinal = explode("|",$valorfinal);
$aa=0;
while (isset($valorfinal[$aa])) {
  $tabelat = $tabelat."<tbody>".$valorfinal[$aa]."</tbody>|";
  $aa++;
}
$tabelat = explode("|",$tabelat);
$ab=0;
$am1="";
$am2="";
$am3="";
$am4="";
while (isset($tabelat[$ab])) {
if(isset($tabelat[$ab])){
  $am1 = $tabelat[$ab];
}
if(isset($tabelat[$ab+1])){
  $am2 = $tabelat[$ab+1];
}
if(isset($tabelat[$ab+2])){
  $am3 = $tabelat[$ab+2];
}
if(isset($tabelat[$ab+3])){
  $am4 = $tabelat[$ab+3];
}

$tabela =$tabela."<table>".$am1.$am2.$am3.$am4."</table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
$ab = $ab + 5;
}



 ?>
<?php
 include_once 'ConAL.php';
 $style = "#Modelo_body{
 	background-color: inherit;
 }
 #Modelo_body table{
 width:741.95pt;
 border-collapse:collapse;
 table-layout:fixed;
 border:1px solid black;
 }
 #Modelo_body .xl72{
 font-weight: bold;
 font-size: 50px;
 height:46.50pt;
 width:155.90pt;
 border:1px solid black;
 }
 #Modelo_body .xl73{
 font-size: 20px;
 	width:155.35pt;
 	border:1px solid black;
 }
 #Modelo_body td{

 	border-right:.5pt solid black;
 	border-bottom:.5pt solid black;
 	border-bottom-style:hairline;
 }
 #Modelo_body .xl74{
 	font-weight: bold;
 	font-size: 40px;
 height:31.50pt;

 }
 #Modelo_body .xl76{
 	font-weight: bold;
 height:25.50pt;
 }
 #Modelo_body .xl78{
 height:24.00pt;

 }
 #Modelo_body .xl80{
 height:15.00pt;
 }
 ";
      // Montamos nosso HTML no PHP, da forma que quisermos
      // \t é o tab, \n a quebra de linha
      $html  = "<!DOCTYPE html><html lang='pt-br'>\n";
      $html .= "\t<head><meta charset='utf-8'><style>$style</style>\n";
      $html .= "\t\t<title>Etiquetas</title>\n";
      $html .= "\t</head>\n";
      $html .= "\t<body id ='Modelo_body'>\n";
      $html .= "$tabela";
      $html .= "\t</body>\n";
      $html .= "</html>\n";

      //... e vai montando o arquivo com variáveis etc
      // e depois salva
      $arquivo = "Etiquetas.html";
      // Configurações header para forçar o download
file_put_contents($arquivo, $html);

set_time_limit(0);
$arquivoLocal = '/opt/lampp/htdocs/Arq_V2/'.$arquivo;
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
header("Location:gerador_de_etq.php");
      ?>
