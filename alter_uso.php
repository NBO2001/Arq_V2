<?php
session_start();
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
include_once "ConAL.php";
$result_usuario = "SELECT * FROM log";
$resultado_usuario = mysqli_query($conn, $result_usuario);
?>
<!DOCTYPE>
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

<title>Usuarios</title>
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
  <input type="checkbox" id="chec">
  <nav id="nave">
  		<ul>
        <li><a href="tela_inicial.php">Inicio</a></li>

  		<li><a href="sair.php">Sair</a></li>
  		</ul>
  </nav>
<div style="overflow: auto;height: 200px;border:solid 1px;position:absolute;width:1115px;left:150px;top:110px;">
<table style="position:absolute;top:0px;" id='minhaTabela'>
   <thead>
        <tr>
             <th>Usuario</th>
             <th>Nivel de acesso</th>
             <th>Setor</th>
             <th>Editar</th>
             <th>Remover</th>
        <tr>
   </thead>
   <tbody>
     <?php
     while($row_usuario = mysqli_fetch_array($resultado_usuario)){
     ?>
        <tr>
             <td><?php echo $row_usuario['ursu']; ?></td>
             <td><?php echo $row_usuario['acesso']; ?></td>
             <td><?php echo $row_usuario['setor']; ?></td>
             <td><button onclick="window.location.href='alter_uso.php?id=<?php echo $row_usuario['id']; ?>'">Editar</button></td>
             <td><button onclick="remov(<?php echo $row_usuario['id']; ?>);">Remover</button></td>
             </tr>
           <?php } ?>

   </tbody>
   
</table>
</div>
<button style='position: absolute;left:20px;top:320;font-size:40px;' onclick="window.location.href='admini.php'">Voltar</button>
<script>
function remov(id) {
  var r = confirm("Deseja remolver usuário ?");
  if (r == true) {
    window.location.href='rev_uso_fun.php?id='+id;
  } else {
    
  }
}
</script>
<?php
if(isset($_GET['id']) AND is_numeric($_GET['id'])){
  $nun=$_GET['id'];
    $vl ="SELECT * FROM log WHERE id LIKE '".$nun."'";
    $rvl = mysqli_query($conn, $vl);
    $linha = mysqli_fetch_assoc($rvl);
    $ida = $linha['id'];
    $usuario = $linha['ursu'];
    $acesso = $linha['acesso'];
    $setor = $linha['setor'];
    if ($linha['id']==""){
      echo "<script>alert('Usuario não existe!!')</script>";
    }else{
      echo "<div id='up_usarios'> <form method='POST' action='up_uso.php?id=$ida'>
      <label class='formataurd' style='left:0px;top:320;font-size:40px;'>Nome de usuario:</label>
       <input class='formataurd' style='left:410px;top:320;' type='text' name='usernome' value='$usuario'><br><br>
       <label class='formataurd' style='left:0px;top:380;font-size:40px;'>Setor:</label>
       <select class='formataurd' style='left:410px;top:380;'  name='setor'>
          <option>$setor</option>
          <option>Arquivo acadêmico</option>
          <option>CAUSA</option>
          <option>CRC</option>
          <option>CRD</option>
          <option>CM</option>
	        <option>COA</option>
          <option>DPA</option>
        	<option>Protocolo</option>
        </select><br><br>
       <label style='left:0px;top:440;' class='formataurd'>Digite a senha:</label>
       <label class='formataurd' style='left:0px;top:500;'>Nivel de acesso</label>
       <input class='formataurd' style='left:410px;top:500;' type='number' min='1' max='4' value='$acesso' name='acesso' required><br><br>
      <input class='formataurd' style='left:820px;top:380;' type='submit' value='Atualizar'>
       </form></div>";
    }
}
?>
</body>
</html>
