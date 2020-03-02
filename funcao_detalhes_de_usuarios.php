<?php
require_once "Conec_PDO.php";
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}
$id_de_pesquisa = $_POST['id_reg'];
if(isset($id_de_pesquisa)){
 
$veri_db  =$pdo->prepare("SELECT * FROM log WHERE id LIKE $id_de_pesquisa LIMIT 1");
$veri_db->execute();
$resu_veri_db = $veri_db->fetchAll(PDO::FETCH_ASSOC);


echo  "<div class='form-group'>

<div class='form-row'>               
<div class='col-md-8'>
        <label class='col-form-label'>Usuario:</label>
       <label  class='form-control'>".$resu_veri_db[0]['nome']."</label>

</div>
<div class='col-md-3'>
<label class='col-form-label'>CPF:</label>
<label  class='form-control'>".$resu_veri_db[0]['cpf']."</label>
</div>
<div class='col-md-8'>
<label class='col-form-label'>Email:</label>
       <label  class='form-control'>".$resu_veri_db[0]['email']."</label>
</div>
<div class='col-md-3'>
<label class='col-form-label'>Setor:</label>
       <label  class='form-control'>".$resu_veri_db[0]['setor']."</label>
</div>

<div class='col-md-8'>
<label >Login:</label>
<label class='form-control'>".$resu_veri_db[0]['ursu']."</label>
</div>
<div class='col-md-2'>
<label >Nível/Acesso:</label>
<label class='form-control'>".$resu_veri_db[0]['acesso']."</label>
</div>


</div>
<button type='button' class='btn btn-success btn-block butaoalterar' id = ".$resu_veri_db[0]['id'].">Alterar</button>
<button type='button' class='btn btn-outline-danger btn-block view_data2' id = ".$resu_veri_db[0]['id']." data-toggle='modal'>Apagar</button>";

}

?>