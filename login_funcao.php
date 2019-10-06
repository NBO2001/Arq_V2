<?php
session_start();
include_once 'ConAL.php';
$btn = filter_input(INPUT_POST,'btnlo',FILTER_SANITIZE_STRING);
if(isset($btn)){
  $usuario = strtoupper(filter_input(INPUT_POST,'nuso',FILTER_SANITIZE_STRING));
  $usuario = preg_replace('/[^[:alpha:]_]/', '',$usuario);
  $senha = strtoupper(filter_input(INPUT_POST,'senuso',FILTER_SANITIZE_STRING));
  $senha = preg_replace('/[^[:alnum:]_]/','',$senha);
  if($usuario == "" OR $senha == ""){
    header("Location:index.php");
    $_SESSION['ifon'] = "<script>alert('Senha ou login vazios!!')</script>";
    die;
  }else{
    $query = "SELECT * FROM log WHERE ursu LIKE '$usuario' AND senha LIKE '$senha'";
    $val = mysqli_query($conn, $query);
    $linhas = mysqli_fetch_assoc($val);
    $id = $linhas['id'];
    $loginban = strtoupper($linhas['ursu']);
    $senhaban = strtoupper($linhas['senha']);
    if($usuario == $loginban && $senha == $senhaban){
      $acesso_nivel = $linhas['acesso'];
      $setoruso= $linhas['setor'];
      $_SESSION['usuarioname'] = $loginban;
      $_SESSION['acesso'] = $acesso_nivel;
      $_SESSION['setor']=$setoruso;
      header("Location:tela_inicial.php");
    }else{
      header("Location:index.php");
      $_SESSION['ifon'] = "<script>alert('Senha ou login invalida!!')</script>";
      die;
    }
    }
}else{
  header("Location:index.php");
}

 ?>
