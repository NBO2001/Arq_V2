<?php
session_start();
if($_SESSION['acesso']<>4){
  header("Location:../index.php");
  die;
}
if(isset($_SESSION['ifon'])){
  echo $_SESSION['ifon'];
  unset ($_SESSION['ifon']);
}
 ?>
 <!DOCTYPE html>
 <html lang="pt-br">
 <head>
   <meta charset="utf=8">
   <meta http-equiv="refresh" content="120">
   <title>Tela inicial</title>
   <link rel="stylesheet" type="text/css" href="../css/es.css">
   <link type='image/x-icon' rel='shortcut icon' href='../icones/ufamicon.ico'>
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
 </head>
 <body>
 <div id="logoufam" >
 <label for="chec">
 <img width="100px" height="90px" src="../ufam.png"/>
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
        <li><a href="tela_inicial.php">Inicio</a></li>
        <li><a href="sair.php">Sair</a></li>
     </ul>
 </nav>
 </div>
 <div id="corpo_adm">
   <form method='POST'>
   <input type='submit' name='bkp' value='Backup de toda a base'>
   </form>
 </div>
 </body>
 <footer>
 <label >&copy;2019 N.B.O <br>Suporte: arquivo_proeg@ufam.edu.br<label>
</footer> 
 </html>
<?php
if(isset($_POST['bkp'])){
    header("Location:backup.php");
}
?>