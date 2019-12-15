<?php
require_once 'Classes/Alunos.php';
require_once 'Classes/Tabela.php';
$al = new Aluno();
$al->pesquisa_banco2($_GET['alid']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset='utf-8'>
  <link rel="stylesheet" type="text/css" href="css/es.css">
  <link type='image/x-icon' rel='shortcut icon' href='ufamicon.ico'>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="js/add.js"></script>
  <?php
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}
if($_COOKIE["tema"] <> "a"){
  echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
}
?>
</head>
<body id='bodymlt'>
<div id="logoufam" >
  <label for="chec">
  <img width="100px" height="90px" src="ufam.png"/>
</label>
  <label id="insti">Universidade Federal do Amazonas<br>
  Pró-Reitoria de Ensino de Graduação<br>
  Departamento de Registro Acadêmico<br>
  Arquivo Acadêmico<br>
  </label>
  </div>
  <div>
  <input type="checkbox" id="chec">
  <nav id="nave" >
    		<ul>
          <li><a href="tela_inicial.php">Inicio</a></li>
    		<li><a href="pg_pesquisa.php">Pesquisa por matrícula</a></li>
        <li><a href="pg_pesquisa_nome.php">Pesquisa por nome</a></li>
       <li><a href='sair.php'>Sair</a></li>
    		</ul>
    </nav>
  </div>
<?php   
$al->exibir(); 
?>
<div  id="tab" class="tabelapgmat">
<?php
$tb = new Tabela();
$tb->setIm($al->getId());
$tb->pesquisa_doc3();
$tb->exibir_tabela();
?>
</div>
<div id='controle_add'>
<label>Consultar classificação do documento:&nbsp;</label>
<input  type="text" name="assunto" id="assunto" placeholder="consulte a classificação"/>
<button onclick='adcamp();'>Adicionar campo</button>
<button onclick='copir();'>Copiar</button>
<button onclick='voltar(<?php echo $al->getId()?>);'>Voltar</button>
</div>
<form name="form1" enctype="multipart/form-data" action="fun_enviar_documentos.php?id=<?php echo $al->getId(); ?>&mat=<?php echo $al->getNum_mat(); ?>" method="post">
<div id="campoOriegem"></div>
<br><input type="submit" value="Enviar">
</form>
</body>
</html>
<script>
var conta = 1;
function adcamp(){
novocampo();
document.getElementById('assunto').select();
document.execCommand('copy');
document.getElementById("clone"+conta).value = document.getElementById('assunto').value;
document.getElementById('assunto').value = "";
conta++;
}
function copir(){
document.getElementById('assunto').select();
document.execCommand('copy');
document.getElementById('assunto').value = "";
}
function visul(id){
var re = confirm("Deseja visualizar o documento?")
if (re == true){
  window.open('pdf_visu.php?id='+id,'_blank');
} 
}
function voltar(id){
  window.open('pg_res_pes_mat.php?alid='+id,'_top');
}
</script>
