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
<body id="pgini2">

  <?php
    if(isset($_SESSION['ifon'])){
      echo $_SESSION['ifon'];
      unset ($_SESSION['ifon']);

    }
  ?>

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
</div>
<div class="pesq" id="Tpesq">
<form id="pesq_mt" method="Post" action="pg_res_pes_mat.php" enctype="multipart/form-datan">
  <label class="a1" >Número de matrícula:</label><br><br>
	<input class="inputbtn" id="digta_valor" minlength="8" maxlength="9" type="text" name ="nume" placeholder="Digite a matrícula" required><br><br><br>
	<input id="pesquisa" class="inputbtn"  name="pesqui" type="submit" value="Pesquisar"><br>
</form>
</div>
</body>

</html>
