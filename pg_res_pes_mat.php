<?php
require_once 'Conec_PDO.php';
session_start();
if($_SESSION['acesso']==""){
 header("Location:index.php");
}
if(isset($_SESSION['ifon'])){
  echo $_SESSION['ifon'];
  unset ($_SESSION['ifon']);
}
require_once 'Classes/Alunos.php';
require_once 'Classes/Tabela.php';

if(isset($_GET['alid'])){
  $al = new Aluno();
  $al->pesquisa_banco2($_GET['alid'],$bd,$us,$sn);

}else{
  if(isset($_GET['matri'])){
    $ma = $_GET['matri'];
    $ma = preg_replace("/\s+/","",$ma);
  }else{
    $ma = filter_input(INPUT_POST,'nume');
    $ma = preg_replace("/\s+/","",$ma);
  }

  $al = new Aluno();
  $al -> setMatricula($ma);
  $al->pesquisa_banco($ma,$bd,$us,$sn);
}
?>
<!DOCTYPE html>
<html lang=pt-br>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.mask.min.js"/></script>
<link type='image/x-icon' rel='shortcut icon' href='ufamicon.ico'>
<link rel="stylesheet" href="css/hemes_smoothness_jquery-ui.css">
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
<title>Inserir</title>
</head>
<body>

<!-- Modal solicitação de pasta --->
<div class="modal fade" id="soli_dig" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Solicitação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <!-- Inicio do formulário -->
      <form id='from_soli_dig' method='POST' action='solicitacao.php<?php echo "?alid=".$al->getId();?>'>
          <div class="form-group">
              <label for="obs">Alguma observação?</label>
              <textarea name='obs' style="resize: none" class="form-control" id="obs" rows="3"></textarea>
         </div>
         <div class="form-check form-check-inline">
            <input 
            class="form-check-input" type="checkbox" name="urg" id="urg" value="1"
                data-container="body" 
                data-toggle="popover" 
                data-placement="left"
                data-content="Você receberá um email assim que a digitalização for disponibilizada." >
            <label class="form-check-label" for="urg" >Ativar urgência</label>
          </div>
          <button type="submit" class="btn btn-outline-dark btn-block">Enviar pedido</button>
      </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info btn-block" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fim do modal solicitação de pasta -->



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


    		<?php
        if($_SESSION['acesso']==1){
          echo "<li data-toggle='modal' data-target='#soli_dig'><a href='#'>Solicitar pasta</a></li>";
          echo "<li><a href='mensa_visu.php'>Mensagem</a></li>";

       }else if($_SESSION['acesso']==2){
          echo "<li><a href='etq_uni.php?alid=".$al->getId()."'>Gerar etiqueta</a></li>";
           echo "<li><a href='mensa_re.php'>Mensagem</a></li>";

       }else if($_SESSION['acesso']== 3 or 4){
         echo "<li><a href='etq_uni.php?alid=".$al->getId()."'>Gerar etiqueta</a></li>";
         echo "<li><a href='adicionar_documentos.php?alid=".$al->getId()."'>Inserir documentos</a></li>";
         echo "<li><a href='alter_registro.php?alid=".$al->getId()."'>Altera registro</a></li>";
         echo "<li><a href='mensa_re.php'>Mensagem</a></li>";
        }
       ?>
       <li><a href='sair.php'>Sair</a></li>
    		</ul>
    </nav>
  </div>
<!-- Responsavel pela pesquisa-->
<div id="dialog-confirm" title="O que deseja fazer?">
</div>

<?php   $al->exibir();
$tb = new Tabela();
$tb->setIm($al->getId());
$tb->pesquisa_doc($bd,$us,$sn);
?>

<div  id='tab' class='tabelapgmat'>
<?php
$tb->exibir_tabela();
if(isset($_SESSION['msg_erro'])){
  echo $_SESSION['msg_erro'];
  unset ($_SESSION['msg_erro']);
}
?>
</div>
<?php
//Se não tiver nada no contudo da tabela
if(empty($tb->getTb())){
  echo "<script>document.getElementById('tab').style.display = 'none';</script>";
  if($_SESSION['acesso']==1){
  echo "<button style='position: absolute;top:400px;' type='button' class='btn btn-outline-success btn-block btn-lg' data-toggle='modal' data-target='#soli_dig'>
  Solicitar digitalização
</button>";
  }else{

    echo "  <label style='position: absolute;top:350px;left:100px;'>Esse aluno não possui digitalização</label>";
  }
}
?>

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>
<script>
    $(function () {
        $("#assunto").autocomplete({
            source: 'proc_pesq_msg.php'
        });
    });
</script>
<script type="text/javascript">
    function sizeOfThings(){
        var windowWidth = window.innerWidth;
        if(windowWidth < 1000){
          document.getElementById('dadosal').style.display = "none";
          document.getElementById('dadosal2').style.display = "inline";
        }else{
          document.getElementById('dadosal').style.display = "inline";
          document.getElementById('dadosal2').style.display = "none";
        }
      };

    sizeOfThings();
    window.addEventListener('resize', function(){
      sizeOfThings();
    });
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
}
if("<?php echo $_SESSION['acesso'];?>" == 4){
  $( '#dialog-confirm' ).dialog({
    resizable: false,
    height: 'auto',
    width: 400,
    modal: true,
    buttons: {
        'Visualizar': function() {
          $(window.open('pdf_visu.php?id='+d,'_blank') ).dialog( "close" );
        },<?php $id = $al->getId(); echo
        "'Editar': function() {
            $(window.open('pg_res_pes_mat.php?alid=$id&iddoc='+d,'_top')).dialog( 'close' );
        },";?>
        Cancel: function() {
          $( this ).dialog( 'close' );
        }
      }
  });
}else{
  $( '#dialog-confirm ').dialog({
    resizable: false,
    height: 'auto',
    width: 400,
    modal: true,
    buttons: {
        'Visualizar': function() {
          $( window.open('pdf_visu.php?id='+d,'_blank') ).dialog( 'close ');
        },
        Cancel: function() {
          $( this ).dialog( 'close' );
        }
      }
  });
}
});
</script>
</body>
</html>
<?php
if(isset($_GET['iddoc'])){
$t = new Tabela();
$t->pesquisa_doc2($_GET['iddoc'],$_GET['alid'],$bd,$us,$sn);
$t->exibir_dados();
}
?>
</body>
</html>
