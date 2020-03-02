<?php
require_once 'Conec_PDO.php';
session_start();
if($_SESSION['acesso'] == ""){
  header("Location:tela_inicial.php");
  die;
}
//cabeçaho da tabela
$table = "<table class='table table-hover'>";
$table .=  "<thead class='thead-dark'>
    <tr>
        <th scope='col'>Solicitante</th>
        <th scope='col'>Setor</th>
        <th scope='col'>Sigla</th>
        <th scope='col'>Matricula</th>
        <th scope='col'>OBS</th>
        <th scope='col'>Data</th>
        <th scope='col'>----</th>
        <th scope='col'>----</th>
        <th scope='col'>----</th>
    </tr>
  </thead>
  <tbody >";
  $lista_m = $pdo->prepare("SELECT * FROM mensa WHERE sts LIKE '1' ORDER BY urg DESC");
  $lista_m->execute();
  $lista_msg = $lista_m->fetchAll(PDO::FETCH_ASSOC);
  foreach($lista_msg as $item){
     //encontrar solicitante
     $soli = $item['soli'];
     $solicitante = $pdo->prepare("SELECT * FROM log WHERE id LIKE '$soli'");
     $solicitante->execute(array('nome','setor'));
     $solicitante = $solicitante->fetchAll(PDO::FETCH_ASSOC);
    //encontrar solicitante FIM

    //encontrar Pasta
    $solicitacao = $item['solicitacao'];
    $solicitacao_p = $pdo->prepare("SELECT * FROM Alunos WHERE id LIKE '$solicitacao'");
    $solicitacao_p->execute(array('Cod_cur','Num_mat'));
    $solicitacao_pasta = $solicitacao_p->fetchAll(PDO::FETCH_ASSOC);
    if($item['urg'] == 1){
        $classi = "class='table-danger'";
    }else{
        $classi = "";
    }
    
    //encontrar Pasta FIM
    $table.= "<tr $classi>
    <th scope='row'>".$solicitante[0]['nome']."</th>
   <td>".$solicitante[0]['setor']."</td>
   <td>".$solicitacao_pasta[0]['Cod_cur']."</td>
   <td>".$solicitacao_pasta[0]['Num_mat']."</td>
   <td>".$item['obv']."</td>
   <td>".$item['data']."</td>
   <td>
    <button type='button' class='btn btn-outline-success view_data' id = ".$solicitacao."  data-toggle='modal'>
        Visualizar
      </button>
    </td>
    <td>
    <button type='button' class='btn btn-outline-primary resp' id = ".$item['id']."  data-toggle='modal'>
        Responder
      </button>
    </td>
    <td>
    <button type='button' class='btn btn-outline-danger view_data2' id = ".$item['id']."  data-toggle='modal'>
        Apagar
      </button>
    </td>
   </tr>";
  }
  $table .="</tbody>
</table>";
echo $table;
?>