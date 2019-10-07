<?php
require_once 'Classes/Alunos.php';
require_once 'Classes/Etiquetas.php';
$var = $_GET['etq'];
$var = explode(',',$var);
$contador = 0;
$tabela ="";
while (isset($var[$contador])) {
$al = new Aluno();
$al -> pesquisa_banco2($var[$contador]);
$et = new Etiquetas();
$et -> etq($al->getCod(),$al->getNome_cur(),$al->getNum_mat(),$al->getNome_civil(),$al->getFin(),$al->getAin(),$al->getFev(),$al->getAev(),$al->getSistema());
$a1="<tr>";
$a2="<tr>";
$a3="<tr>";
$a4="<tr>";
$a5="<tr>";
$a6="<tr>";
$a7="<tr>";
$a8="<tr>";
$a1  .=$et->getA1();
$a2 .=$et->getA2();
$a3 .=$et->getA3();
$a4 .=$et->getA4();
$a5 .=$et->getA5();
$a6 .=$et->getA6();
$a7 .=$et->getA7();
$a8 .=$et->getA8();
if(isset($var[$contador+1])){
  $al2 = new Aluno();
  $al2 -> pesquisa_banco2($var[1]);
  $et2 = new Etiquetas();
  $et2 -> etq($al2->getCod(),$al->getNome_cur(),$al2->getNum_mat(),$al2->getNome_civil(),$al2->getFin(),$al2->getAin(),$al2->getFev(),$al2->getAev(),$al2->getSistema());
  $a1 .=$et2->getA1();
  $a2 .=$et2->getA2();
  $a3 .=$et2->getA3();
  $a4 .=$et2->getA4();
  $a5 .=$et2->getA5();
  $a6 .=$et2->getA6();
  $a7 .=$et2->getA7();
  $a8 .=$et2->getA8();
}
$a1.="</tr>";
$a2.="</tr>";
$a3.="</tr>";
$a4.="</tr>";
$a5.="</tr>";
$a6.="</tr>";
$a7.="</tr>";
$a8.="</tr>";
$tabela .= $a1.$a2.$a3.$a4.$a5.$a6.$a7.$a8;
  $contador = $contador+2;
}

$tabela ="<table><tbody>".$tabela."</tbody></table>";

$style = "#Modelo_body{
 background-color: inherit;
}
#Modelo_body table{
  padding:0px 0px;
width:16cm;
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



$arquivo = "Etiqueta.html";
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

?>
