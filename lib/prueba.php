<?php
require_once('config.php');


$f=new Factory();
$s=$f->returnsQuery();
//$query="select te.nombre nom from temas te, categorias ca where te.id_categoria=ca.id_categoria";
$query="select * from solicitud_capacitacion sc, empleados em, empleados emx where sc.id_empleado=em.id_empleado and sc.apr_solicito=emx.id_empleado";
$s->executeQuery($query);
$r=$s->fetchAll();

echo"<hr/>";
echo 'Cantidad de filas afectadas:'.$s->getAffect();
echo '<br/>';
echo 'Liberacion de la consulta:'.$s->clean();
print_r($r);
exit;

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

<hr/>
<input type="checkbox">Auto </br>
<input type="checkbox">Casa



