<?php
session_start();
if($_SESSION['acesso'] < 1){
  header("Location:index.php");
  die;
}
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}
 ?>
 <!DOCTYPE>
 <html>
 <head>
 <meta charset="utf-8"/>
 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
 <title>RELATORIOS</title>
<link rel="stylesheet" type="text/css" href="css/es.css">
<?php
if($_COOKIE["tema"] <> "a"){
  echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
}?>
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

<div id="relatorio_estilo">
 <form method="POST" >
   <label>Condição:</label>
   <select name="cond">
   <option>Igual</option>
     <option>Menor que</option>
     <option>Maior que</option>
   </select><br>
   <label>Ano:</label>
 <input name="query" type="number" min="1900" max="<?php $data=date('Y-m-d');$par = explode('-',$data); echo $par[0]; ?>"><br>
 <label>Curso:</label>

  <input id="assunto" name="curso" type="text"><br>
  <label>Forma de ingresso:</label>
  <input name="fi" type="text"><br>
  <label>Tipo de cota:</label>
  <select name='cota'>
<option></option>
  <option>AC</option>
  <option>PPI1</option>
  <option>PPI2</option>
  <option>NDC1</option>
  <option>NDC2</option>
  </select><br>
  <label>Forma de evasão:</label>
  <input name="fev" type="text"><br>
  <label>Sistema:</label>
   <input name="sistema" type="text"><br>
 <input name="enviaou"  type="submit" value="Gerar etiquetas">

 </form>
 <button onclick="window.location.href='admini.php'">Voltar</button>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function () {
        $("#assunto").autocomplete({
            source: 'cod_automplet.php'
        });
    });
</script>
 </body>
 </html>
 <?php
if(isset($_POST['enviaou'])){
  $Query = "SELECT  * FROM Alunos WHERE ";
  $condicao = $_POST['cond'];
  $valor = $_POST['query'];
  if ($condicao == "Igual" ){
    $condicao = "LIKE";

  }else if($condicao == "Menor que"){
    $condicao = "<";
    $valor = $valor + 1;
    $valor = (string)$valor;
  }else{
    $condicao = ">";
    $valor = $valor + 1;
    $valor = (string)$valor;
  }

  var_dump($valor);
  $ano_pesquisa =" Num_mat $condicao '".$valor[0].$valor[2].$valor[3]."%'";
  if($_POST['curso']<>""){
    $curso= $_POST['curso'];
    $curso = explode(" ",$curso);
    $curso = $curso[0];
  }else{
    $curso="";
  }
echo $curso;
  $curso ="AND Cod_cur LIKE '".$curso."%'";
  $sis =$_POST['sistema']."%";
  $sistema ="AND sistema LIKE '$sis'";
  $cota = $_POST['cota']."%";
  $fi ="AND Fin LIKE '".$_POST['fi']."%$cota'";
  $fev ="AND Fev LIKE '".$_POST['fev']."%'";



  $query = $Query.$ano_pesquisa.$curso.$fi.$fev.$sistema;
  $_SESSION['query'] = $query;
 header("Location:gerado_de_etiquetas.php");
}

  ?>
