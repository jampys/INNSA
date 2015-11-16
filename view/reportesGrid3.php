
<script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
        //oculta el detalle de cada fila del reporte
        $('.oculta').hide();

    });

</script>


<!--<table cellpadding="0" cellspacing="0" style="width: 80%" class="display" id="reportes">-->
<table cellpadding="0" cellspacing="0" style="width: 97%" id="reportes">
    <thead>
    <tr>
        <th>Período</th>
        <th>Capacitación</th>
        <th><span title="Cantidad de colaboradores">Cant.</span></th>
        <th>F. desde</th>
        <th>F. hasta</th>
        <th>Caracter</th>
        <th>Precio unitario</th>
        <th>Subtotal s/viáticos (ARS)</th>
        <th>Total c/viáticos (ARS)</th>
        <th>Total reintegrable</th>
        <th>Total aprobado</th>
        <th>Aprobar individual</th>
        <th>Aprobar todos</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($view->planes as $plan) {?>
        <tr class="odd gradeA">
            <td style="background-color: #FFD699"><?php  echo $plan["PERIODO"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["OBJETIVO"];  ?></td>
            <td style="background-color: #FFD699; text-align: right"><?php  echo $plan["CANTIDAD"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["FECHA_DESDE"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["FECHA_HASTA"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["CARACTER"]; ?></td>
            <td style="background-color: #FFD699; text-align: right"><?php  echo Conexion::formatNumber($plan["PRECIO_UNITARIO"]); ?></td>
            <td style="background-color: #FFD699; text-align: right"><?php  echo Conexion::formatNumber($plan["SUBSVIATICOS"]); $sub_total_sin_viaticos+=$plan["SUBSVIATICOS"]; ?></td>
            <td style="background-color: #FFD699; text-align: right"><?php  echo Conexion::formatNumber($plan["TOTCVIATICOS"]); $total_con_viaticos+=$plan["TOTCVIATICOS"]; ?></td>
            <td style="background-color: #FFD699; text-align: right"><span title="<?php echo ($plan["PORCENTAJE_REINTEGRABLE"])? 'Porcentaje '.$plan["PORCENTAJE_REINTEGRABLE"].' %': ''; ?>"><?php  echo Conexion::formatNumber($plan["TOTAL_REINTEGRABLE"]); $total_reintegrable+=$plan["TOTAL_REINTEGRABLE"]; ?></span></td>
            <td style="background-color: #FFD699; text-align: right"><?php  echo Conexion::formatNumber($plan["TOTAL_APROBADO"]); $total_aprobado+=$plan["TOTAL_APROBADO"]; ?></td>
            <!--<td style="background-color: #FFD699; text-align: center" ><a href="#" title="Aprobar individual" class="<?php  echo ($plan["DIFERENCIA"]!=0)? 'aprobar_link' : 'link-desactivado';    ?>" id="<?php  echo $plan["ID_PLAN"];  ?>"><img src="public/img/check-icon.png" width="15px" height="15px"></a></td>
            <td style="background-color: #FFD699; text-align: center" class="center"><a href="#" title="Aprobar a todos" class="<?php  echo ($plan["DIFERENCIA"]!=0)? 'aprobar_todos_link' : 'link-desactivado';    ?>" id="<?php  echo $plan["ID_PLAN"];  ?>"><img src="public/img/check-icon.png" width="15px" height="15px"></a></td>-->
            <?php
            $hoy = time(); //o strtotime('now');
            $fecha_capacitacion = DateTime::createFromFormat('d/m/y', $plan['FECHA_DESDE']);
            $fecha_capacitacion = strtotime($fecha_capacitacion->format('y-m-d'));
            ?>
            <td style="background-color: #FFD699; text-align: center" ><a href="#" title="Aprobar individual" class="<?php  echo ( $fecha_capacitacion > $hoy )? 'aprobar_link' : 'link-desactivado';    ?>" id="<?php  echo $plan["ID_PLAN"];  ?>"><img src="public/img/check-icon.png" width="15px" height="15px"></a></td>
            <td style="background-color: #FFD699; text-align: center" class="center"><a href="#" title="Aprobar a todos" class="<?php  echo ($plan["DIFERENCIA"]!=0 && $fecha_capacitacion > $hoy)? 'aprobar_todos_link' : 'link-desactivado';    ?>" id="<?php  echo $plan["ID_PLAN"];  ?>"><img src="public/img/check-icon.png" width="15px" height="15px"></a></td>
        </tr>
        <tr class="oculta">
            <td colspan="9">


                <?php
                require_once("model/cap_solicModel.php");
                $a=new Reportes();
                $repox=$a->getEmpleadosByPlan($lugar_trabajo, $plan["ID_PLAN"]);
                if(isset($repox)){

                ?>

                <table border="1" style="width: 80%">
                    <tr>
                        <th style="width: 20%">Apellido</th>
                        <th style="width: 20%">Nombre</th>
                        <th style="width: 15%">Lugar trabajo</th>
                        <th style="width: 10%">Viáticos</th>
                        <th style="width: 20%">Programa</th>
                        <th style="width: 15%">Aprobado</th>
                    </tr>

                    <?php

                    foreach ($repox as $repo) {?>
                        <tr class="odd gradeA">
                            <td><?php  echo $repo["APELLIDO"]; ?></td>
                            <td><?php  echo $repo["NOMBRE"]; ?></td>
                            <td><?php  echo $repo["LUGAR_TRABAJO"]; ?></td>
                            <td style="text-align: right"><?php  echo Conexion::formatNumber($repo["VIATICOS"]);  ?></td>
                            <td><?php  echo ($repo["PROGRAMA"]==1)? $plan["TIPO_PROGRAMA"] : '';  ?></td>
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
    <!--<tr>
        <th>Período</th>
        <th>Capacitación</th>
        <th>Cant. recursos</th>
        <th>Duración</th>
        <th>Unidad</th>
        <th>Caracter</th>
        <th>Precio unitario</th>
        <th>Subtotal s/viáticos (pesos)</th>
        <th>Total c/viáticos (pesos)</th>
        <th>Aprobar individual</th>
        <th>Aprobar todos</th>
    </tr>
    <!--Muestra el total general-->
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th style="text-align: right"><h6><?php echo Conexion::formatNumber($sub_total_sin_viaticos); ?></h6></th>
        <th style="text-align: right"><h6><?php echo Conexion::formatNumber($total_con_viaticos); ?></h6></th>
        <th style="text-align: right"><h6><?php echo Conexion::formatNumber($total_reintegrable); ?></h6></th>
        <th style="text-align: right"><h6><?php echo Conexion::formatNumber($total_aprobado); ?></h6></th>
        <th></th>
        <th></th>
    </tr>
    </tfoot>
</table>
