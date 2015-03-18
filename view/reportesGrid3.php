
<script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
        //oculta el detalle de cada fila del reporte
        $('.oculta').hide();

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

    <tbody>
    <?php foreach ($view->planes as $plan) {?>
        <tr class="odd gradeA">
            <td style="background-color: #FFD699"><?php  echo $plan["PERIODO"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["NOMBRE"];  ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["CANTIDAD"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["DURACION"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["UNIDAD"]; ?></td>
            <td style="background-color: #FFD699">$ <?php  echo $plan["UNITARIO"]; ?></td>
            <td style="background-color: #FFD699">$ <?php  echo $plan["SUBTOTAL"]; $sub_total_general+=$plan["SUBTOTAL"]; ?></td>
            <td style="background-color: #FFD699">$ <?php  echo $plan["TOTAL"]; $total_general+=$plan["TOTAL"]; ?></td>
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
                        <th>Lugar trabajo</th>
                        <th>Viaticos</th>
                    </tr>

                    <?php

                    foreach ($repox as $repo) {?>
                        <tr class="odd gradeA">
                            <td style="width: 300px"><?php  echo $repo["APELLIDO"]; ?></td>
                            <td style="width: 70px"><?php  echo $repo["NOMBRE"]; ?></td>
                            <td style="width: 70px"><?php  echo $repo["LUGAR_TRABAJO"]; ?></td>
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
    <!--Muestra el total general -->
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><h6>$ <?php echo $sub_total_general; ?></h6></th>
        <th><h6>$ <?php echo $total_general; ?></h6></th>
    </tr>
    </tfoot>
</table>
