<?php
session_start();
unset ($_SESSION['acesso']);
header("Location:index.php");
 ?>
