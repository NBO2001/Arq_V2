<?php
require_once 'Conec_PDO.php';
session_start();
if($_SESSION['acesso'] <> 4){
  header("Location:tela_inicial.php");
  die;
}

/*
$total_res = $pdo->prepare("SELECT COUNT(id) AS toti FROM pessoas");
$total_res->execute();
$total_resposta = $total_res->fetchAll(PDO::FETCH_ASSOC);
if($total_resposta[0]['toti'] == 0){
  echo "<div class='alert alert-danger' role='alert'>Nenhum registro encontrado!!</div>";
  exit;
}else{

}*/


$table = "<table class='table table-hover'>";
$table .=  "<thead class='thead-dark'>
    <tr>
        <th scope='col'>Usuario</th>
        <th scope='col'>Setor</th>
        <th scope='col'>N/Acesso</th>
        <th scope='col'>Ação</th>
        <th scope='col'>Ação</th>
    </tr>
  </thead>
  <tbody >";

$pqp = $pdo->prepare("SELECT * FROM log ORDER BY acesso DESC, setor ASC, nome ASC");
$pqp->execute();
$pqp_resultado = $pqp->fetchAll(PDO::FETCH_ASSOC);
    foreach($pqp_resultado as $item){
        $table.= "<tr>
                <th scope='row'>".$item['nome']."</th>
               <td>".$item['setor']."</td>
               <td>".$item['acesso']."</td>
               <td>
                <button type='button' class='btn btn-outline-success view_data' id = ".$item['id']."  data-toggle='modal'>
                    Visualizar
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