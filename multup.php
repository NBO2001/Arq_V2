<?php
session_start();
if($_SESSION['acesso']<>4){
 header("Location:index.php");
}
include_once 'ConAL.php';

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
    	<li><a href="pg_pesquisa.php">Pesquisa por matrícula</a></li>
        <li><a href="pg_pesquisa_nome.php">Pesquisa por nome</a></li>
        <li><a href='sair.php'>Sair</a></li>
    		</ul>
    </nav>
<div id="formmultup">
  <form enctype="multipart/form-data" method="POST" action="multup_fun.php">
  			<input type="file" name="arquivo[]" multiple="multiple" required/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
  			<input name="enviar" type="submit" value="Enviar">
  </form>
</div>
<div id="resuupmul">

<?php
if(isset($_SESSION['stuup'])){
  $stuo = $_SESSION['stuup'];
  echo $stuo;
  unset ($_SESSION['stuup']);
}
?>
</div>
</body>
</html>
