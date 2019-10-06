<?php
include_once 'ConAL.php';

$assunto = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

$result_usuario = "SELECT * FROM Ife WHERE cod LIKE '%".$assunto."%' OR nome_doc LIKE '%".$assunto."%' LIMIT 10";

$resultado_usuario = mysqli_query($conn, $result_usuario);



    while($row_usuario = mysqli_fetch_array($resultado_usuario)){

    $data[] = $row_usuario['cod']." - ".$row_usuario['nome_doc'];


}
echo json_encode($data);

?>
