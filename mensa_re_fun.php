<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
  die;
}
require_once 'Conec_PDO.php';
include_once 'envia_email/en_email.php';
$nome = $_SESSION['usuarioname'];
$id_soli =  $_POST['passau_id'];
$msg = $_POST['msg'];

$urg_ativa = $pdo->prepare("SELECT * FROM mensa WHERE id LIKE '$id_soli'");
$urg_ativa->execute();
$urg_ativa = $urg_ativa->fetchAll(PDO::FETCH_ASSOC);

if($urg_ativa[0]['urg'] == 1){
  //Encontra a o aluno
  $solicita = $urg_ativa[0]['solicitacao'];
  $solicitacao_p = $pdo->prepare("SELECT * FROM Alunos WHERE id LIKE '$solicita'");
  $solicitacao_p->execute();
  $solicitacao_pasta = $solicitacao_p->fetchAll(PDO::FETCH_ASSOC);
  $solicitacao_pasta = $solicitacao_pasta[0]['Cod_cur']." - ".$solicitacao_pasta[0]['Num_mat'];
  //Fimm Encontra a o aluno
  
  //Encontra a o email usuario
  $solicitante = $urg_ativa[0]['soli'];
  $urg_sativa = $pdo->prepare("SELECT * FROM log WHERE id LIKE '$solicitante'");
  $urg_sativa->execute();
  $urg_sativa = $urg_sativa->fetchAll(PDO::FETCH_ASSOC);
  $email = $urg_sativa[0]['email'];
  //FIMM Encontra a o email usuario

  //adiciona na base de dados
  $resp = $pdo->prepare("UPDATE mensa SET sts = '0', a_nome = '$nome', msg_d = '$msg',vr='1' WHERE mensa.id =".$id_soli);
  if($resp->execute()){
    $_SESSION['ifon']="<script>alert('Enviada com sucesso')</script>";
    //Corpo do email
      $body_email = "
      <table style='border: 1px solid black;font-family:Arial;text-align: center;'>
      <thead>
      <tr>
        <th colspan='2'>
            <img width='50px' height='50px' src='cid:logo'/><br/>
          <label>
          Universidade Federal do Amazonas<br>
          Arquivo Acadêmico da PROEG<br>
          </label>
        </th>
      </tr>   
      </thead>
      <tbody>
        <tr>  
          <td colspan='2'><a style='background:#4285f4;border-radius:6px;color:#ffffff;display:block;font-size:12px;font-weight:normal;letter-spacing:1px;padding:10px 24px;text-decoration:none' href='http://arquivoproeg.ddns.net'>Pressione aqui para acessar o sistema.</a></td>
        </tr>
        <tr>
          <td colspan='2' style='font-size:17px;'>Sua solicitação: $solicitacao_pasta, foi respondida.</td>
        </tr>
          <tr>
            <td colspan='2' style='font-size:17px;'>$nome: $msg</td>
          </tr>
      </tbody>
      <tfoot>
          <th colspan='2'>Sugestões e ajuda entrar em contato com arquivo_proeg@ufam.edu.br</th>
      </tfoot>
      </table>";
      //enviar
      enviar_email($email,$body_email);
    header("Location:mensa_re.php");
  }else{
    $_SESSION['ifon']="<script>alert('Erro')</script>";
    header("Location:mensa_re.php");
  }

}else{
  //adiciona na base de dados
  $resp = $pdo->prepare("UPDATE mensa SET sts = '0', a_nome = '$nome', msg_d = '$msg',vr='1' WHERE mensa.id =".$id_soli);
  if($resp->execute()){
    $_SESSION['ifon']="<script>alert('Enviada com sucesso')</script>";
    header("Location:mensa_re.php");
  }else{
    $_SESSION['ifon']="<script>alert('Erro')</script>";
    header("Location:mensa_re.php");
  }
}

?>
