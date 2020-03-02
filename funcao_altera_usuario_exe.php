<?php
require_once "Conec_PDO.php";
session_start();
if($_SESSION['acesso'] <> 4){
    header("Location:tela_inicial.php");
    die;
  }
$id_de_pesquisa = $_POST['frm-id-usu'];
if(isset($id_de_pesquisa)){
 
$veri_db  =$pdo->prepare("SELECT * FROM log WHERE id LIKE $id_de_pesquisa LIMIT 1");
$veri_db->execute();
$resu_veri_db = $veri_db->fetchAll(PDO::FETCH_ASSOC);

$nome = $resu_veri_db[0]['nome'];
$cpf = $resu_veri_db[0]['cpf'];
$acesso = $resu_veri_db[0]['acesso'];
$setor = $resu_veri_db[0]['setor'];

$email = $resu_veri_db[0]['email'];
$ursu = $resu_veri_db[0]['ursu'];

$msg = "";

if($nome <> $_POST['frm-nome-usu']){
    $nv_name = $_POST['frm-nome-usu'];
    $atualizar  = $pdo->prepare("UPDATE log SET nome = '$nv_name' WHERE log.id =".$id_de_pesquisa);
    $atualizar->execute();
}
if($cpf <> $_POST['frm-cpf-usu']){
    $nv_cpf = $_POST['frm-cpf-usu'];
    $atualizar  = $pdo->prepare("UPDATE log SET cpf = '$nv_cpf' WHERE log.id =".$id_de_pesquisa);
    $atualizar->execute();
}
if($setor <> $_POST['frm-setor-usu']){
    $nv_setor = $_POST['frm-setor-usu'];
    $atualizar  = $pdo->prepare("UPDATE log SET setor = '$nv_setor' WHERE log.id =".$id_de_pesquisa);
    $atualizar->execute();
}
if($acesso <> $_POST['frm-acesso-usu']){
    $nv_acesso = $_POST['frm-acesso-usu'];
    $atualizar  = $pdo->prepare("UPDATE log SET acesso = '$nv_acesso' WHERE log.id =".$id_de_pesquisa);
    $atualizar->execute();
}

//Nessesário verificar
if($email <> $_POST['frm-email-usu']){

    $nv_email = $_POST['frm-email-usu'];
    $vr_dupli = $pdo->prepare("SELECT COUNT(*) AS valcon FROM log WHERE email LIKE '$nv_email'");
    $vr_dupli->execute();
    $vr_dupli_r = $vr_dupli->fetchALL(PDO::FETCH_ASSOC);
    if ($vr_dupli_r[0]['valcon'] == 0){
       $atualizar  = $pdo->prepare("UPDATE log SET email = '$nv_email' WHERE log.id =".$id_de_pesquisa);
        $atualizar->execute(); 
    }else{
        $msg .= "Email já cadastrado! ";
    }   
}

if($ursu <> $_POST['frm-ursu-usu']){

    $nv_ursu = $_POST['frm-ursu-usu'];
    $vr_dupli = $pdo->prepare("SELECT COUNT(*) AS valcon FROM log WHERE ursu LIKE '$nv_ursu'");
    $vr_dupli->execute();
    $vr_dupli_r = $vr_dupli->fetchALL(PDO::FETCH_ASSOC);
    if ($vr_dupli_r[0]['valcon'] == 0){
       $atualizar  = $pdo->prepare("UPDATE log SET ursu = '$nv_ursu' WHERE log.id =".$id_de_pesquisa);
        $atualizar->execute(); 
    }else{
        $msg .= " Login já cadastrado! ";
    }   
}
if($msg <> ""){
    $_SESSION['info'] = "<div class='alert alert-danger' role='alert'>ERRO, $msg!!!</div>";
    header("Location:lista_de_usuarios.php");
}else{
    $_SESSION['info'] = "<div class='alert alert-success' role='alert'>Dados alterados com sucesso!!!</div>";
    header("Location:lista_de_usuarios.php");
}
}
?>