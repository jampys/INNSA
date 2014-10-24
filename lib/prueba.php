<?php
require_once('config.php');


$f=new Factory();
$s=$f->returnsQuery();
$query="select te.nombre nom from temas te, categorias ca where te.id_categoria=ca.id_categoria";
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
                <td><?php echo $fila['ID_TEMA']; ?></td>
                <td><?php echo $fila['NOM']; ?></td>
                <td><?php echo $fila['OBJETIVO']; ?></td>

            </tr>
        <?php
        }
        ?>
</table>
