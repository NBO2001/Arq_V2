<?php
session_start();
require_once 'Conec_PDO.php';
require_once 'envia_email/en_email.php';

if(isset($_POST['btnlo'])){
    if($email_uso =filter_var($_POST['end_email'], FILTER_VALIDATE_EMAIL)){
    $usuario = strtoupper($_POST['usuario_name']);
     $senha_nova = substr(md5(time()),0,5);
     $senha_nank = md5($senha_nova);
     $valida_email = $pdo->prepare("SELECT ursu FROM log WHERE ursu LIKE '$usuario' AND email LIKE '$email_uso'");
     $valida_email->execute();
     $res = $valida_email->fetchALL(PDO::FETCH_ASSOC);
     if($usuario = $res[0]['ursu']){
         $update = $pdo->prepare("UPDATE log SET senha='$senha_nank' WHERE email LIKE '$email_uso'");
         $update->execute();
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
          <td style='font-size:17px;'>$usuario</td> 
     </tr>
     <tr>
         <td style='font-size:17px;'>Senha: </td>
         <td style='font-size:17px;'>".$senha_nova."</td>
     </tr>
    </tbody>
    <tfoot>
       <th colspan='2'>Recebemos sua solicitação, aqui sua nova senha.<br/>Sugestões e ajuda entrar em contato com arquivo_proeg@ufam.edu.br</th>
     </tfoot>
 </table>";
        enviar_email($email_uso,$body_email);
        $_SESSION['ifon']="<script>alert('Nova senha enviada para seu email!')</script>";
        header("Location:index.php");
        die;
     }else{
        $_SESSION['ifon']="<script>alert('Nenhum registro encontrado!')</script>";
        header("Location:index.php");
        die;
     }
        
    }else{
        $_SESSION['ifon']="<script>alert('Email inválido!')</script>";
        header("Location:index.php");
        die;
    }
    
    
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf=8">
<title>Tela inicial</title>
<link rel="stylesheet" type="text/css" href="css/es.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
</head>
<body class="pes_nome_body">

  <form method="Post"  enctype="multipart/form-data" class="formulario_login">
  
  <h1><img width="60px" style='border-radius:15px;' height="60px" src="ufam.png"/><br>Recuperação de senha</h1>
  <div class="txtb">
      <input name="usuario_name"  type="text" required>
      <span data-placeholder="Usuario"></span>
    </div>
  <div class="txtb">
       <input name="end_email" type="email" required></input>
      <span data-placeholder="E-mail"></span>
    </div>

    <input class="logbtn" name="btnlo" type="submit" value="Enviar"></input>
  </form>
  <script type="text/javascript">
    $(".txtb input").on("focus",function(){
      $(this).addClass("focus");
    });

    $(".txtb input").on("blur",function(){
      if($(this).val() == "")
      $(this).removeClass("focus");
    });
</script>
</body>
<footer>
 <label >&copy;2019 N.B.O <br>Suporte: arquivo_proeg@ufam.edu.br<label>
</footer> 
</html>
