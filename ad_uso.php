<?php
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:index.php");
}
include_once "ConAL.php";
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
<title>Adcionar usuarios</title>
<?php
  if(isset($_SESSION['ifon'])){
    echo $_SESSION['ifon'];
    unset ($_SESSION['ifon']);
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
<div id="verificar_ad_uso">
 <form method="POST">
 <input  id="username" name="username" required><br><br>
<input  type="submit" value="Verificar dispolibilidade" >
</form>
 <br><br><form action="admini.php">
<br><br><input  type="submit"  value="Voltar" >
 </form>
</div>
 <?php $nun = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
 if($nun <> ""){
     $vl ="SELECT * FROM log WHERE ursu LIKE '".$nun."'";
     $rvl = mysqli_query($conn, $vl);
     $linha = mysqli_fetch_assoc($rvl);
     if ($linha['id']<>""){
       echo "<script>alert('Usuario já existe!!')</script>";
     }else{
       echo "<div id='form_ad_uso'><form method='POST' action='ad_uso_fun.php'>
       <label  >Nome de usuario:</label>
        <input   type='text' name='usernome' value='$nun' readonly><br><br>
        <label  >Setor:</label>
        <select   id='cli' name='cli'>
          <option>Arquivo acadêmico</option>
          <option>CRC</option>
          <option>CRD</option>
          <option>CM</option>
	  <option>COA</option>
         <option>DPA</option>
	<option>Protocolo</option>
        </select><br><br>
        <label >Digite a senha:</label>
        <input  type='text' name='senhauso' required><br><br>
        <label >Nivel de acesso</label>
        <input  type='number' min='1' max='3' name='acesso' required><br><br>
       <input  type='submit' value='Cadastrar'>
        </form></div>";
     }
}
 ?>
</body>
</html>
