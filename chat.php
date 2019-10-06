<?php
session_start();
$nome = $_SESSION['usuarioname'];
include_once 'ConAL.php';
$sql = "SELECT * FROM chat ORDER BY chat.id DESC LIMIT 15";
$rexea = mysqli_query($conn, $sql);
while($resubank = mysqli_fetch_array($rexea)){
  $res = $resubank['uso'].":".$resubank['msg'];
  $res = explode('#',$res);
  if(isset($res[1])){
    $kval ="*".$res[1];
  $res ="<a href='redir_mesn.php?texto=$kval'>". $resubank['uso'].":".$resubank['msg']."</a></n>";
  }else{
    $res = $resubank['uso'].":".$resubank['msg']."<br>";
  }
  if($nome == $resubank['uso'] ){
    $usuariom = $resubank['uso'];
    $res = str_replace("$usuariom:", "", $res);
    echo "<label class='meusuario'>$res</label>";
  }else{
      echo $res;
  }

}

?>
