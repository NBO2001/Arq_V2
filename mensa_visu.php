<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
  die;
}
include_once "ConAL.php";
$nomeus = $_SESSION['usuarioname'];
$result_usuario = "SELECT * FROM mensa WHERE soli LIKE '$nomeus' AND vr = 1";
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
<title>Caixa de entrada</title>
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
    		<li><a href="pg_pesquisa.php">Pesquisa por matrícula</a></li>
        <li><a href="pg_pesquisa_nome.php">Pesquisa por nome</a></li>
        <li><a href='sair.php'>Sair</a></li>
    		</ul>
    </nav>
  </div>
<div id="mesga">
<?php while($row_usuario = mysqli_fetch_array($resultado_usuario)){
$a_id= $row_usuario['id'];
$a_nome= $row_usuario['a_nome'];
$solicitacao = $row_usuario['solicitacao'];
$solicitacao = explode('.',$solicitacao);
$idd = $solicitacao[1];

$solicitacao = $solicitacao[0];
$msg_d= $row_usuario['msg_d'];
$kval = $idd.'-'.$a_id;
echo "<a href='redir_mesn.php?texto=$kval' > <p >De: $a_nome <br>A respeito da solicitação: $solicitacao <-- aqui para abrir<br>Resposta: $msg_d</p></a>";

}
$fun = "window.location.href='tela_inicial.php'";
echo "<button style='position:relative;top:50px;left:450px; font-size: 20px;color:white;background-color: black;border: 1px solid black;border-radius: 15px;width:400px;height:10%; 'onclick=".$fun.">Voltar</button>";?>


</div>




</body>
</html>
