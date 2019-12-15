<?php
session_start();
if($_SESSION['acesso']<>4){
header("Location:index.php");
die;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Importar dados</title>
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
	<head>
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

    <div id="input_xml_semdupli">
      <div id="iformacao_up">
      <span> -> MUITO CUIDADO AO INSERIR OS DADOS!!!.</span><br>
      <span> -> O formato do arquivo  tem que está em xml.</span><br>
      <span>-> É de suma importancia que todos os espaços em brando esteja preenchidos com NULL.</span><br>
      <span>-> Não será inserido dados em que o número de matricula já está registrado no banco de dados.</span><br>
      <span>-> Inserir no máximo 50.000 dados!.</span><br>
      <span>-> A planilha deve obrigatoriamente ter 11 colunas na seguinte ordem:</span><br>
      <span class='tab'>| ID_PESSOA | NOME_PESSOA | FORMA_INGRESSO | FORMA_EVASAO| COD_CURSO | NOME_UNIDADE | MATR_ALUNO | PERIODO_INGRESSO | PERIODO_EVASAO | Nome_Social | SISTEMA |.</span><br>
    </div>
    <div id="formulario_upload">
    <form method="POST" action="upload_por_xml_funcao.php"  enctype="multipart/form-data">
      <label for="checa">Selecione o arquivo</label>
      <input id="checa" type="file" accept="application/xml" name="up_xml" required >
			<input type="submit"  value="Enviar">
		</form>
    <button onclick="window.location.href='admini.php'">Voltar</button><br><br>
  </div>
  </div>
  <?php
  if(isset($_SESSION['ifon'])){
    echo $_SESSION['ifon'];
    unset ($_SESSION['ifon']);
  }
  ?>
	</body>
</html>
