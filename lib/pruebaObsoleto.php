<?php
require_once('configObsoleto.php');

$s=new sQueryOracle();
$query="select * from cursos";
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
                <td><?php echo $fila['ID_CURSO']; ?></td>
                <td><?php echo $fila['NOMBRE']; ?></td>
                <td><?php echo $fila['DESCRIPCION']; ?></td>

            </tr>
        <?php
        }
        ?>
</table>
