<?php
class Alunos_nome{
private $nome,$matricula,$tb;
function getTb(){
  return $this->tb;
}
function getNome(){
  return $this->nome;
}
function getMatricula(){
  return $this->matricula;
}
function pesquisa_nome($nome){
  $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
  $pdo -> query("SET NAMES UTF8");
  $stmt = $pdo->prepare("SELECT * FROM Alunos WHERE Nome_civil LIKE '%$nome%' OR Nome_social LIKE '%$nome%' ORDER BY Num_mat ASC LIMIT 500");
  $stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Nome_social'));
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if(isset($resultado[0]['id'])){
    foreach($resultado as $item){
      $this->tb .= "<tr>
               <td style='display:none;'>".$item['id']."</td>
               <td style='font-size:17px;'>".$item['Cod_cur']."-->".$item['Nome_cur']."</td>
               <td style='font-size:17px;'>".$item['Num_mat']."</td>
               <td style='font-size:17px;'>".$item['Nome_civil']."</td>
               <td style='font-size:15px;'>".$item['Nome_social']."</td>
               </tr>";
    }
  }else{
    $_SESSION['ifon']="<script>alert('A pesquisa não retornou resultados')</script>";
    header("Location:tela_inicial.php");
    die;
  }
   

}
function pesquisa_matricula($matricula){
  $this->matricula = $matricula;
  $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
  $pdo -> query("SET NAMES UTF8");
  $stmt = $pdo->prepare("SELECT * FROM Alunos WHERE Num_mat LIKE '$matricula%'  ORDER BY Num_mat ASC");
  $stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Nome_social'));
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if(isset($resultado[0]['id'])){
    foreach($resultado as $item){
      $this->tb .= "<tr>
               <td style='display:none;'>".$item['id']."</td>
               <td style='font-size:17px;'>".$item['Cod_cur']."-->".$item['Nome_cur']."</td>
               <td style='font-size:17px;'>".$item['Num_mat']."</td>
               <td style='font-size:17px;'>".$item['Nome_civil']."</td>
               <td style='font-size:15px;'>".$item['Nome_social']."</td>
               </tr>";
    }
  }else{
    $_SESSION['ifon']="<script>alert('A pesquisa não retornou resultados')</script>";
    header("Location:tela_inicial.php");
    die;
  }
}

    function exibir_tabela(){
      echo "
      <table  id='minhaTabela'>
         <thead class='cabecalj'>
              <tr>
                   <th style='display:none;'>ID</th>
                   <th>Curso</th>
                   <th>Matricula</th>
                   <th>Nome Civil</th>
                   <th>Nome Social</th>


              <tr>
         </thead>
         <tbody>
         $this->tb
         </tbody>
      </table>";
    }
}


 ?>
