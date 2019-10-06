<?php
session_start();
if($_SESSION['acesso']=="" OR $_SESSION['acesso']<3){
  header("Location:index.php");
  die;
}
include_once 'ConAL.php';
$hid = $_GET['alid'];
$usuarioname=$_SESSION['usuarioname'];

$vregistroduplos = "SELECT * FROM Alunos WHERE id LIKE '$hid'";
$resultado_resgr = mysqli_query($conn, $vregistroduplos);
$row_usuariob = mysqli_fetch_array($resultado_resgr);
$a5 = $row_usuariob['id'];
$_SESSION['retorno'] = $a5;
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
        <li><a href="sair.php">Sair</a></li>
        </ul>
    </nav>
  </div>
<div  id="Alter_registro_est">
<form method="POST" >
  <h1 >Dados alteráveis<h1><br>
  <label >Nome civil: &nbsp</label><br>
  <input type='text' name='a1' value='<?php echo $row_usuariob['Nome_civil']; ?>' required><br>
  <label >Nome social: &nbsp</label><br>
  <input type='text' name='a2' value='<?php echo $row_usuariob['Nome_social']; ?>'><br>
  <label >Forma de evasão: &nbsp</label><br>
  <input name='a3' required value="<?php echo $row_usuariob['Fev']; ?>"><br>
  <label  >Ano de evsão: &nbsp</label><br>
  <input name='a4' value="<?php echo $row_usuariob['Aev']; ?>"><br><br>
  <h1 >Dados não alteráveis<h1><br>
  <label >Matrícula: &nbsp</label><br>
  <input  name="a5" value="<?php echo $row_usuariob['Num_mat'];?>" <?php if($_SESSION['acesso']<4){echo "readonly";} ?> ><br>
  <label >Curso: &nbsp</label><br>
  <input  readonly value="<?php echo $row_usuariob['Cod_cur']."--".$row_usuariob['Nome_cur']; ?>"><br>
  <label >Forma de ingresso: &nbsp</label><br>
  <input readonly value="<?php echo $row_usuariob['Fin']; ?>"><br>

  <label  >Ano de ingresso: &nbsp</label><br>
  <input  readonly value="<?php echo $row_usuariob['Ain']; ?>"><br><br>
  <input type="submit" name="atualizar"  value="Atualizar"><br>

</form>

</div>
<button id="btnalteruser"  onclick="window.location.href='pg_res_pes_mat.php?alid=<?php echo $_GET['alid'];?>'">voltar</button>

</body>
</html>
<?php

if (isset($_POST["atualizar"])){
$a1 = filter_input(INPUT_POST,'a1',FILTER_SANITIZE_STRING);
$a2 = filter_input(INPUT_POST,'a2',FILTER_SANITIZE_STRING);
$a3 = filter_input(INPUT_POST,'a3',FILTER_SANITIZE_STRING);
$a4 = filter_input(INPUT_POST,'a4',FILTER_SANITIZE_STRING);
$a6 = filter_input(INPUT_POST,'a5',FILTER_SANITIZE_STRING);
$encoding = 'UTF-8'; // ou ISO-8859-1...
$a1=mb_convert_case($a1, MB_CASE_UPPER, $encoding);
$a2=mb_convert_case($a2, MB_CASE_UPPER, $encoding);
/*$a11 = $row_usuariob['Num_mat'];

$a6 = $row_usuariob['Cod_cur'];
$a7 = $row_usuariob['Nome_cur'];
$a8 = $row_usuariob['Fin'];
$a9 = $row_usuariob['Ain'];
$a10 = $row_usuariob['sistema'];
$a12 = $row_usuariob['STS'];*/
if($_SESSION['acesso']<4)
{
  $vl ="UPDATE Alunos SET Nome_civil = '$a1', Nome_social = '$a2', Fev = '$a3', Aev = '$a4' WHERE Alunos.id =".$a5;
}else if($_SESSION['acesso']==4){
  $vl ="UPDATE Alunos SET Nome_civil = '$a1',Num_mat='$a6', Nome_social = '$a2', Fev = '$a3', Aev = '$a4' WHERE Alunos.id =".$a5;
}

$rvl = mysqli_query($conn, $vl) or die(mysqli_error($conn));

$_SESSION['ifon']="<script>alert('Alterado com sucesso')</script>";
header("Location:pg_res_pes_mat.php?alid=$a5");
}
?>
