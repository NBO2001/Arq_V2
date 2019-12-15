<?php
session_start();
if(isset($_SESSION['ifon'])){
  echo $_SESSION['ifon'];
  unset ($_SESSION['ifon']);
}
require_once "Conec_PDO.php";
include_once 'envia_email/en_email.php';
if(isset($_SESSION['acesso'])){
  $usuario = $_SESSION['usuarioname'];
  $setor = $_SESSION['setor'];
  $emal_usu = $pdo->prepare("SELECT id,email FROM log WHERE ursu LIKE '$usuario' AND setor LIKE '$setor'");
  $emal_usu->execute();
  $emal_usu_res = $emal_usu->fetchALL(PDO::FETCH_ASSOC);
}else{
  header("Location:index.php");
  die;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf=8">
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
<title>Usuário</title>
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
       <li><a href="tela_inicial.php">Tela inicial</a></li>
     <li><a href="sair.php">Sair</a></li>
     </ul>
 </nav>
 </div>
  <div id='painel_usuarios'>
    <img  style="height: 80px; width:80px;" src="icones/usuarios.png"><br/>

    <form method= 'POST'>
    <label>Nome:</label>
    <input name='usuario_nome' maxlength='25' minlength='3' value='<?php echo $usuario; ?>' type='text' required/>
    <input type='submit' value='alterar' name='aterar_nome_btn'><br/><br/>
    <label>Setor:</label>
    <label><?php echo $setor; ?></label><br/>
    </form><br/>

    <form method= 'POST'>
    <label>Email:</label>
    <input name='email_novo' value='<?php echo $emal_usu_res[0]['email'];?>' type='email' placeholder='Seu email'/>
    <input type='submit' value='alterar' name='email_btn'>
    </form><br>

    <button onclick="campsenha();">Alterar senha</button>

    <form method= 'POST' id="snha">
    </form>
  </div>
</body>
</html>
<script>
function campsenha(){
    document.getElementById("snha").innerHTML ="<input name='senha_valor_novo' type='password' maxlength='8' minlength='3' placeholder='Digite senha' required>"
    +"<input name='senha_valor_novo2' type='password' maxlength='8' minlength='3' placeholder='Digite novamente' required>"
    +"<input type='submit' value='Atualizar' name='senha_btn'>"
}
</script>
<?php
if(isset($_POST['aterar_nome_btn'])){
  $usuario_name_novo = filter_input(INPUT_POST,'usuario_nome',FILTER_SANITIZE_STRING);
  $usuario_name_novo = preg_replace('/[^[:alpha:][:alnum:]_]/',' ',$usuario_name_novo);
  $name_uso_veri = $pdo->prepare("SELECT COUNT(*) AS us FROM log WHERE ursu LIKE '$usuario_name_novo' ");
  $name_uso_veri->execute();
  $name_uso_veri_res = $name_uso_veri->fetchALL(PDO::FETCH_ASSOC);
  if($name_uso_veri_res[0]['us'] == 0){
    $up_name = $pdo->prepare("UPDATE log SET log.ursu = '$usuario_name_novo' WHERE log.id =".$emal_usu_res[0]['id']);
    $up_name->execute();
    $_SESSION['usuarioname'] = $usuario_name_novo;
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
            <td style='font-size:17px;'>Login: </td>
            <td style='font-size:17px;'>$usuario_name_novo</td> 
           </tr>
        </tbody>
        <tfoot>
            <th colspan='2'>Houve uma atualização no seu login.<br/>Sugestões e ajuda entrar em contato com arquivo_proeg@ufam.edu.br</th>
        </tfoot>
        </table>";
        $ema_uso = $emal_usu_res[0]['email'];
         enviar_email($ema_uso,$body_email);
    $_SESSION['ifon']="<script>alert('Alterado com sucesso')</script>";
    header("Location:alterar_senha.php");
  }else{
    $_SESSION['ifon']="<script>alert('Nome de usuario já existente')</script>";
    header("Location:alterar_senha.php");
  die;
  }
}
if(isset($_POST['email_btn'])){
  if($novo_email = filter_var($_POST['email_novo'],FILTER_VALIDATE_EMAIL)){
    $email_uso_veri = $pdo->prepare("SELECT COUNT(*) AS us FROM log WHERE email LIKE '$novo_email' ");
    $email_uso_veri->execute();
    $email_uso_veri_res = $email_uso_veri->fetchALL(PDO::FETCH_ASSOC);
    if($email_uso_veri_res[0]['us'] == 0){
      $up_email = $pdo->prepare("UPDATE log SET log.email = '$novo_email' WHERE log.id =".$emal_usu_res[0]['id']);
      $up_email->execute();
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
        </tbody>
        <tfoot>
            <th colspan='2'>Endereço eletrônico atualizado com sucesso.<br/>Sugestões e ajuda entrar em contato com arquivo_proeg@ufam.edu.br</th>
        </tfoot>
        </table>";
         enviar_email($novo_email,$body_email);

      $_SESSION['ifon']="<script>alert('Email atualizado com sucesso!')</script>";
      header("Location:alterar_senha.php");
    }else{
      $_SESSION['ifon']="<script>alert('Email já existente')</script>";
      header("Location:alterar_senha.php");
    die;
    }
  }
}
if(isset($_POST['senha_btn'])){
  if( ($senha_n = $_POST['senha_valor_novo']) ==  $_POST['senha_valor_novo2']){
    $senha_nc = md5($senha_n);
    $up_senha = $pdo->prepare("UPDATE log SET log.senha = '$senha_nc' WHERE log.id =".$emal_usu_res[0]['id']);
    $up_senha->execute();
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
          <td style='font-size:17px;'>Senha: </td>
          <td style='font-size:17px;'>$senha_n</td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan='2'>Sua senha foi atualizada.<br/>Sugestões e ajuda entrar em contato com arquivo_proeg@ufam.edu.br</th>
    </tfoot>
    </table>";
    $end_email = $emal_usu_res[0]['email'];
     enviar_email($end_email,$body_email);
     $_SESSION['ifon']="<script>alert('Senha atualizada!')</script>";
     header("Location:alterar_senha.php");
  }else{
    $_SESSION['ifon']="<script>alert('Senhas não correspondem!')</script>";
    header("Location:alterar_senha.php");
    die;
  }
}
?>