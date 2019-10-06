<?php
session_start();
if($_SESSION['acesso']== 1 or $_SESSION['acesso']== 2 or $_SESSION['acesso']== "" ) {
  header("Location:index.php");
  die;
}
 ?>
 <?php
   if(isset($_SESSION['ifon'])){
     echo $_SESSION['ifon'];
     unset ($_SESSION['ifon']);
   }
   if(isset($_COOKIE["tema"])){
     $tema = $_COOKIE["tema"];
   }else{
     setcookie("tema","a", (time() + (500 * 24 * 3600)));
   }
 ?>
<?php

 include_once "ConAL.php";

 $id = $_GET['alid'];
 if($id==""){
  $_SESSION['ifon'] = "<script>alert('Ocorreu um erro!!')</script>";
  header("Location:Pesquisa.php");
  die;
}else{
 $result_usuario = "SELECT * FROM Alunos WHERE id LIKE '".$id."'";
 $resultado_usuario = mysqli_query($conn, $result_usuario);
 $row_usuario = mysqli_fetch_assoc($resultado_usuario);
 if ($row_usuario['id'] == ""){
header("Location:Pesquisa.php");
$_SESSION['ifon'] = "<script>alert('Nenhum registro localizado!!')</script>";
 }else{
 $_SESSION['id'] = $row_usuario['id'];
}
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
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
</head>
<body>

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
<!-- Responsavel pela pesquisa-->
<div id="dadosal">
  <label style="color:#FE642E;" >Nome civil: &nbsp</label>
  <label><?php echo $row_usuario['Nome_civil'];?></label><br>
  <label style="color:#FE642E;" >Nome social: &nbsp</label>
  <label><?php echo $row_usuario['Nome_social']; ?></label><br>
  <label style="color:#FE642E;" >Matrícula: &nbsp</label>
  <label><?php echo $row_usuario['Num_mat']; ?>&nbsp&nbsp&nbsp&nbsp&nbsp</label>
  <label style="color:#FE642E;">Curso: &nbsp</label>
  <label><?php echo $row_usuario['Cod_cur']; ?> -- &nbsp </label>
  <label><?php echo $row_usuario['Nome_cur']; ?></label><br>
</div>

<div id="formulario_envia_doc">

<form method="Post" action="envia_banco.php" enctype="multipart/form-data">
  <label>Selecione o arquivo:</label><br><br>
  <input id="arq" type="file" name="pdf" required><br><br>

  <label>Tipo de documento:</label><br><br>
  <select name="sele">
    <option>Ficha Cadastral</option>
    <option>Processo</option>
    <option>Requerimento</option>
    <option>TCE</option>
    <option>Histórico Escolar</option>
    <option>Outro tipo de Ficha</option>
    <option>Ofício</option>
  </select><br><br>

  <label>Classificação do documento:&nbsp;</label><br><br>
  <input  type="text" name="assunto" id="assunto" placeholder="Pesquisar Classificação do documento" required><br><br>


  <label>Descrição: &nbsp;&nbsp;&nbsp;&nbsp;</label><br><br>
  <input type="text" name="nome" placeholder="Descreva a modificação"><br><br>


<label>Ano do documento:&nbsp;</label><br><br>
<input id="ano" name="ano" value="<?php $data=date('Y-m-d');$par = explode('-',$data); echo $par[0]; ?>" type="number" min="1900" max="<?php $data=date('Y-m-d');$par = explode('-',$data); echo $par[0]; ?>" required>

<br><br><input name="sand" type="submit" value="Cadastrar">

</form>
<form action="pg_res_pes_mat.php">
<input name="sand" type="submit" value="Voltar">
</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(function () {
        $("#assunto").autocomplete({
            source: 'proc_pesq_msg.php'
        });
    });
</script>
</body>
</html>
