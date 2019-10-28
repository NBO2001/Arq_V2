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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="pdf.js"></script>
<script src="pdf.worker.js"></script>

<?php
if($_COOKIE["tema"] <> "a"){
  echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
}

?>
<style type="text/css">


</style>
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
<button id="upload-button">Selecione o arquivo pdf</button>
<form method="Post" action="envia_banco.php" enctype="multipart/form-data">
  <input id="file-to-upload" type="file" accept="application/pdf" name="pdf" required>
  <label>Tipo de documento:</label><br><br>
  <select name="sele">
    <option>Ficha Cadastral</option>
    <option>Processo</option>
    <option>Requerimento</option>
    <option>TERMO DE COMPROMISSO DE ESTÁGIO (TCE)</option>
    <option>Histórico Escolar</option>
    <option>FICHA</option>
    <option>Ofício</option>
    <option>Formulário de correção de notas e faltas</option>
    <option>MEMORANDO</option>
  </select><br><br>

  <label>Classificação do documento:&nbsp;</label><br><br>
  <input  type="text" name="assunto" id="assunto" placeholder="Pesquisar Classificação do documento" required><br><br>


  <label>Descrição: &nbsp;&nbsp;&nbsp;&nbsp;</label><br><br>
  <input type="text" name="nome" placeholder="Descreva a modificação"><br><br>


<label>Ano do documento:&nbsp;</label><br><br>
<input id="ano" name="ano" value="<?php $data=date('Y'); echo $data ?>" type="number" min="1900" max="<?php echo $data; ?>" required>

<br><br><input name="sand" type="submit" value="Cadastrar">

</form>


<div id="pdf-main-container">
  <div id="pdf-loader">Carregando documento ...</div>
  <div id="pdf-contents">
    <div id="pdf-meta">
      <div id="pdf-buttons">
        <button id="pdf-prev">Voltar</button><br><br>
        <button id="pdf-next">Avançar</button>
      </div>
  </div>
    <canvas id="pdf-canvas" width="500"></canvas>
    <div id="page-loader">Carregando pagina ...</div>
  </div>
</div>

<button onclick="window.location.href='pg_res_pes_mat.php?alid=<?php echo $id;?>'">Voltar</button><br><br>
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
<script>

var __PDF_DOC,
	__CURRENT_PAGE,
	__TOTAL_PAGES,
	__PAGE_RENDERING_IN_PROGRESS = 0,
	__CANVAS = $('#pdf-canvas').get(0),
	__CANVAS_CTX = __CANVAS.getContext('2d');

function showPDF(pdf_url) {
	$("#pdf-loader").show();

	PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
		__PDF_DOC = pdf_doc;
		__TOTAL_PAGES = __PDF_DOC.numPages;

		// Hide the pdf loader and show pdf container in HTML
		$("#pdf-loader").hide();
		$("#pdf-contents").show();
		$("#pdf-total-pages").text(__TOTAL_PAGES);

		// Show the first page
		showPage(1);
	}).catch(function(error) {
		// If error re-show the upload button
		$("#pdf-loader").hide();
		$("#upload-button").show();

		alert(error.message);
	});;
}

function showPage(page_no) {
	__PAGE_RENDERING_IN_PROGRESS = 1;
	__CURRENT_PAGE = page_no;

	// Disable Prev & Next buttons while page is being loaded
	$("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

	// While page is being rendered hide the canvas and show a loading message
	$("#pdf-canvas").hide();
	$("#page-loader").show();

	// Update current page in HTML
	$("#pdf-current-page").text(page_no);

	// Fetch the page
	__PDF_DOC.getPage(page_no).then(function(page) {
		// As the canvas is of a fixed width we need to set the scale of the viewport accordingly
		var scale_required = __CANVAS.width / page.getViewport(1).width;

		// Get viewport of the page at required scale
		var viewport = page.getViewport(scale_required);

		// Set canvas height
		__CANVAS.height = viewport.height;

		var renderContext = {
			canvasContext: __CANVAS_CTX,
			viewport: viewport
		};

		// Render the page contents in the canvas
		page.render(renderContext).then(function() {
			__PAGE_RENDERING_IN_PROGRESS = 0;

			// Re-enable Prev & Next buttons
			$("#pdf-next, #pdf-prev").removeAttr('disabled');

			// Show the canvas and hide the page loader
			$("#pdf-canvas").show();
			$("#page-loader").hide();
		});
	});
}

// Upon click this should should trigger click on the #file-to-upload file input element
// This is better than showing the not-good-looking file input element
$("#upload-button").on('click', function() {
	$("#file-to-upload").trigger('click');
});

// When user chooses a PDF file
$("#file-to-upload").on('change', function() {
	// Validate whether PDF
    if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
        alert('Error : Not a PDF');
        return;
    }
	// Send the object url of the pdf
	showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));
});

// Previous page of the PDF
$("#pdf-prev").on('click', function() {
	if(__CURRENT_PAGE != 1)
		showPage(--__CURRENT_PAGE);
});

// Next page of the PDF
$("#pdf-next").on('click', function() {
	if(__CURRENT_PAGE != __TOTAL_PAGES)
		showPage(++__CURRENT_PAGE);
});

</script>
</body>
</html>
