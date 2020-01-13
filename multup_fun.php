<?php
session_start();
if($_SESSION['acesso']<3){
 header("Location:index.php");
 die;
}
require_once "Conec_PDO.php";
set_time_limit(0);
date_default_timezone_set('America/Manaus');
ini_set('upload_max_filesize', '20000M');
ini_set('post_max_size', '20000M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);


$magemfinal = "";
$conf = fopen('conf.txt','r');
$conf = fgets($conf, 1024);
$dire = "$conf/In/pdf/";
if(!is_dir($dire)){
echo "Pasta $dire nao existe";

}else{
  if(isset($_POST['enviar1'])){
    $procura_ult = $pdo->prepare("SELECT id FROM Ko ORDER BY id DESC LIMIT 1");
    $procura_ult->execute();
    $procura_ult_resul = $procura_ult->fetchAll(PDO::FETCH_ASSOC);
    $ult_registro = $procura_ult_resul[0]['id'];
    $tipodoc = "FICHA CADASTRAL";
    $class_N = "125.43 -- Assentamentos individuais dos alunos (Dossiês dos alunos)";
    $complemento = "MATRICULA INSTITUCINAL";
    $fase_corrente = "Enquanto o aluno mantiver o vínculo com a instituição de ensino";
    $fase_intermediaria = "-";
    $destino_final = "Eliminação";
    $usuarioname = $_SESSION['usuarioname'];
    $ano = $_POST['ano'];
    $data_atual = date('Y-m-d');

    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
    for ($controle = 0; $controle < count($arquivo['name']); $controle++){
      $numero = explode('.',$arquivo['name'][$controle]);
      if($numero[1] == "pdf"){
        $procura_al = $pdo->prepare("SELECT *,count(*) FROM Alunos WHERE Num_mat LIKE '$numero[0]'");
        $procura_al->execute();
        $procura_al_resul = $procura_al->fetchAll(PDO::FETCH_ASSOC);
        if($procura_al_resul[0]['count(*)']==1){
          $id = $procura_al_resul[0]['id'];
          if(!is_dir($conf."/In/pdf/".$id)){
            mkdir($conf."/In/pdf/".$id);
            chmod ($conf."/In/pdf/".$id,0777);
          }
          $nomedocumento = $procura_al_resul[0]['Num_mat'].'-65-'.$controle."-".date('His').".pdf";
          $caminho = $id."/".$nomedocumento;
          $destino = $conf."/In/pdf/".$caminho;
            if (move_uploaded_file($arquivo['tmp_name'][$controle], $destino)) {
              $ise = $pdo->prepare("INSERT INTO Ko SET nome = '$complemento',imagem = '$id',nome_pdf='$nomedocumento',
              tipo_doc='$class_N',ano_doc='$ano',data_inserido='$data_atual',can='$caminho',fase_con='$fase_corrente',fase_in='$fase_intermediaria',
              destin_fin='$destino_final',ano_ex='0',usuarioname='$usuarioname',class_doc='$tipodoc'");
            $ise->execute();
            $ult_registro++;
            $al_ms = $procura_al_resul[0]['Num_mat']." -> ". $procura_al_resul[0]['Nome_civil']." -> ".$procura_al_resul[0]['Nome_cur'];
            $magemfinal .="<p><a href='pg_res_pes_mat.php?alid=$id' target='_blank'>$al_ms</a>
            <a href='pdf_visu.php?id=$ult_registro' target='_blank'>Aperte para visualizar o pdf</a></p>";
          }
        }else{
          $magemfinal .="<p>A matricula -> ".$numero[0]." tem mais de um resultado ou nenhum, portanto é impossível</p>";
        }
        
      }else{
        $magemfinal .="<p>o arquivo -> ".$numero[0]." não é pdf</p>";
      }
      
    }
    $_SESSION['stuup']= $magemfinal;
    header("Location:multup.php");
  }

}
?>
