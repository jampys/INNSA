<?php
require_once('config.php');


$f=new Factory();
$s=$f->returnsQuery();
//$query="select te.nombre nom from temas te, categorias ca where te.id_categoria=ca.id_categoria";
//$query="select * from solicitud_capacitacion sc, empleados em, empleados emx where sc.id_empleado=em.id_empleado and sc.apr_solicito=emx.id_empleado";


/*$query="select co.objetivo_1, co.objetivo_2, co.objetivo_3".
    " from cap_comunicacion co, asignacion_plan ap".
    " where co.id_asignacion = ap.id_asignacion".
    " and ap.id_asignacion = 301";*/

$query="select fecha_desde from plan_capacitacion";

$s->executeQuery($query);
$r=$s->fetchAll();

echo"<hr/>";
echo 'Cantidad de filas afectadas:'.$s->getAffect();
echo '<br/>';
echo 'Liberacion de la consulta:'.$s->clean();
//print_r($r);
//exit;

?>



<table border="1" width="80%" cellspacing="0">
    <tr>
        <td>Fecha</td>
        <td>Fecha en segundos</td>
        <td>DESCRIPCION</td>
    </tr>

        <?php
        foreach ($r as $fila){
            ?>
            <tr>
                <td><?php echo $fila['FECHA_DESDE']; ?></td>
                <td><?php

                    $date = DateTime::createFromFormat('d/m/y', $fila['FECHA_DESDE']);
                    echo $date->format('y-m-d');
                    //echo strtotime($date->format('y-m-d'));


                    ?></td>
                <td><?php echo $fila['OBJETIVO']; ?></td>

            </tr>
        <?php
        }
        ?>
</table>

<hr/>
<input type="checkbox">Auto </br>
<input type="checkbox">Casa

<hr/>
<INPUT TYPE="NUMBER" MIN="1" MAX="5" STEP="1" VALUE="5" SIZE="1">

<hr/>







<?php
$today=time();
echo 'la fecha actual es: '.$today;
?>
<br/>
<?php
echo 'otra prueba';
echo 'los segundos actuales son: '.(time()-(60*60*24));

?>


<select name="periodo" id="periodo">
    <option value="">Seleccione el periodo</option>
    <!--<option value="2014">2014</option>
    <option value="2015">2015</option>-->
    <?php
    foreach ($periodos as $per){
    ?>
    <option><?php echo $per; ?></option>
    <?php
    }
    ?>
</select>




<br/>
<?php echo $_SESSION['USER_APELLIDO'] ?>






