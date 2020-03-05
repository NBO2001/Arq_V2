<?php
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
};
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Adm Usuários</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.min.js"></script>
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
<style>
  #tab_uss{
	width: 100%;
	height:400px;
	overflow-y : scroll;
	cursor: pointer;
  }
  </style>
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
     <li><a href="pg_pesquisa.php">Pesquisa por matrícula</a></li>
    <li><a href="pg_pesquisa_nome.php">Pesquisa por nome</a></li>
     <li><a href="sair.php">Sair</a></li>
     </ul>
 </nav>
 </div>

<div id='lista_de_usos_bory'>
<span id="msg"><?php
if(isset($_SESSION['info'])){
    echo $_SESSION['info'];
    unset ($_SESSION['info']);
}
?></span>
<button type="button" class="btn btn-outline-success btn-block" data-toggle="modal" data-target="#caduso">
  CADASTRAR
</button>
<div id='tab_uss'>
<span id='retorno_res'></span>
</div>
<!-- Modal de confirmação de ativa -->
<div class="modal fade" id="atv_usuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CONFIRMAÇÃO</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span id="area_ativa"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fimm-->

<!-- Modal de confirmação de desativa -->
<div class="modal fade" id="excl_usuario" tabindex="-1" role="dialog" aria-hidden="true">
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
<!-- Fimm-->


<!-- Modal cadastrar -->
<div class="modal fade" id="caduso" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- Inicio do formulário -->
        <form id='enviarnewdado'>
          <div class="form-group">

          <div class='form-row'>

            <div class='col-md-8'>
              <label for='frm-nome-usu'>Nome</label>
              <input name='frm-nome-usu' id='frm-nome-usu' type='text' class='form-control' placeholder="O nome do usuário">
            </div>
            <div class='col-md-3'>
              <label for='frm-setor-usu'>Setor</label>
              <select name='frm-setor-usu'  id="frm-setor-usu" class="form-control">
                <option selected>Arquivo acadêmico</option>
                <option>CAUSA</option>
                <option>CRC</option>
                <option>CRD</option>
                <option>CM</option>
                <option>COA</option>
                <option>DPA</option>
                <option>Protocolo</option>
              </select>
            </div>

          </div>

          <div class='form-row'>
            <div class='col-md-3'>
              <label for='frm-cpf-usu'>CPF</label>
              <input name='frm-cpf-usu' id='frm-cpf-usu' type='text' class='form-control' placeholder="O cpf do usuário">
            </div>
            <div class='col-md-6'>
              <label for='frm-email-usu'>Email</label>
              <input name='frm-email-usu' id='frm-email-usu' type='email' class='form-control' placeholder="O email do usuário">
            </div>
            <div class='col-md-2'>
              <label for='frm-acesso-usu'>N/acesso:</label>
              <input name='frm-acesso-usu' id='frm-acesso-usu' type='number' class='form-control' min='1' max='4' value='1'>
            </div>
          </div>
          </div>

          <div class="form-row">
            <div class='col-md-5'>
            <label for='frm-senha-usu'>Forma de acesso</label>
              <select name='frm-senha-usu'  id="frm-senha-usu" class="form-control">
                <option value='1' selected>Usar cpf com senha e login</option>
                <option value='2'>Gerar senha e login</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
             
             <button type="submit" class="btn btn-outline-dark btn-block">Enviar dados</button>
          
         </div>
        </form>	

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info btn-block" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal alterar dados -->
<div class="modal fade" id="alterar_usuario" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Altera</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!-- Inicio do formulário -->
      <form id='alterar_dados' method='POST' action='funcao_altera_usuario_exe.php'>
          <span id='recebe'></span>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info btn-block" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal detalhes usuário -->
<div class="modal fade" id="detalhes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DETALHES</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <span id='ifo_do_bank'></span>
			
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

</div>
<button style="position:absolute;left:10%;top:560px;width:900px;" class="btn btn-primary" onclick="window.location.href='admini.php'">Voltar</button><br><br>
</body>
<script>


    $(document).ready(function (){
       paginacao();
    });

    function paginacao(){
        $.post('funcao_lista_de_usuarios.php', function(retorna){
            $('#retorno_res').html(retorna);
        });
    }

    $(document).ready(function (){
        $(document).on('click', '.apg_conf', function(){
          var id_para_apagar = $(this).attr('id');
          var reg_ap = {
            id_para_apagar : id_para_apagar
            };

          $.post('funcao_apagar_usuario.php',reg_ap, function(retorna){
              $('#msg').html(retorna);
              $('#excl_usuario').modal('hide');
              paginacao();
          });
            
        });

        $(document).on('click','.view_data2', function (){
            var id_registro = $(this).attr('id');
            $('#detalhes').modal('hide');
            $('#area_apagar').html("<label>Deseja desativar a conta? </label></br><button type='button' class='btn btn-danger btn-block  apg_conf' id='"+ id_registro +" ' data-toggle='modal'>Desativar conta</button>");
            $('#excl_usuario').modal('show');

        });
        
        $(document).on('click', '.atv_conf', function(){
          var id_para_ativar = $(this).attr('id');
          var reg_ap = {
            id_para_ativar : id_para_ativar
            };

          $.post('funcao_ativar_usuario.php',reg_ap, function(retorna){
              $('#msg').html(retorna);
              $('#atv_usuario').modal('hide');
              paginacao();
          });
            
        });
        
        $(document).on('click','.atvconta', function (){
            var id_registro = $(this).attr('id');
            $('#detalhes').modal('hide');
            $('#area_ativa').html("<label>Deseja Ativar a conta? </label></br><button type='button' class='btn btn-warning btn-block  atv_conf' id='"+ id_registro +" ' data-toggle='modal'>Ativar conta</button>");
            $('#atv_usuario').modal('show');

        });


        $(document).on('click','.butaoalterar',function(){
          
          var id_alteracao = $(this).attr('id');
          var for_alteracao = {
            id_alteracao : id_alteracao
          };
            $.post('funcao_altera_usuario.php', for_alteracao, function(retorna){
              $('#detalhes').modal('hide');
              $('#recebe').html(retorna);
              $('#alterar_usuario').modal('show');
            });

        });


        $(document).on('click','.view_data', function (){
            var id_reg = $(this).attr('id');
            if(id_reg !== ''){
                var reg_at = {
                    id_reg : id_reg
                };
                $.post('funcao_detalhes_de_usuarios.php', reg_at, function(retorna){
                    $('#ifo_do_bank').html(retorna);
                    $('#detalhes').modal('show');
                });
            }
        });
         
        $('#enviarnewdado').on('submit', function(event){
          event.preventDefault();
          var for_dados = $('#enviarnewdado').serialize();
          $.post('funcao_cadastra_usuario.php', for_dados, function(retorna){
            $('#msg').html(retorna);
            $('#enviarnewdado')[0].reset();
            $('#caduso').modal('hide');
            paginacao();
          });
        });
});



</script>
</html>
