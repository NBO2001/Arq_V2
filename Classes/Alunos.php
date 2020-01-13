<?php
class Aluno{
  private $matricula,$id,$Cod_cur,$Num_mat,$Nome_civil,$Fin;
  private $Fev,$Ain,$Aev,$sistema,$Nome_cur,$Nome_social,$cont;
function getNome_social(){
    return $this->Nome_social;
  }
function getNome_cur(){
  return $this->Nome_cur;
}
  function getMatricula(){
    return $this->matricula;
  }
  function setMatricula($ma){
    $this->matricula = $ma;
  }
  function getId(){
    return $this->id;
  }
  function setId($id){
    $this->id = $id;
  }
  function getCod(){
    return $this->Cod_cur;
  }
  function getNum_mat(){
    return $this->Num_mat;
  }
  function getNome_civil(){
    return $this->Nome_civil;
  }
  function getFin(){
    return $this->Fin;
  }
  function getFev(){
    return $this->Fev;
  }
  function getAin(){
    return $this->Ain;
  }
  function getAev(){
    return $this->Aev;
  }
  function getSistema(){
    return $this->sistema;
  }
  function pesquisa_banco($ma){
    $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
    $pdo -> query("SET NAMES UTF8");
    $stmt = $pdo->prepare("SELECT *,COUNT(*) FROM Alunos WHERE Num_mat LIKE '$ma%'");
    $stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Fin','Fev','Ain','Aev','sistema','Nome_social','COUNT(*)'));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach($resultado as $item){
        $this->cont =  $item['COUNT(*)'];
        $this->id =  $item['id'];
        $this->Cod_cur =  $item['Cod_cur'];
        $this->Num_mat =  $item['Num_mat'];
        $this->Nome_civil =  $item['Nome_civil'];
        $this->Nome_cur =  $item['Nome_cur'];
        $this->Fin =  $item['Fin'];
        $this->Fev =  $item['Fev'];
        $this->Ain =  $item['Ain'];
        $this->Aev =  $item['Aev'];
        $this->sistema =  $item['sistema'];
        $this->Nome_social =  $item['Nome_social'];

      }
  }
  function pesquisa_banco2($id){
    $this->id = $id;
    $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
    $pdo -> query("SET NAMES UTF8");
    $stmt = $pdo->prepare("SELECT * FROM Alunos WHERE id LIKE $this->id");
    $this->cont = 1;
    $stmt->execute(array('id','Cod_cur','Num_mat','Nome_civil','Nome_cur','Fin','Fev','Ain','Aev','sistema','Nome_social'));
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach($resultado as $item){
        $this->id =  $item['id'];
        $this->Cod_cur =  $item['Cod_cur'];
        $this->Num_mat =  $item['Num_mat'];
        $this->Nome_civil =  $item['Nome_civil'];
        $this->Nome_cur =  $item['Nome_cur'];
        $this->Fin =  $item['Fin'];
        $this->Fev =  $item['Fev'];
        $this->Ain =  $item['Ain'];
        $this->Aev =  $item['Aev'];
        $this->sistema =  $item['sistema'];
        $this->Nome_social =  $item['Nome_social'];

      }
  }
  function exibir(){
    if($this->cont == 1){

      $loc = substr($this->Num_mat, 0,3);
      $data=date('Y')-11;
      $rest = substr($data, 0,1).substr($data, 2,2);

      if($loc<=$rest){
        $loc = "PASTA FÍSICA LOCALIZADA NO ARQUIVO SUL";
      }else{
        $loc = "PASTA FÍSICA LOCALIZADA NO ARQUIVO NORTE";
      }
      echo "<div id='dadosal'>
      <label style='color:#A52A2A;' >Nome civil: &nbsp</label>
      <label> $this->Nome_civil </label><br>
      <label style='color:#A52A2A;'>Nome social: &nbsp</label>
      <label>$this->Nome_social</label><br>
      <label style='color:#A52A2A;' >Matrícula: &nbsp</label>
      <label> $this->Num_mat &nbsp&nbsp&nbsp&nbsp&nbsp</label>
      <label style='color:#A52A2A;'>Curso: &nbsp</label>
      <label>$this->Cod_cur-- &nbsp </label>
      <label>$this->Nome_cur</label><br>
      <label style='color:#A52A2A;'>Forma de ingresso: &nbsp</label>
      <label >$this->Fin &nbsp&nbsp | &nbsp</label>
      <label style='color:#A52A2A;'>Ano de ingresso: &nbsp</label>
      <label >$this->Ain</label><br>
      <label style='color:#A52A2A;'>Forma de evasão: &nbsp</label>
      <label>$this->Fev&nbsp&nbsp | &nbsp</label>
      <label style='color:#A52A2A; '>Ano de evasão: &nbsp</label>
      <label>$this->Aev&nbsp&nbsp | &nbsp</label>
      <label style='color:#A52A2A';>Dados retirados do: &nbsp</label>
      <label>$this->sistema</label><br>
      <label style='font-size: 11px;'>$loc</label>
      </div>
      <div id='dadosal2' style='display:none;'>
      <label style='color:#A52A2A;' >Nome civil:</label><br>
      <label> $this->Nome_civil </label><br>
      <label style='color:#A52A2A;'>Nome social:</label><br>
      <label>$this->Nome_social</label><br>
      <label style='color:#A52A2A;' >Matrícula:</label>
      <label>$this->Num_mat</label><br>
      <label style='color:#A52A2A;'>Curso: &nbsp</label>
      <label>$this->Cod_cur:</label>
      <label>$this->Nome_cur</label><br>
      <label style='color:#A52A2A;'>Forma de ingresso: </label>
      <label >$this->Fin</label><br>
      <label style='color:#A52A2A;'>Ano de ingresso: </label>
      <label >$this->Ain</label><br>
      <label style='color:#A52A2A;'>Forma de evasão: </label>
      <label>$this->Fev</label><br>
      <label style='color:#A52A2A; '>Ano de evasão: </label>
      <label>$this->Aev</label><br>
      <label style='color:#A52A2A';>Dados retirados do: &nbsp</label>
      <label>$this->sistema</label><br>
      <label style='font-size: 40px;'>$loc</label>
      </div>
      ";
    }else{
      echo "<script>window.location.href='psq_nome.php?nun=$this->matricula'</script>";
    }

  }
}
?>
