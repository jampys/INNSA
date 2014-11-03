<?php
require_once 'config.php';





//funciona ok

$conn=oci_connect('dario', 'dario', 'localhost');
$sql="insert into usuarios (login, password) values ('puto', 'puto')returning id_usuario into :id";
$consulta=oci_parse($conn, $sql);
oci_bind_by_name($consulta,':id',$id);
oci_execute($consulta);
echo $id;








//$rows=$stmt->fetchAll();
//otra manera de hacerlo
//$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//$conn=null;
//print_r($rows);
//print($rows[1]['LOGIN']);
//echo $stmt->rowCount();



/*
$id=1;
$producto='PHP Pattern';
$sql = "UPDATE productos SET producto=? WHERE id_producto=?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "\nPDO::errorInfo():\n";
    print_r($conn->errorInfo());
}
else{
    $stmt->execute(array($producto,$id));
}

*/



?>