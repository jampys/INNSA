<?php
require_once('config.php');


$f=new Factory();
$s=$f->returnsQuery();
$query="select * from usuarios";
$s->executeQuery($query);
$r=$s->fetchAll();

echo"<hr/>";
echo 'Cantidad de filas afectadas:'.$s->getAffect();
echo '<br/>';
echo 'Liberacion de la consulta:'.$s->clean();
//print_r($r);

?>



<table border="1" width="60%" cellspacing="0">
    <tr>
        <td>ID</td>
        <td>NOMBRE</td>
        <td>DESCRIPCION</td>
    </tr>

        <?php
        foreach ($r as $fila){
            ?>
            <tr>
                <td><?php echo $fila['ID_USUARIO    ']; ?></td>
                <td><?php echo $fila['LOGIN']; ?></td>
                <td><?php echo $fila['PASSWORD']; ?></td>

            </tr>
        <?php
        }
        ?>
</table>
