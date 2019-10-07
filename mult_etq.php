<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset='utf-8'>
<title>Mult etiquetas</title>
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
</head>
<body>
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
      <li><a href="sair.php">Sair</a></li>
      </ul>
  </nav>
  </div>
  <div id="estilo_mult_etq">
  <form method='POST' >
    <input name='matri' type="text" placeholder="Digite o número de matrícula"><br><br>
    <input  name="bt_pesq" value="Pesquisar" type='submit'>
  </form>
</div>
</body>
</html>
<?php
  require_once 'Classes/Alunos.php';
if(isset($_GET['etq'])){
    $id = $_GET['etq'];
    echo "<div id='gerar_tqtas'><form method='POST' action='gera_mult_etq.php?etq=$id' >
    <input type='submit' value='Gerar etiquetas' name='btn_gerar'>
    </form></div>";
}
if(isset($_POST['bt_pesq'])){
$ma = $_POST['matri'];
$al = new Aluno();
$al->pesquisa_banco($ma);
$al->exibir();

if(isset($_GET['etq'])){
  $id = $_GET['etq'].",".$al->getId();
}else{
  $id =$al->getId() ;
}
echo "<div id='adicinat'>
<form method='POST' action='mult_etq.php?etq=$id' >
<input  type='submit' value='Adicionar' name='btn_ad'>
</form></div>";
}

?>
