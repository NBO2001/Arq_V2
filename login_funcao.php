<?php
session_start();
require_once 'Conec_PDO.php';
$btn = filter_input(INPUT_POST,'btnlo',FILTER_SANITIZE_STRING);
if(isset($btn)){
  $usuario_name = strtoupper(filter_input(INPUT_POST,'nuso',FILTER_SANITIZE_STRING));
  $usuario_name = preg_replace('/[^[:alpha:][:alnum:]_]/',' ',$usuario_name);

  $senha_uso2 = filter_input(INPUT_POST,'senuso',FILTER_SANITIZE_STRING);
  $senha_uso2 = preg_replace('/[^[:alpha:][:alnum:]_]/',' ',$senha_uso2);

  $senha_uso = md5(filter_input(INPUT_POST,'senuso',FILTER_SANITIZE_STRING));
  $resulta = $pdo->prepare("SELECT * FROM log WHERE ursu LIKE '$usuario_name' AND senha LIKE '$senha_uso'");
  $resulta->execute();
  $valorfin = $resulta->fetchALL(PDO::FETCH_ASSOC);
  $acesso_nivel = $valorfin[0]['acesso'];

  $id = $valorfin[0]['id'];
  $loginban = strtoupper($valorfin[0]['ursu']);
  $senhaban = $valorfin[0]['senha'];
  $setoruso= $valorfin[0]['setor'];

  if($usuario_name == $loginban && $senha_uso == $senhaban){
      if($acesso_nivel == 0){
      $_SESSION['ifon']="<script>alert('Conta desativada, entre em contato com o arquivo')</script>";
      header("Location:index.php");
      die;
      }
        $_SESSION['id'] = $id;
        $_SESSION['usuarioname'] = $loginban;
        $_SESSION['acesso'] = $acesso_nivel;
        $_SESSION['setor']= $setoruso;
      header("Location:tela_inicial.php");
  }else{
    $_SESSION['usuarioname'] = $usuario_name;
    $_SESSION['senha_verir'] = $senha_uso2;
    header("Location:novos_cad.php");
  }
}
 ?>
