<?php
session_start();
if($_SESSION['acesso']<>4){
 header("Location:index.php");
}

ini_set('upload_max_filesize', '20000M');
ini_set('post_max_size', '20000M');
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);

include_once 'ConAL.php';
$conf = fopen('conf.txt','r');
$conf = fgets($conf, 1024);
$dire = "$conf/In/pdf/";
$magemfinal = "";
if(!is_dir($dire)){
	echo "Pasta $dire nao existe";
}else{
	$arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
	for ($controle = 0; $controle < count($arquivo['name']); $controle++){
    $numero = $arquivo['name'][$controle];
    $numero =explode('.', $numero);
    $numerom = $numero[0];
    $numerox = $numero[1];
    if ($numerox == "pdf"){
      $numer = explode(' ', $numerom);
      $numerom= $numer[0];
      if ($numer[1]==1){
        $tipodoc = "FICHA CADASTRAL";
      }else if($numer[1]==2){
        $tipodoc = "PROCESSO";
      }
      else if($numer[1]==3){
        $tipodoc = "REQUERIMENTO";
      }
      else if($numer[1]==4){
        $tipodoc = "TCE";
      }
      else if($numer[1]==5){
        $tipodoc = "HISTÓRICO ESCOLAR";
      }
      else if($numer[1]==6){
        $tipodoc = "OUTRO TIPO DE FICHA";
      }
      $cladoc = explode('-',$numer[2]);
      $cladoc = $cladoc[0].'.'.$cladoc[1];
      $comentario = explode('-',$numer[4]);
      $comentario = $comentario[0].' '.$comentario[1];
      $comentario=strtoupper($comentario);
      $result_usuario = "SELECT *,count(*) FROM Alunos WHERE Num_mat LIKE '$numerom'";
      $resultado_usuario = mysqli_query($conn, $result_usuario);
      $row_usuario = mysqli_fetch_array($resultado_usuario);
      if ($row_usuario['count(*)']==1) {
        $matri = $row_usuario['Num_mat'];
        $nomejh = $row_usuario['Nome_civil'];
        $curso = $row_usuario['Cod_cur'];
        $nun = $row_usuario['id'];
        if ($tipodoc =="FICHA CADASTRAL" ){

          $coman = "SELECT * FROM Ko WHERE imagem LIKE '$nun' AND class_doc LIKE 'FICHA CADASTRAL'";
          $ver = mysqli_query($conn,$coman);
          $verificador = mysqli_fetch_array($ver);
          $dois = $verificador['id'];
        }if ($dois == ""){

          date_default_timezone_set('America/Sao_Paulo');
          $dataLocal = date('d-m-Y', time());
          $dataL = date('Y-m-d', time());
          $data=date('H:i:s');
          $data=explode(':',$data);
          $horari = $data[0]-1;
          $horari = $horari = $dataLocal." -- ".$horari.":".$data[1].":".$data[2];
          $usuarioname = $_SESSION['usuarioname'];
          $dire = "$conf/In/pdf/";
          $dire .=$nun."/";
          mkdir($dire);
          chmod ($dire,0777);
          if(move_uploaded_file($arquivo['tmp_name'][$controle], $dire.$tipodoc."->".$horari.".pdf")){
            echo $dire."<br>";
            $nome_pdf = $tipodoc."->".$horari.".pdf";
            $can = "/In/pdf/".$nun."/".$nome_pdf;
            $result_usuarioife = "SELECT * FROM Ife WHERE cod LIKE '$cladoc'";
            $resultado_usuarioife = mysqli_query($conn, $result_usuarioife);
            $row_usuarioife = mysqli_fetch_array($resultado_usuarioife);
            $tipo_doc = $row_usuarioife ['cod']." -- ".$row_usuarioife ['nome_doc'];
            $destin_fin = $row_usuarioife ['destin_fin'];
            $fase_con =$row_usuarioife ['fase_con'];
            $fase_con =explode(' ',$fase_con);
            $ano_va = $fase_con[0];
            $fase_in = $row_usuarioife ['fase_in'];
            $fase_in = explode(' ',$fase_in);
            $ano_vb = $fase_in[0];
            if ($ano_va > 0){
              if ($ano_vb>0){
                $ano_ex = $ano_va+$ano_vb;
                $ano_ex = $ano + $ano_ex;
                $ano_ex ="'".$ano_ex."'";
                $fase_con =$row_usuarioife ['fase_con'];
                $fase_in = $row_usuarioife ['fase_in'];
              }else{
                    $ano_ex = $ano_va;
                    $ano_ex = $ano + $ano_ex;
                    $ano_ex ="'".$ano_ex."'";
                    $fase_con =$row_usuarioife ['fase_con'];
                    $fase_in = $row_usuarioife ['fase_in'];

                  }
            }else{
                    if ($ano_vb>0){
                      $ano_ex = $ano_vb;
                      $ano_ex =$ano + $ano_ex;
                      $ano_ex ="'".$ano_ex."'";
                      $fase_con =$row_usuarioife ['fase_con'];
                      $fase_in = $row_usuarioife ['fase_in'];

                    }else{
                    $ano_ex ="NULL";
                    $fase_con =$row_usuarioife ['fase_con'];
                    $fase_in = $row_usuarioife ['fase_in'];
                    }
                }
                $ano = $numer[3];
                $sql = "INSERT INTO Ko (id,nome, imagem,nome_pdf,tipo_doc,ano_doc,data_inserido,can,fase_con,fase_in,destin_fin,ano_ex,usuarioname,class_doc) VALUES (NULL,'$comentario', '$nun','$nome_pdf','$tipo_doc','$ano','$dataL','$can','$fase_con','$fase_in','$destin_fin',$ano_ex,'$usuarioname','$tipodoc')";
                $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                $magemfinal = $magemfinal."<a href='redir_mesn.php?texto=$nun' target='_blank'><p>Matricula:$curso --> $matri <br> Nome: $nomejh<br>Enviado com sucesso </p></a><br>";
          }else{
              $magemfinal = $magemfinal."Erro ao realizar upload";
            }

        }else{

        $magemfinal = $magemfinal."<a href='pg_res_pes_mat.php?alid=$nun' target='_blank'><p>Matricula:$curso --> $matri <br> Nome: $nomejh<br>Aluno já tem ficha de cadastro</p></a><br>";
        }


      }else{
      $msh =$row_usuario['Cod_cur']." --> ".$row_usuario['Num_mat']." --> ".$row_usuario['Nome_civil'];
      $magemfinal = $magemfinal."<a href='redir_mesn.php?texto=$nun' target='_blank'><p>$msh <br>FALHA: possui mais de uma matricula, falha ao tentar enviar</p></a><br>";
      }
    }else{
    $magemfinal = $magemfinal."<p>$numerom.$numerox: tipo de arquivo não suportado</p><br>";
    }
  }
$_SESSION['stuup']= $magemfinal;
header("Location:multup.php");
}
?>
