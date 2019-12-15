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
$usuario = $_SESSION['usuarioname'];
$setor = $_SESSION['setor'];
$data =  date('Y-m-d');
$result_usuarioa = "SELECT * FROM Ko WHERE id LIKE '".$nome."'";
$resultado_usuarioa = mysqli_query($conn, $result_usuarioa);
$row_usuarioa = mysqli_fetch_assoc($resultado_usuarioa);
$local = $row_usuarioa['can'];
if (isset($local)){
	$pdf_name = $row_usuarioa['nome_pdf'];
	$conf = fopen('conf.txt','r');
	$conf = fgets($conf, 1024);
	$local =$conf.$local;
	$ln = $row_usuarioa['nome'];
	if (file_exists($local)) {
		$inser = "INSERT INTO acessos (id, id_doc, uso_ac, uso_set, dt_acesso) 
		VALUES (NULL, '$nome', '$usuario', '$setor', '$data')";
		mysqli_query($conn, $inser);
		$file = $local;
		$filename = $pdf_name;
	
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' .$filename. '"');
		header('Content-Transfer-Encoding; binary');
		header('Accept-Ranges; bytes');
		readfile($file);
	}elseif (file_exists($conf."/In/pdf/".$row_usuarioa['can'])){
		$inser = "INSERT INTO acessos (id, id_doc, uso_ac, uso_set, dt_acesso) 
		VALUES (NULL, '$nome', '$usuario', '$setor', '$data')";
		mysqli_query($conn, $inser);
		$file = $conf."/In/pdf/".$row_usuarioa['can'];
		$filename = $pdf_name;	
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' .$filename. '"');
		header('Content-Transfer-Encoding; binary');
		header('Accept-Ranges; bytes');
		readfile($file);
	}
	else{
		echo "<script>alert('Ocorreu um erro [document does not exist], reporte ao administrador')</script><script>javascript:window.close()</script>";
	}	
}else{
	echo "<script>alert('Ocorreu um erro [does not exist], reporte ao administrador')</script><script>javascript:window.close()</script>";
}
}

?>
