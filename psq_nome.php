<?php
session_start();
if($_SESSION['acesso']==""){
  header("Location:index.php");
}
require_once 'Classes/Alunos_nome.php';
$n = new Alunos_nome();
if(isset($_GET['nun'])){
$n -> pesquisa_matricula($_GET['nun']);
}else{
$nomepes = filter_input(INPUT_POST,'nomeaa',FILTER_SANITIZE_STRING);
$n -> pesquisa_nome($nomepes);

}
?>
<!DOCTYPE html>
<html lang=pt-br>
<head>
<meta charset="UTF-8">

<link rel="stylesheet" type="text/css" href="css/es.css">
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
<title>Inserir</title>
</head>
<body class="pes_nome_body">
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
        <?php
        if($_SESSION['acesso']<>1){
          echo "<li><a href='mensa_re.php'>Mensagem</a></li>";
        }else if($_SESSION['acesso']==1){
            echo "<li><a href='mensa_visu.php'>Mensagem</a></li>";
        }
        ?>
        <li><a href="sair.php">Sair</a></li>
    		</ul>
    </nav>
<div id="tabn">
<?php
  $n -> exibir_tabela();
?>
</div>
<script type="text/javascript">
  var tabela = document.getElementById("minhaTabela");
var linhas = tabela.getElementsByTagName("tr");
for(var i = 0; i < linhas.length; i++){
var linha = linhas[i];
linha.addEventListener("click", function(){
selLinha(this, false);
});
}
function selLinha(linha, multiplos){
if(!multiplos){
var linhas = linha.parentElement.getElementsByTagName("tr");
for(var i = 0; i < linhas.length; i++){
  var linha_ = linhas[i];
  linha_.classList.remove("selecionado");
}
}
linha.classList.toggle("selecionado");
}
tabela.addEventListener("click", function(){
var selecionados = tabela.getElementsByClassName("selecionado");

if(selecionados.length < 1){
alert("Selecione pelo menos uma linha");
return false;
}
var dados = "";
for(var i = 0; i < selecionados.length; i++){
var selecionado = selecionados[i];
selecionado = selecionado.getElementsByTagName("td");
dados += selecionado[2].innerHTML + " -> " + selecionado[3].innerHTML + "\n";
var d = selecionado[0].innerHTML;
}
//alert(dados);
var x;
var r=confirm('Deseja visualizar detalhes de '+dados+"?" );
if (r==true)
  {
  window.location.href='pg_res_pes_mat.php?alid='+d;
  }
else
  {
  var x='N';
  }
document.getElementById("bv").value = d;
});
</script>
</body>
</html>
