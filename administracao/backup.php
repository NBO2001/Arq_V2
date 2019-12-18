<?php
session_start();
if($_SESSION['acesso']<>4){
    header("Location:../index.php");
    die;
}
require_once '../Conec_PDO.php';
set_time_limit(0);
//function base_total(){
    $sql = "DROP DATABASE IF EXISTS Al;\n";
    $bac = $pdo->prepare("SHOW CREATE DATABASE Al");
    $bac->execute();
    $bac_resultados = $bac->fetchALL(PDO::FETCH_ASSOC);
    $sql .= $bac_resultados[0]['Create Database'].";\nUSE Al;\n";

    $banco = $pdo->prepare("SHOW TABLES");
    $banco->execute();
    $banco_resultados = $banco->fetchALL(PDO::FETCH_ASSOC);
    $cont_tables = 0;
    foreach($banco_resultados as $banco_resultado){
        $tables_names[] = $banco_resultado['Tables_in_Al'];
        $cont_tables++;
    }
    $cont_tables_controle=0;
    while ($cont_tables <> $cont_tables_controle){
        $est_tables = $pdo->prepare("SHOW CREATE TABLE $tables_names[$cont_tables_controle]");
        $est_tables->execute();
        $est_tables_resultados = $est_tables->fetchALL(PDO::FETCH_ASSOC);
        $sql .= $est_tables_resultados[0]['Create Table'].";\n";
        $nome_tables = $pdo->prepare("DESCRIBE $tables_names[$cont_tables_controle]");
        $nome_tables->execute();
        $nome_tables_resul = $nome_tables->fetchALL(PDO::FETCH_ASSOC);
        $name_coluns =0;

        $valores_tables = $pdo->prepare("SELECT * FROM $tables_names[$cont_tables_controle]");
        $valores_tables->execute();
        $valores_tables_resul = $valores_tables->fetchALL(PDO::FETCH_ASSOC);
        if(isset($valores_tables_resul[0][$nome_tables_resul[0]['Field']])){
            $sql .= "INSERT INTO `".$tables_names[$cont_tables_controle]."` (";
            while(isset($nome_tables_resul[$name_coluns]['Field'])){
                $sql .= "`".$nome_tables_resul[$name_coluns]['Field']."`,";
                $name_coluns++;
            }
            $sql = substr($sql,0,-1);
            $sql .= ") VALUES \n";
            $alunos = "";
            foreach($valores_tables_resul as $item){
                $mais_um = 0;
                $alunos .= "(";
                while($mais_um <> $name_coluns){
                    if(isset($item[$nome_tables_resul[$mais_um]['Field']])){
                        $alunos .=  "'".$item[$nome_tables_resul[$mais_um]['Field']]."',";
                    }else{
                        $alunos .= "NULL,";
                    }
                    
                    $mais_um++;
                }
                $alunos = substr($alunos,0,-1);
                $alunos .="),";
            }
            $alunos = substr($alunos,0,-1);
            $sql .=$alunos.";";
        }else{
            
        }
    // echo $alunos;
        $cont_tables_controle++;
    }

    //Criar o diretório de backup
    $diretorio = '../backup/';
    if(!is_dir($diretorio)){
        mkdir($diretorio, 0777, true);
        chmod($diretorio, 0777);
    }

    //Nome do arquivo de backup
    $nome_arquivo = $diretorio . "db_backup_";
    //echo $nome_arquivo;

    $handle = fopen($nome_arquivo . '.sql', 'w+');
    fwrite($handle, $sql);
    fclose($handle);

    //Montagem do link do arquivo
    $download = $nome_arquivo . ".sql";

    //Adicionar o header para download
    if(file_exists($download)){
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=\"" . basename($download) . "\";");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . filesize($download));
        readfile($download);
        exec('rm ../backup/*');
    }
//}
?>