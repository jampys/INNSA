
<script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
        //oculta el detalle de cada fila del reporte
        $('.oculta').hide();

    });

</script>


<!--<table cellpadding="0" cellspacing="0" style="width: 80%" class="display" id="reportes">-->
<table cellpadding="0" cellspacing="0" style="width: 80%" id="reportes">
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
        <th>Aprobar</th>
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
            <td style="background-color: #FFD699" class="center"><a href="#" title="Aprobar" class="aprobar_link" id="<?php  echo $plan["ID_PLAN"];  ?>"><img src="public/img/check-icon.png" width="15px" height="15px"></a></td>
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
                        <th style="width: 25%">Apellido</th>
                        <th style="width: 25%">Nombre</th>
                        <th style="width: 15%">Lugar trabajo</th>
                        <th style="width: 20%">Viaticos</th>
                        <th style="width: 15%">Aprobado</th>
                    </tr>

                    <?php

                    foreach ($repox as $repo) {?>
                        <tr class="odd gradeA">
                            <td><?php  echo $repo["APELLIDO"]; ?></td>
                            <td><?php  echo $repo["NOMBRE"]; ?></td>
                            <td><?php  echo $repo["LUGAR_TRABAJO"]; ?></td>
                            <td><?php  echo $repo["VIATICOS"];  ?></td>
                            <td class="center"><a href="javascript: void(0);" class="<?php echo $repo['APROBADA']==0? 'link-invisible': '' ?>" ><img title="<?php echo $repo['APROBADA']==0? 'No aprobada': 'Aprobada' ?>" src="public/img/Ok-icon.png" width="15px" height="15px"></a></td>
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
        <th>Aprobar</th>
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
        <th></th>
    </tr>
    </tfoot>
</table>
