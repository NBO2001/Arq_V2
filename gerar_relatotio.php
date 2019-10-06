<?php
session_start();
if(isset($_SESSION['query'])){
  $query = $_SESSION['query'];
}
$pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
$pdo -> query("SET NAMES UTF8");
  $stmt = $pdo->prepare("$query");
  $stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Fin','Fev','Ain','Aev','sistema'));
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $dadosXls  = "";
  $dadosXls .= "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><table border='1' >";
$dadosXls .= "          <tr>";
  $dadosXls .= "          <th>Id</th>";
  $dadosXls .= "          <th>Sigla_curso</th>";
  $dadosXls .= "          <th>Numero_matricula</th>";
  $dadosXls .= "          <th>Nome_civil</th>";
  $dadosXls .= "          <th>Curso</th>";
  $dadosXls .= "          <th>Forma_ingresso</th>";
  $dadosXls .= "          <th>Forma_evassao</th>";
  $dadosXls .= "          <th>Ano_ingresso</th>";
  $dadosXls .= "          <th>Ano_evassao</th>";
  $dadosXls .= "          <th>sistema</th>";
  $dadosXls .= "      </tr>";
    foreach($resultado as $item){
      $dadosXls .= "      <tr>";
      $dadosXls .= "          <td>".$item['id']."</td>";
      $dadosXls .= "          <td>".$item['Cod_cur']."</td>";
      $dadosXls .= "          <td>".$item['Num_mat']."</td>";
      $dadosXls .= "          <td>".$item['Nome_civil']."</td>";
      $dadosXls .= "          <td>".$item['Nome_cur']."</td>";
      $dadosXls .= "          <td>".$item['Fin']."</td>";
      $dadosXls .= "          <td>".$item['Fev']."</td>";
      $dadosXls .= "          <td>".$item['Ain']."</td>";
      $dadosXls .= "          <td>".$item['Aev']."</td>";
      $dadosXls .= "          <td>".$item['sistema']."</td>";
      $dadosXls .= "      </tr>";

    }
$dadosXls .= "  </table>";

      // Definimos o nome do arquivo que será exportado
      $arquivo = "Relatório.xls";
      // Configurações header para forçar o download
      header('Content-Type: application/vnd.ms-excel; charset=uft-8');
      header('Content-Disposition: attachment;filename="'.$arquivo.'"');
      header('Cache-Control: max-age=0');
      // Se for o IE9, isso talvez seja necessário
      header('Cache-Control: max-age=1');

      // Envia o conteúdo do arquivo
      echo $dadosXls;
      exit;
?>
