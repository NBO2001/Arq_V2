<?php
require_once 'Conec_PDO.php';
require_once 'envia_email/en_email.php';
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}
$nome = preg_replace('/[^[:alpha:][:alnum:]_]/',' ',$_POST['frm-nome-usu']);
$setor =$_POST['frm-setor-usu'];
$cpf = preg_replace('/[^0-9]/','',$_POST['frm-cpf-usu']);
$email =filter_var($_POST['frm-email-usu'],FILTER_VALIDATE_EMAIL);
$nivel_acesso =substr(preg_replace('/[^1-4]/','',$_POST['frm-acesso-usu']),0,1);
if($nome <> "" && $setor <> "" && $email <> "" && $nivel_acesso <> ""){
    $vr_dupli = $pdo->prepare("SELECT COUNT(*) AS valcon FROM log WHERE email LIKE '$email'");
    $vr_dupli->execute();
    $vr_dupli_r = $vr_dupli->fetchALL(PDO::FETCH_ASSOC);
    if ($vr_dupli_r[0]['valcon'] <> 0){
        echo "<div class='alert alert-danger' role='alert'>ERRO, email já existente na base de dados!!!</div>";
        die;
    } 
    if($_POST['frm-senha-usu'] == 2){
        $nome_login = explode(" ",$nome);$nome_login  = $nome_login[0];
        if($cpf == ""){
            $sub_cpf = preg_replace('/[^0-9]/','0',substr(md5(time()),0,3));
            $nome_login = $nome_login.substr($sub_cpf,0,1).substr($sub_cpf,-2,2);
        }else{
            $nome_login = $nome_login.substr($cpf,0,1).substr($cpf,-2,2);
        }
        
        $senha_nova = substr(md5(time()),0,5);
        $senha_nank = md5($senha_nova);
    }else{
        if($cpf <> ""){
        $nome_login =$cpf;
        $senha_nova =$cpf;
        $senha_nank = md5($cpf);
        }else{
            $sub_cpf = preg_replace('/[^0-9]/','0',substr(md5(time()),0,3));
            $nome_login = explode(" ",$nome);$nome_login  = $nome_login[0];
            $nome_login = $nome_login.substr($sub_cpf,0,1).substr($sub_cpf,-2,2);
        
            $senha_nova = substr(md5(time()),0,5);
            $senha_nank = md5($senha_nova);
        }
        
    }


    
    $nr_dupli = $pdo->prepare("SELECT COUNT(*) AS valname FROM log WHERE ursu LIKE '$nome_login'");
    $nr_dupli->execute();
    $nr_dupli_r = $nr_dupli->fetchALL(PDO::FETCH_ASSOC);
    if ($nr_dupli_r[0]['valname'] <> 0){
        echo "<div class='alert alert-danger' role='alert'>ERRO, tente novamente!!!</div>";
        die;
    }
    $inse = $pdo->prepare("INSERT INTO log SET ursu = '$nome_login', senha = '$senha_nank', acesso = $nivel_acesso, setor='$setor', email='$email',nome='$nome',cpf='$cpf' ");
    $inse->execute();
    $body_email = "<table style='border: 1px solid black;font-family:Arial;text-align: center;'>
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
      <td style='font-size:17px;'>Login: </td>
      <td style='font-size:17px;'>$nome_login</td> 
 </tr>
 <tr>
     <td style='font-size:17px;'>Senha: </td>
     <td style='font-size:17px;'>".$senha_nova."</td>
 </tr>
</tbody>
<tfoot>
   <th colspan='2'>Obrigado por seu cadastro, aqui suas credenciais.<br/>Sugestões e ajuda entrar em contato com arquivo_proeg@ufam.edu.br</th>
 </tfoot>
</table>";
enviar_email($email,$body_email);

    echo "<div class='alert alert-success' role='alert'>Usuário adicionado com sucesso!!!</div>";


}else{
    echo "<div class='alert alert-danger' role='alert'>ERRO, algum campo vázio!!!</div>";
}


?>