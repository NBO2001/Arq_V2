<?php
class Etiquetas{
  private $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$res;
  function getRes(){
    return $this->res;
  }
  function getA1(){
    return $this->a1;
  }
  function getA2(){
    return $this->a2;
  }
  function getA3(){
    return $this->a3;
  }
  function getA4(){
    return $this->a4;
  }
  function getA5(){
    return $this->a5;
  }
  function getA6(){
    return $this->a6;
  }
  function getA7(){
    return $this->a7;
  }
  function getA8(){
    return $this->a8;
  }
  function etq($curso,$Nome_cur,$Num_mat,$Nome_civil,$Fin,$Ain,$Fev,$Aev,$sistema){
    $this->a1 = "<td class='xl72' >$curso</td>
    <td class='xl73' >$Nome_cur</td>";
    $this->a2 ="<td class='xl74' colspan='2' >$Num_mat</td>";
    $this->a3 ="<td class='xl76' colspan='2' >$Nome_civil</td>";
    $this->a4 ="<td class='xl78' colspan='2' >$Fin</td>";
    $this->a5 ="<td class='xl80' colspan='2' >$Ain</td>";
    $this->a6 ="<td class='xl80' colspan='2'>$Fev</td>";
    $this->a7 ="<td class='xl80' colspan='2'>$Aev</td>";
    $this->a8 ="<td class='xl80' colspan='2'>$sistema</td>";
  }
}
?>
