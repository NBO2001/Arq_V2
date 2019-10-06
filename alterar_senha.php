<?php
session_start();
include_once "ConAL.php";
$usuario = $_SESSION['usuarioname'];
if(isset($usuario)){}else{header("Location:tela_inicial.php"); die;}
$vla ="SELECT id FROM log WHERE ursu LIKE '$usuario' ";
$rvla = mysqli_query($conn, $vla) or die( "Ocorreu um erro");
$idf = mysqli_fetch_array($rvla);
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf=8">
<title>Tela inicial</title>

<link rel="stylesheet" type="text/css" href="css/es.css">
<?php
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
      <li><a href="altera_tema.php">Alterar tema</a></li>
      <?php
     if ($_SESSION['acesso']==4){
       echo "<li><a href='multup.php'>Adicionar documentos</a></li>";
     }
     ?>
      <li><a href="sair.php">Sair</a></li>
      </ul>
  </nav>
  </div>
  <div id="altesenha">
    <form method="POST" >
      <label >Login:</label><br>
        <input  name="nuso" type="text" value="<?php echo $_SESSION['usuarioname']; ?>" readonly></input><br>
        <label >Nova senha:</label><br>
          <input  name="sensuso" type="text" minlength="3" maxlength="15" required></input><br><br>
          <label >Digite novamente a senha:</label><br>
            <input  name="senusov" type="text" minlength="3" maxlength="15" required></input><br><br>
        <input name="btnlo" id="btnaltersenha" type="submit" value="Alterar"></input><br><br><br><br><br><br>
        <label>&copy;2019 N.B.O<label>
    </form>

  </div>
</body>
</html>
<?php
$senha1 = filter_input(INPUT_POST, 'sensuso', FILTER_SANITIZE_STRING);
$senha2 = filter_input(INPUT_POST, 'senusov', FILTER_SANITIZE_STRING);
if($senha1 == $senha2){
  if($senha1<>""){
    $vl ="UPDATE log SET senha='$senha1' WHERE log.id=".$idf['id'];
    $rvl = mysqli_query($conn, $vl) or die( "Ocorreu um erro");
    $_SESSION['ifon'] = "<script>alert('Alterado com sucesso!!')</script>";
    header("Location:tela_inicial.php");
    $senha1 = "";
  }
}else{
  echo "<script>alert('Senhas não conferem')</script>";
}



?>
