<?php
session_start();
if($_SESSION['acesso']<>4){
  header("Location:index.php");
  die;
}
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}

?>
<!DOCTYPE html>
<html lang=pt-br>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/es.css">
<?php
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
        <li><a href="pg_ini1.php">Inicio</a></li>
      <li><a href="altera_tema.php">Alterar tema</a></li>
      <?php
     if ($_SESSION['msg']==4){
       echo "<li><a href='multup.php'>Adicionar documentos</a></li>";
        echo "<li><a href='ad_registro.php'>Adicionar registro</a></li>";
     }
     ?>
      <li><a href="sair.php">Sair</a></li>
      </ul>
  </nav>
</div>
<div id="ad_registro_from">
<form method="POST"  style="border: 1px solid black;" >
  <label >Nome civil: &nbsp</label><br>
  <input  type='text' name='a1' value='' required><br>
  <label >Nome social: &nbsp</label><br>
  <input  type='text' name='a2' value=''><br>
  <label >Matrícula: &nbsp</label><br>
  <input  type="text" name='a5'  value="" required><br>
  <label  >Sigla do curso: &nbsp</label><br>
  <input type="text" name='a10' required value=""><br>
  <label  >Curso: &nbsp</label><br>
  <input type="text" name='a6' required value=""><br>
  <label >Forma de ingresso: &nbsp</label><br>
  <input type="text" name='a7' required value=""><br>
  <label >Ano de ingresso: &nbsp</label><br>
  <input type="number" name='a8'  required value=""><br>
  <label  >Forma de evasão: &nbsp</label><br>
  <input type="text" name='a3'  value="" required><br>
  <label  >Ano de evsão: &nbsp</label><br>
  <input type="number" name='a4'  value=""><br>
  <label >Dados retirados do: &nbsp</label><br>
  <input type="text" name='a9'  required value=""><br><br>
<input type="submit" name="adicionarre" value="Adicionar">

</form>

</div>
<?php
$fun = "window.location.href='tela_inicial.php'";
echo "<button id='voltar_ad_registro' onclick=".$fun.">Voltar</button>";

?>
</body>
</html>
<?php
include_once 'ConAL.php';
if (isset($_POST["adicionarre"])){
$a1 = filter_input(INPUT_POST,'a1',FILTER_SANITIZE_STRING);
$a2 = filter_input(INPUT_POST,'a2',FILTER_SANITIZE_STRING);
$a3 = filter_input(INPUT_POST,'a3',FILTER_SANITIZE_STRING);
$a4 = filter_input(INPUT_POST,'a4',FILTER_SANITIZE_STRING);
$a5 = filter_input(INPUT_POST,'a5',FILTER_SANITIZE_STRING);
$a6 = filter_input(INPUT_POST,'a6',FILTER_SANITIZE_STRING);
$a7 = filter_input(INPUT_POST,'a7',FILTER_SANITIZE_STRING);
$a8 = filter_input(INPUT_POST,'a8',FILTER_SANITIZE_STRING);
$a9 = filter_input(INPUT_POST,'a9',FILTER_SANITIZE_STRING);
$a10 = filter_input(INPUT_POST,'a10',FILTER_SANITIZE_STRING);

$vl ="INSERT INTO Alunos SET Cod_cur = '$a10', Num_mat='$a5',Nome_civil='$a1',Nome_cur='$a6',Fin='$a7',Fev='$a3',Ain='$a8',Aev='$a4',sistema='$a9',Nome_social='$a2'";
$rvl = mysqli_query($conn, $vl) or die(mysqli_error($conn));
$_SESSION['ifon']="<script>alert('Adicionado com sucesso')</script>";
$_SESSION['ref'] = "<script>window.location.reload();</script>";
header("Location:tela_inicial.php");
}
?>
