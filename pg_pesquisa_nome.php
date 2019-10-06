<?php
session_start();
if($_SESSION['acesso']==""){
  header("Location:index.php");
}

$tema = $_COOKIE["tema"];
 ?>
<!DOCTYPE HTML>

<html lang=pt-br>
<head>
<meta charset="utf-8">
<title>Tela inicial</title>
<link rel="stylesheet" type="text/css" href="css/es.css">
<?php
if($tema <> ""){
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
  <input type="checkbox" id="chec">
  <nav id="nave">
  		<ul>
        <li><a href="tela_inicial.php">Inicio</a></li>
  		<li><a href="pg_pesquisa.php">Pesquisa por matrícula</a></li>
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
<div id="Tpesq">
<form id="pesq_fom" method="Post" action="psq_nome.php" enctype="multipart/form-data">
  <label  class="a1">Digite o nome do aluno:</label><br><br>
	<input  class="inputbtn" type="text" name="nomeaa" placeholder="Digite o nome do aluno" minlength="3" required><br><br>
	<input class="inputbtn" id="pesquisa" name="pesqui" type="submit" value="Pesquisar"><br><br>
</form>
</div>
</body>

</html>
