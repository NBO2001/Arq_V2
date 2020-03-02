<?php
session_start();
if($_SESSION['acesso']==""){
header("Location:index.php");
}
if(isset($_SESSION['ifon'])){
  echo $_SESSION['ifon'];
  unset ($_SESSION['ifon']);
}
include_once 'ConAL.php';
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
   <meta charset="utf=8">
   <meta http-equiv="refresh" content="120">
   <title>Tela inicial</title>
   <link rel="stylesheet" type="text/css" href="css/es.css">
   <link type='image/x-icon' rel='shortcut icon' href='icones/ufamicon.ico'>
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
   <script type="text/javascript">
  function ajax(){
    var req = new XMLHttpRequest();
    req.onreadystatechange = function(){
      if(req.readyState == 4 && req.status == 200){
         document.getElementById('chat').innerHTML = req.responseText;
      }
    }
    req.open('GET','chat.php',true);
    req.send();
  }
  setInterval(function(){ajax();},1000);
   </script>
 </head>
 <body onload="ajax();" id="pgini1">

 <?php if($_SESSION['acesso']>=2 && $_SESSION['acesso'] < 5){
   $result_usuarioa = "SELECT sts,count(sts) FROM mensa WHERE sts LIKE '1' GROUP BY sts";
   $resultado_usuarioa = mysqli_query($conn, $result_usuarioa);
   $row_usuarioa = mysqli_fetch_assoc($resultado_usuarioa);
   $nun_msg = $row_usuarioa['count(sts)'];
   if ($nun_msg == ""){
     $nun_msg = 0;
   }
 }else{
   $usuario = $_SESSION['id'];
   $result_usuarioa = "SELECT vr,count(vr) FROM mensa WHERE soli LIKE '$usuario' AND vr = 1 ORDER BY vr";
   $resultado_usuarioa = mysqli_query($conn, $result_usuarioa);
   $row_usuarioa = mysqli_fetch_assoc($resultado_usuarioa);
   $nun_msg = $row_usuarioa['count(vr)'];
   if ($nun_msg == ""){
     $nun_msg = 0;
   }
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
       <li><a href="alterar_senha.php">Perfil</a></li>
     <li><a href="altera_tema.php">Alterar tema</a></li>
     <?php
     if ($_SESSION['acesso']>=2){
       echo "<li><a href='mult_etq.php'>Gerar etiquetas por matricula</a></li>";
        echo "<li><a href='gerador_de_etq.php'>Gerar etiquetas por Condição</a></li>";
     }
    if ($_SESSION['acesso']==4){
      echo "<li><a href='multup.php'>Adicionar documentos</a></li>";
       echo "<li><a href='ad_registro.php'>Adicionar registro</a></li>";
    }
    ?>
     <li><a href="sair.php">Sair</a></li>
     </ul>
 </nav>
 </div>

 <div id="tela_inicial_tes" >
<!-- <button class="bntv1" id="btntest" onclick="window.location.href='pg_pesquisa.php'">Pesquisa por matrícula</button><br><br>-->

<input type="checkbox" id="check_btn1">
<button class="bntv1" id="btntest"><label for="check_btn1">Pesquisa por matrícula</label></button><br>
<form id="btn_pesquisa_mat" method="Post" action="pg_res_pes_mat.php" enctype="multipart/form-datan">
	<input  minlength="8" maxlength="9" type="text" name="nume" placeholder="Digite a matrícula" required="">
	<input name="pesqui" type="submit" value="Buscar">
</form><br>

<input type="checkbox" id="check_btn2">
<button class="bntv1" id="btntest"><label for="check_btn2">Pesquisa por nome</label></button><br>
<form id="btn_pesquisa_mat2" method="Post" action="psq_nome.php" enctype="multipart/form-datan">
  <input type="text" name="nomeaa" placeholder="Digite o nome do aluno" minlength="3" required>
  <input name="pesqui" type="submit" value="Buscar">
</form><br>

 <?php
if($_SESSION['acesso']==1){
   echo"<form  action='mensa_visu.php'>
    <button class='bntv1' id='btntest4'>Mensagem[$nun_msg]</button>
   </form><br>";
 }
if ($_SESSION['acesso']>=2){
$fun = "window.location.href='cor_etq.php'";
 echo "<button class='bntv1' onclick=".$fun.">Pesquisar curso</button><br><br>";
   echo"<form  action='mensa_re.php'>
    <button class='bntv1'  id='btntest4'>Mensagem[$nun_msg]</button>
   </form><br>";
 }
 if($_SESSION['acesso']==4){
   echo"<form  action='admini.php'>
    <button class='bntv1' id='btntest3'>Ferramentas administrativas</button>
   </form><br>";
 }
 ?>
 </div>
 <?php
 if($_SESSION['acesso']<>1){
 echo "<div id='chat_campo'><div  id='chat'>

 </div>
 <div>
   <form id='campo' method='POST' action='envianochat.php'>
   <input type='text' name='msg' placeholder='Escreva a mensagen' autocomplete='off' required>
   <input type='submit' value='Enviar'>
   </form>
 </div>
 </div>";
 }
 ?>
 </body>
 <footer>
 <label >&copy;2019 N.B.O <br>Suporte: arquivo_proeg@ufam.edu.br<label>
</footer> 
 </html>
