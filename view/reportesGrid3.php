
<script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
        //oculta el detalle de cada fila del reporte
        $('.oculta').hide();

        //oculta y desoculta el detalle de cada fila del reporte
        $('#reportes tbody tr').on('click', function(){
            $(this).next('tr').toggle();
        });
    });


</script>

<table cellpadding="0" cellspacing="0" width="100%" class="display" id="reportes">
    <thead>
    <tr>
        <th>Período</th>
        <th>Plan capacitación</th>
        <th>Cant. recursos</th>
        <th>Duración</th>
        <th>Unidad</th>
        <th>Precio unitario</th>
        <th>Subtotal s/viáticos (pesos)</th>
        <th>Total c/viáticos (pesos)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Período</th>
        <th>Plan capacitación</th>
        <th>Cant. recursos</th>
        <th>Duración</th>
        <th>Unidad</th>
        <th>Precio unitario</th>
        <th>Subtotal s/viáticos (pesos)</th>
        <th>Total c/viáticos (pesos)</th>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($view->planes as $plan) {?>
        <tr class="odd gradeA">
            <td style="background-color: #FFD699"><?php  echo $plan["PERIODO"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["NOMBRE"];  ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["CANTIDAD"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["DURACION"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["UNIDAD"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["UNITARIO"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["SUBTOTAL"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["TOTAL"]; $total_general+=$plan["TOTAL"]; ?></td>
        </tr>
        <tr class="oculta">
            <td colspan="8">



                <?php
                require_once("model/cap_solicModel.php");
                $a=new Reportes();
                $repox=$a->getEmpleadosByPlan($lugar_trabajo, $plan["ID_PLAN"]);
                if(isset($repox)){

                ?>

                <table border="1">
                    <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Viaticos</th>
                    </tr>

                    <?php

                    foreach ($repox as $repo) {?>
                        <tr class="odd gradeA">
                            <td style="width: 300px"><?php  echo $repo["APELLIDO"]; ?></td>
                            <td style="width: 70px"><?php  echo $repo["NOMBRE"]; ?></td>
                            <td style="width: 50px"><?php  echo $repo["VIATICOS"];  ?></td>
                        </tr>


                    <?php
                    }

                    }
                    ?>

                </table>




            </td>
        </tr>



    <?php }  ?>

    </tbody>
</table>

<!--Muestra el total general -->
<br/>
<h5>Costo total de capacitación (en pesos) para el periodo seleccionado es: $ <?php echo $total_general; ?> </h5>

