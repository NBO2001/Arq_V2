<?php
session_start();
if($_SESSION['acesso']==""){
  header("Location:index.php");
  die;
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
    if(isset($_SESSION['retorno'])){
      unset ($_SESSION['retorno']);

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
      <li><a href="pg_ini1.php">Inicio</a></li>
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
<div id="formaltertema">
<form method="post">
<select name="tem">
  <option>Padrão</option>
  <option>Gi19</option>
</select>
<input type="submit" value="Alterar">
</form>
</div>
</body>

</html>
<?php
$temina = filter_input(INPUT_POST,'tem',FILTER_SANITIZE_STRING);
if($temina<>""){
  if($temina=="Padrão"){
    setcookie("tema","a", (time() + (500 * 24 * 3600)));
    header("Location:tela_inicial.php");

  }else{
    setcookie("tema","$temina", (time() + (500 * 24 * 3600)));
    header("Location:tela_inicial.php");
  }
}


?>
