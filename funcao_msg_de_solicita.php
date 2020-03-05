<?php
session_start();
require_once 'Conec_PDO.php';
$fin_msg = "";
$id_solicitante = $_SESSION['id'];
$msg_soli = $pdo->prepare("SELECT id,soli,solicitacao,a_nome,msg_d FROM mensa WHERE soli LIKE '$id_solicitante' AND vr = 1");
$msg_soli->execute();
$msg_soli = $msg_soli->fetchAll(PDO::FETCH_ASSOC);
foreach($msg_soli as $msg_uni){
    $solicita = $msg_uni['solicitacao'];
    $solicitacao_p = $pdo->prepare("SELECT id,Cod_cur,Num_mat FROM Alunos WHERE id LIKE '$solicita'");
    $solicitacao_p->execute();
        //Encontra a o quem repos
        $nome = $msg_uni['a_nome'];
        $nome_exe = $pdo->prepare("SELECT ursu FROM log WHERE id LIKE '$nome'");
        $nome_exe->execute();
        $nome_exe = $nome_exe->fetchAll(PDO::FETCH_ASSOC);
        $nome = $nome_exe[0]['ursu'];
        //FIMM Encontra a o  quem repos
    $solicitacao_pasta = $solicitacao_p->fetchAll(PDO::FETCH_ASSOC);
    $solicitacao_pasta = $solicitacao_pasta[0]['Cod_cur']." - ".$solicitacao_pasta[0]['Num_mat'];
    $fin_msg .= "<a href='pg_res_pes_mat.php?alid=".$msg_uni['solicitacao']."' > <p class='text-left rounded-top bg-info text-dark'><small class='text-muted'>".$nome."</small><br/> $solicitacao_pasta : ".$msg_uni['msg_d']." <br></p></a>";   
    
    $up = $pdo->prepare("UPDATE mensa SET vr = 0 WHERE mensa.id =".$msg_uni['id']);
    $up->execute();

}
if($fin_msg <> ""){
?> 
      <div  class="toast" role="alert" data-autohide="false" aria-live="assertive" aria-atomic="true">
        
      <div class="toast-header">
            <strong class="mr-auto">Solicitações atendidas</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div class="toast-body">
            <span>
                <?php echo $fin_msg;?>
            </span>
            </div>
      </div>
  <script>
  $(document).ready(function(){
  $('.toast').toast('show');
  });
  </script>
  <?php
}
  ?>