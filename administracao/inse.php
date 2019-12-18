<?php
require_once '../Conec_PDO.php';
session_start();
set_time_limit(0);
if($_SESSION['acesso']<>4){
header('Location:../index.php');
die;
}
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
<meta charset='UTF-8'>
<link type='image/x-icon' rel='shortcut icon' href='../ufamicon.ico'>
<title>Add</title>
</head>
<bory>
<form method="POST">
<textarea name='sql_fun' rows="5" cols="33"></textarea>
<input type='submit'>
</form>
</bory>
</html>
<?php 
if(isset($_POST['sql_fun'])){
    $pesquisa = $pdo->prepare($_POST['sql_fun']);
    if($pesquisa->execute()){
    echo "OK";
    }else{
        echo "não";
    }
}
?>