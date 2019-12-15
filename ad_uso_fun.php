<?php
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:index.php");
  die;
}
require_once 'Conec_PDO.php';
require_once 'envia_email/en_email.php';

$usernome = filter_input(INPUT_POST,'usernome',FILTER_SANITIZE_STRING);
if(isset($usernome)){ 
  if($novo_email = filter_var($_POST['email_n_uso'],FILTER_VALIDATE_EMAIL)){
    $usernome = preg_replace('/[^[:alpha:][:alnum:]_]/',' ',$usernome);
    $vr_dupli = $pdo->prepare("SELECT COUNT(*) AS valcon FROM log WHERE email LIKE '$novo_email'");
    $vr_dupli->execute();
    $vr_dupli_r = $vr_dupli->fetchALL(PDO::FETCH_ASSOC);
    if ($vr_dupli_r[0]['valcon'] == 0){
      $senha_nova = substr(md5(time()),0,5);
      $senha_nank = md5($senha_nova);
      $setor = filter_input(INPUT_POST,'cli',FILTER_SANITIZE_STRING);
      $acesso = filter_input(INPUT_POST,'acesso',FILTER_SANITIZE_STRING);
      $inse = $pdo->prepare("INSERT INTO log SET ursu = '$usernome', senha = '$senha_nank', acesso = $acesso, setor='$setor', email='$novo_email' ");
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
          <td style='font-size:17px;'>$usernome</td> 
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
        enviar_email($novo_email,$body_email);
      header("Location:ad_uso.php");
      $_SESSION['ifon']="<script>alert('Usuario adicionado, a senha foi enviada para o email cadastrado!')</script>";
    }else{
      header("Location:ad_uso.php");
      $_SESSION['ifon']="<script>alert('email já cadastrado!')</script>";
    }
  }

}
/*
if($usernome <> ""){


  $email_n_uso = filter_input(INPUT_POST,'',FILTER_SANITIZE_STRING);
  
  $sql = "INSERT INTO log (ursu,senha,acesso,setor) VALUES ('$usernome','$senha','$acesso','$setor')";
  $rs = mysqli_query($conn,$sql);
  header("Location:ad_uso.php");
  $_SESSION['ifon']="<script>alert('Adcionado com sucesso')</script>";
}else{
  header("Location:ad_uso.php");
  $_SESSION['ifon']="<script>alert('falha ao tentar')</script>";

}*/

 ?>
