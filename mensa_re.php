<?php
session_start();
if($_SESSION['acesso'] == ""){
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
<html lang=pt-br>
<head>
    <meta charset="UTF-8">
    <title>Mensagens</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
   <link rel="stylesheet" type="text/css" href="css/es.css">
   <link type='image/x-icon' rel='shortcut icon' href='icones/ufamicon.ico'>

  <?php
    if($_COOKIE["tema"] <> "a"){
      echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
    }
    if(isset($_SESSION['ifon'])){
      echo $_SESSION['ifon'];
      unset ($_SESSION['ifon']);
    }
  ?>

  <style>
  #tab_solis{
	width: 100%;
	height:400px;
	overflow-y : scroll;
	cursor: pointer;
  }
  </style>
</head>

<body>
<!-- Cabeçalho  -->
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

<!-- Fim cabeçalho -->

<span id='msg'></span>

<!-- Modal responder solicitação de pasta --->
<div class="modal fade" id="res_soli_dig" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">------</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <!-- Inicio do formulário -->
      <form id='from_soli_dig' method='POST' action='mensa_re_fun.php'>
          <div class="form-group">
              <span id='passa_id'></span>
              <label for="mgs">MENSAGEM</label>
              <textarea name='msg' style="resize: none" class="form-control"  id="obs" rows="3">Digitalização já disponível no Sistema</textarea>
         </div>
          <button type="submit" class="btn btn-outline-dark btn-block">Responder pedido</button>
      </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info btn-block" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fim do modal responder solicitação de pasta -->


<!-- Modal de confirmação de exclusão -->
<div class="modal fade" id="excl_soli" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CONFIRMAÇÃO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="area_apagar"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- FImm  Modal de confirmação de exclusão-->

<div id='tab_solis'>
<span id='tabela_msg'></span>
</div>
<button style="position:absolute;left:10%;top:560px;width:900px;" class="btn btn-primary" onclick="window.location.href='tela_inicial.php'">Voltar</button><br><br>

</body>
<script>


$(document).ready(function (){
    list_msg();
});
function list_msg(){
  $.post('funcao_listar_msgs.php', function(retorna){
      $('#tabela_msg').html(retorna);
  });
    }

    $(document).on('click','.view_data2', function (){
            var id_registro = $(this).attr('id');
            $('#area_apagar').html("<label>Deseja apagar solicitação? </label></br><button type='button' class='btn btn-outline-danger btn-block btn-lg apg_conf' id='"+ id_registro +" ' data-toggle='modal'>Apagar</button>");
            $('#excl_soli').modal('show');

    });

    $(document).on('click','.resp', function (){
            var id_registro = $(this).attr('id');
            $('#passa_id').html("<input type='number' name='passau_id' style='display:none;' value='"+id_registro+"'>");
            $('#res_soli_dig').modal('show');

    });

    $(document).on('click','.view_data', function (){
      var id_pas = $(this).attr('id');
      window.location.href='pg_res_pes_mat.php?alid='+id_pas;

     });

    $(document).on('click', '.apg_conf', function(){
          var id_para_apagar = $(this).attr('id');
          var reg_ap = {
            id_para_apagar : id_para_apagar
            };

          $.post('funcao_apagar_solicitacao.php',reg_ap, function(retorna){
              $('#msg').html(retorna);
              $('#excl_soli').modal('hide');
              list_msg();
          });
            
        });

</script>
</html>
