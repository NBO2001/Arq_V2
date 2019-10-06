<?php
session_start();
if(isset($_COOKIE["tema"])){
  $tema = $_COOKIE["tema"];
}else{
  setcookie("tema","a", (time() + (500 * 24 * 3600)));
}?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf=8">
<title>Tela inicial</title>
<link rel="stylesheet" type="text/css" href="css/es.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
<?php
  if(isset($_SESSION['ifon'])){
    echo $_SESSION['ifon'];
    unset ($_SESSION['ifon']);

  }
if(isset($_COOKIE["tema"]) AND $_COOKIE["tema"] <> "a"){
  echo "<link rel='stylesheet' type='text/css' href='css/$tema.css'>";
}
?>
</head>
<body class="pes_nome_body">

  <form method="Post" action="login_funcao.php" enctype="multipart/form-data" class="formulario_login">
    <h1>Login</h1>

    <div class="txtb">
      <input name="nuso"  type="text" required>
      <span data-placeholder="Usuario"></span>
    </div>

    <div class="txtb">
       <input name="senuso" type="password" required></input>
      <span data-placeholder="Senha"></span>
    </div>

    <input class="logbtn" name="btnlo" type="submit" value="Entrar"></input>


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
  &copy;2019 N.B.O
</footer>
</html>
