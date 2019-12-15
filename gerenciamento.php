<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:tela_inicial.php");
}
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}
$pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
$pdo -> query("SET NAMES UTF8");

$stmt = $pdo->prepare("SELECT COUNT(DISTINCT Ko.imagem) AS total FROM Ko");
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

$td_al = $pdo->prepare("SELECT COUNT(DISTINCT Alunos.id) AS totalal FROM Alunos");
$td_al->execute();
$res_seg = $td_al->fetchAll(PDO::FETCH_ASSOC);

$doc_total = $pdo ->prepare("SELECT COUNT(*) FROM Ko");
$doc_total->execute();
$doc_total = $doc_total->fetchALL(PDO::FETCH_ASSOC);
$doc_total = $doc_total[0]['COUNT(*)'];

$total1 = $resultado[0]['total'];
$total2 =  $res_seg[0]['totalal'];
$difere = $total2 - $total1;
$porcentagem = ($total1 * 100) / $total2;
$porcentagem = substr($porcentagem,0,4)."%";
$tes = exec("du -hs /home/arquivo/'Área de Trabalho'/In/pdf/ ");
$tes = explode('/',$tes);
$tes = $tes[0];
$espaco_livre_disk = exec("df -h . | awk '{print $5}'");
$espaco_livre_disk = explode("%",$espaco_livre_disk);
$espaco_livre_disk = $espaco_livre_disk[0];

$porcentagembar = explode(".",$porcentagem);
$porcentagembar = $porcentagembar[0];
?>

<!DOCTYPE>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="css/es.css">
<?php
if($_COOKIE["tema"] <> "a"){
  echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
}?>
<title>Adcionar usuarios</title>
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
  <div id="status">
    <label>----------------- Dados gerais  -----------------</label><br>
    <label>Total de registros da base: <?php echo $total2?></label><br>
    <label>Total de registros com digitalição: <?php echo $total1?></label><br>
    <label>Totalidade de documentos digitalizados:  <?php echo $doc_total;?></label><br>
    <label>Espaço ocupado em disco: <?php echo $tes;?></label><br><br>
    <label>Situaçao do processo de digitalição do acervo acadêmico</label><br> <br>
    <progress max='100' value='<?php echo $porcentagembar;?>'></progress><?php echo $porcentagem;?><br><br>
    <label>Espaco utilizado do HD</label><br>
    <progress max='100' value='<?php echo $espaco_livre_disk;?>'></progress><?php echo $espaco_livre_disk."%";?>
    </div>
</body>
</html>
