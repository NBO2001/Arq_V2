<?php
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:index.php");
  die;
}
include_once "ConAL.php";
  $texto = $_GET["texto"];
  $texto = explode('-',$texto);
  $idmensa = $texto[1];
  if($idmensa <> ""){
    $visum = "UPDATE mensa SET vr = 0 WHERE mensa.id =".$idmensa;
    $revisu = mysqli_query($conn, $visum);
  }
 header("Location:pg_res_pes_mat.php?alid=".$texto[0]);

 ?>
