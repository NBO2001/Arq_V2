<?php
require_once 'Conec_PDO.php';
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}
$pesqi = $_POST['id_alteracao'];
if(isset($pesqi)){
  $veri_db  =$pdo->prepare("SELECT * FROM log WHERE id LIKE $pesqi LIMIT 1");
  $veri_db->execute();
  $resu_veri_db = $veri_db->fetchAll(PDO::FETCH_ASSOC);
}
  echo "
  <div class='form-group'>
  
  <div class='form-row'>
  
    <div class='col-md-8'>
      <label for='frm-nome-usu'>Nome</label>
      <input name='frm-nome-usu' id='frm-nome-usu' type='text' class='form-control' value='".$resu_veri_db[0]['nome']."' placeholder='O nome do usuário'>
    </div>
    <div class='col-md-3'>
      <label for='frm-setor-usu'>Setor</label>
      <select name='frm-setor-usu'  id='frm-setor-usu 'class='form-control'>
      <option selected>".$resu_veri_db[0]['setor']."</option>  
      <option>Arquivo acadêmico</option>
        <option>CAUSA</option>
        <option>CRC</option>
        <option>CRD</option>
        <option>CM</option>
        <option>COA</option>
        <option>DPA</option>
        <option>Protocolo</option>
      </select>
    </div>
  
  </div>
  
  <div class='form-row'>
    <div class='col-md-3'>
      <label for='frm-cpf-usu'>CPF</label>
      <input name='frm-cpf-usu' id='frm-cpf-usu' type='text' class='form-control' value='".$resu_veri_db[0]['cpf']."' placeholder='O cpf do usuário'>
    </div>
    <div class='col-md-6'>
      <label for='frm-email-usu'>Email</label>
      <input name='frm-email-usu' id='frm-email-usu' type='email' class='form-control' value='".$resu_veri_db[0]['email']."' placeholder='O email do usuário'>
    </div>
    <div class='col-md-2'>
      <label for='frm-acesso-usu'>N/acesso:</label>
      <input name='frm-acesso-usu' id='frm-acesso-usu' type='number' class='form-control' min='1' max='4' value='".$resu_veri_db[0]['acesso']."'>
    </div>
  </div>
  </div>
  <input name='frm-id-usu' id='frm-id-usu' type='text' style='display:none;' value='".$resu_veri_db[0]['id']."'>
  <div class='form-row'>
    <div class='col-md-5'>
      <label for='frm-senha-usu'>Login</label>
      <input name='frm-ursu-usu' id='frm-ursu-usu' type='text' class='form-control' value='".$resu_veri_db[0]['ursu']."' placeholder='O nome do usuário'>
      </div>
  
  </div>
  <div class='modal-footer'>
     
     <button type='submit'  class='btn btn-outline-dark btn-block'>Alterar dados</button>
  
  </div>
  ";


?>