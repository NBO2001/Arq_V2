<?php
session_start();
if($_SESSION['acesso'] < 1){
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
$tbodya1 = "<tr>";
$tbodya2 = "<tr>";
$tbodya3 = "<tr>";
$tbodya4 ="<tr>";
$tbodya5 ="<tr>";
$tbodya6="<tr>";

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
if($contagem < 3){
  $linha1 = $linha1."<td class='xl72' >$curso</td>
        <td class='xl73' >$Nome_cur</td>";
  $linha3 = $linha3."<td class='xl74' colspan='2' >$Num_mat</td>";
  $linha4 = $linha4."<td class='xl76' colspan='2' >$Nome_civil</td>";
  $linha5 = $linha5."<td class='xl80' colspan='2' >$Fin</td>";
  $linha6 = $linha6."<td class='xl80' colspan='2' >$Ain</td>";
  $linha7 = $linha7."<td class='xl80' colspan='2'>$Fev</td>";
  $linha8 = $linha8."<td class='xl80' colspan='2'>$Aev</td>";
  $linha9 = $linha9."<td class='xl80' colspan='2'>$sistema</td>";
  $contagem++;
}else{
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
        <td class='xl73' >$Nome_cur</td>";
  $linha3 = $linha3."<td class='xl74' colspan='2' >$Num_mat</td>";
  $linha4 = $linha4."<td class='xl76' colspan='2' >$Nome_civil</td>";
  $linha5 = $linha5."<td class='xl80' colspan='2' >$Fin</td>";
  $linha6 = $linha6."<td class='xl80' colspan='2' >$Ain</td>";
  $linha7 = $linha7."<td class='xl80' colspan='2'>$Fev</td>";
  $linha8 = $linha8."<td class='xl80' colspan='2'>$Aev</td>";
  $linha9 = $linha9."<td class='xl80' colspan='2'>$sistema</td>";
  $contagem = 2;
}

 }
$valorfinal = explode("|",$valorfinal);
$aa=0;
while (isset($valorfinal[$aa])) {

    $tabelat =$tabelat."<tbody>".$valorfinal[$aa]."</tbody>|";
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
if($ab == 0){
  $tabela =$tabela."<div class ='div1'><table>".$am1.$am2.$am3.$am4."</table></div>";
  $ab = $ab + 4;
}else{
  $tabela =$tabela."<div class ='div2'><table>".$am1.$am2.$am3.$am4."</table></div>";
  $ab = $ab + 4;
}

}



 ?>
<?php
 include_once 'ConAL.php';
 $style = "#Modelo_body{
    padding:0px 0px;
 background-color: inherit;
}
.div1{
height:1110px;
}
.div2{
padding:0px 0px;
height:1090px;
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
  font-size: 9px;
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
unlink('/opt/lampp/htdocs/Arq_V2/'.$arquivo);
//header("Location:tela_inicial.php");
      ?>
