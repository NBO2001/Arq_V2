<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
}
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}
include_once "ConAL.php";
$result_usuario = "SELECT * FROM mensa WHERE sts LIKE '1'";
$resultado_usuario = mysqli_query($conn, $result_usuario);

?>
<!DOCTYPE>
<html lang=pt-br>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/es.css">
<?php
if($_COOKIE["tema"] <> "a"){
  echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
}
?>

<title>Mensagens</title>
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
      <li><a href="sair.php">Sair</a></li>
      </ul>
  </nav>
  </div>
<div id="stymensare" >
<table style="position:absolute;top:0px;" id='minhaTabela'>
   <thead>
        <tr>
             <th>ID</th>
             <th>Setor</th>
             <th>Solicitante</th>
             <th>Solicitação</th>
             <th>Observação</th>

        <tr>
   </thead>
   <tbody>
     <?php
     while($row_usuario = mysqli_fetch_array($resultado_usuario)){
     ?>
        <tr>
             <td><?php echo $row_usuario['id'];?></td>
             <td><?php echo $row_usuario['setor']; ?></td>
             <td><?php echo $row_usuario['soli']; ?></td>
             <td><?php echo $row_usuario['solicitacao']; ?></td>
             <td><?php echo $row_usuario['obv']; ?></td>

             </tr>
           <?php } ?>

   </tbody>
</table>
</div>
<div id="btnmensavisu">
<form method="POST">
  <input id="bv" type="text" name="nome">
  <input id="btn111" name="sand" type="submit" value="Escrever mensagem">
</form>
<form method="POST">
  <input id="bv1" type="text" name="ida" style="display:none;" readonly>
  <input id="btn112"  type="submit" value="Abrir detalhes">
</form>
<form method="POST" action="tela_inicial.php">
  <input id="btn113"   name="sand" type="submit" value="Voltar">
</form>
</div>
<?php
$ida = filter_input(INPUT_POST,'ida',FILTER_SANITIZE_STRING);
if($ida <> ""){
$ida = explode('.',$ida);
header("Location:pg_res_pes_mat.php?alid=".$ida[1]);
}
?>

<?php $nun = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_STRING);
if($nun <> ""){
    $vl ="SELECT * FROM mensa WHERE id LIKE '".$nun."'";
    $rvl = mysqli_query($conn, $vl);
    $linha = mysqli_fetch_assoc($rvl);
    $ida = $linha['id'];

    if ($linha['id']==""){
      echo "<script>alert('Usuario não existe!!')</script>";
    }else{
      echo " <form id='msgevia' method='POST' action='mensa_re_fun.php'>
      <input class='formataurd' style='display:none;' type='text' name='ida' value='$ida' readonly><br><br>
      <label class='formataurd' style='left:0px;top:380;font-size:35px;'>Digite a mensagem:</label>
       <input class='formataurd' style='left:410px;top:380;' type='text' name='msg_ida'><br><br>
      <input class='formataurd' style='left:820px;top:380;' type='submit' value='Enviar'>
       </form>";
    }
}
?>


<script type="text/javascript">
var tabela = document.getElementById("minhaTabela");
var linhas = tabela.getElementsByTagName("tr");
for(var i = 0; i < linhas.length; i++){
var linha = linhas[i];
linha.addEventListener("click", function(){
selLinha(this, false);
});
}
function selLinha(linha, multiplos){
if(!multiplos){
var linhas = linha.parentElement.getElementsByTagName("tr");
for(var i = 0; i < linhas.length; i++){
  var linha_ = linhas[i];
  linha_.classList.remove("selecionado");
}
}
linha.classList.toggle("selecionado");
}
tabela.addEventListener("click", function(){
var selecionados = tabela.getElementsByClassName("selecionado");
if(selecionados.length < 1){
alert("Selecione pelo menos uma linha");
return false;
}
var dados = "";
for(var i = 0; i < selecionados.length; i++){
var selecionado = selecionados[i];
selecionado = selecionado.getElementsByTagName("td");
dados += "ID: " + selecionado[0].innerHTML + " - Nome: " + selecionado[1].innerHTML + " - Idade: " + selecionado[2].innerHTML + "\n";
var d = selecionado[0].innerHTML;
var da = selecionado[3].innerHTML;
}
document.getElementById("bv").value = d;

document.getElementById("bv1").value = da;
});

</script>
</body>
</html>
