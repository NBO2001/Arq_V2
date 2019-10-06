<?php
session_start();
if($_SESSION['acesso']==""){
  header("Location:index.php");
  die;
}
 ?>

<?php
include_once "ConAL.php";
$nome = $_GET['id'];
if($nome ==""){
	echo "Nenhum registro selecionado";
}else{
$result_usuarioa = "SELECT * FROM Ko WHERE id LIKE '".$nome."'";
$resultado_usuarioa = mysqli_query($conn, $result_usuarioa);
$row_usuarioa = mysqli_fetch_assoc($resultado_usuarioa);
$local = $row_usuarioa['can'];
$pdf_name = $row_usuarioa['nome_pdf'];
$local ="/home/arquivo/Área de Trabalho".$local;
$ln = $row_usuarioa['nome'];


$file = $local;
	$filename = $pdf_name;

	header('Content-type: application/pdf');
	header('Content-Disposition: inline; filename="' .$filename. '"');
	header('Content-Transfer-Encoding; binary');
	header('Accept-Ranges; bytes');
	readfile($file);
}
?>
