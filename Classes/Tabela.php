<?php
class Tabela{
private $id,$im,$di,$td,$cd,$ad,$tb,$no;
function setId($id){
  $this->id = $id;
}
function getIm(){
  return $this->im;
}
function setIm($im){
  $this->im = $im;
}
function getId(){
  return $this->id;
}
function pesquisa_doc(){
  $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
  $pdo -> query("SET NAMES UTF8");
  $stmt = $pdo->prepare("SELECT * FROM Ko WHERE imagem LIKE '$this->im' ORDER BY ano_doc ASC");
  $stmt->execute(array('id','data_inserido','tipo_doc','class_doc','nome','ano_doc'));
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $item){
      $this->tb .= "<tr>
               <td style='display:none;'>".$item['id']."</td>
               <td style='font-size:17px;'>".$item['tipo_doc']."</td>
               <td style='font-size:17px;'>".$item['class_doc']."</td>
               <td style='font-size:17px;'>".$item['nome']."</td>
               <td style='font-size:15px;'>".$item['ano_doc']."</td>
               </tr>";
    }
}
function pesquisa_doc3(){
  $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
  $pdo -> query("SET NAMES UTF8");
  $stmt = $pdo->prepare("SELECT * FROM Ko WHERE imagem LIKE '$this->im' ORDER BY ano_doc ASC");
  $stmt->execute(array('id','data_inserido','tipo_doc','class_doc','nome','ano_doc'));
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $item){
      $this->tb .= "<tr onclick='visul(".$item['id'].");'>
               <td style='display:none;'>".$item['id']."</td>
               <td style='font-size:17px;'>".$item['tipo_doc']."</td>
               <td style='font-size:17px;'>".$item['class_doc']."</td>
               <td style='font-size:17px;'>".$item['nome']."</td>
               <td style='font-size:15px;'>".$item['ano_doc']."</td>
               </tr>";
    }
}
function pesquisa_doc2($id,$im){
  $this->id = $id;
  $this->im = $im;
  $pdo = new PDO( 'mysql:host=localhost;dbname=Al', 'root', '' );
  $pdo -> query("SET NAMES UTF8");
  $stmt = $pdo->prepare("SELECT * FROM Ko WHERE id LIKE '$this->id' ORDER BY ano_doc ASC");
  $stmt->execute(array('id','tipo_doc','class_doc','nome','ano_doc','data_inserido'));
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($resultado as $item){

               $this->id = $item['id'];
               $this->td = $item['tipo_doc'];
               $this->cd=$item['class_doc'];
               $this->no=$item['nome'];
               $this->ad=$item['ano_doc'];
               $this->di=$item['data_inserido'];

    }
}
function exibir_dados(){
  $data=date('Y-m-d');
  $par = explode('-',$data);

  $en = "window.location.href='pg_res_pes_mat.php?alid=$this->im'";
  echo "<div id='alter-doc'>
    <form method='POST'  action='alterar_documento.php?id=$this->id&alid=$this->im'>
      <label>Classificação do documento:&nbsp;</label>
      <input type='text' name='classfi' id='assunto' placeholder='Pesquisar tipo de documento' value='$this->td' required><br><br>
      <label>Tipo de documento</label>
      <select name='sele'>
        <option>$this->cd</option>
        <option>Ficha Cadastral </option>
        <option >Processo</option>
        <option >Requerimento</option>
        <option >TERMO DE COMPROMISSO DE ESTÁGIO (TCE)</option>
        <option >Histórico Escolar</option>
        <option >FICHA</option>
        <option >Ofício</option>
        <option>Formulário de correção de notas e faltas</option>
        <option>MEMORANDO</option>
      </select><br><br>
      <label>Descrição: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
      <input type='text' name='descricao' value='$this->no' placeholder='Descreva a modificação'><br><br>
      <label>Ano do documento:&nbsp;</label>
      <input id='ano' name='ano' value='$this->ad' type='number' min='1900' max='$par[0]' required>
      <br><input  type='submit' value='Salvar'><br><br>
    </form>


    <button onclick='funcao1()'>Apagar documento</button><br><br>
    <button  onclick=".$en.">voltar</button>

  </div>";
  $eap = "";
  echo "<script>
function funcao1()
{
var x;
var r=confirm('Deseja realmente excluí esse documento?' );
if (r==true)
  {
  var x='S';
  }
else
  {
  var x='N';
  }
  window.location.href='apagar_documento.php?alid=$this->im&iddoc=$this->id&nome='+x;
}
</script>";
}
function exibir_tabela(){
  echo "
  <table  id='minhaTabela' class='tabfom'>
     <thead class='cabecalj'>
          <tr>
               <th style='display:none;'>ID</th>
               <th>Classificação do <br> documento</th>
               <th>Tipo de <br> documento</th>
               <th>Descrição</th>
               <th>Ano do documento</th>
          <tr>
     </thead>
     <tbody>
     $this->tb
     </tbody>
  </table>";
}

}
 ?>
