<?php
session_start();
include_once 'ConAL.php';
  $codcur = $_GET['numat'];
  $idalu = $_GET['alid'];

?>
<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
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
<title>Enviar msg</title>
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
  </div>
<form method="POST" id="formsolicita" action=<?php echo "solicitacao.php?numat=".$codcur.".".$idalu;?>>
<label>Solicitante:<label>
<input type="text" name="soli" value="<?php echo $_SESSION['usuarioname']; ?>" readonly>&emsp;&emsp;&emsp;
<label >Setor: <label >
<input type="text" name="setor" value="<?php echo $_SESSION['setor']; ?>" readonly><br><br>
<label>Aluno solicitado:<label>
<input type="text" name="solicitacao" value="<?php echo $codcur; ?>" readonly>&emsp;&emsp;&emsp;
<label>Observação:<label>
<input name="obv" type="text"><br><br>
<input type="submit" value="Enviar">
</form><br><br>
<form action="pg_res_pes_mat.php">
<input type="submit" value="Voltar">
</form>
</body>
</html>
