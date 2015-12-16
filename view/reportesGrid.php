
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
        <th>Fecha de solicitud</th>
        <th>Colaborador</th>
        <th>Lugar de trabajo</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Período</th>
        <th>Fecha de solicitud</th>
        <th>Colaborador</th>
        <th>Lugar de trabajo</th>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($view->solicitud as $sol) {?>
        <tr class="odd gradeA">
            <td style="background-color: #FFD699"><?php  echo $sol["PERIODO"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $sol["FECHA_SOLICITUD"];  ?></td>
            <td style="background-color: #FFD699"><?php  echo $sol["EMPLEADO_APELLIDO"].' '.$sol['EMPLEADO_NOMBRE']; ?></td>
            <td style="background-color: #FFD699"><?php  echo $sol["LUGAR_TRABAJO"]; ?></td>

        </tr>
        <tr class="oculta">
            <td colspan="4">



                <?php
                require_once("model/cap_solicModel.php");
                $a=new Asignacion_plan();
                $asignacion=$a->getAsignacionPlanBySolicitud($sol["ID_SOLICITUD"]);
                if(isset($asignacion)){

                ?>

                <table border="1">
                    <tr>
                        <th>Capacitación</th>
                        <th>Modalidad</th>
                        <th>Fecha inicio</th>
                        <th>Estado</th>
                        <th>Comunic</th>
                        <th>Nofif</th>
                        <th>Eval</th>
                        <th>P. Eval</th>
                    </tr>

                    <?php

                    foreach ($asignacion as $sol) {?>
                        <tr class="odd gradeA">
                            <td style="width: 300px"><?php  echo $sol["OBJETIVO"]; ?></td>
                            <td style="width: 70px"><?php  echo $sol["MODALIDAD"]; ?></td>
                            <td style="width: 50px"><?php  echo $sol["FECHA_DESDE"];  ?></td>
                            <td style="width: 100px"><?php  echo $sol["ESTADO"]; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["NRO_ORDEN"]>=3)? '<img src="public/img/Ok-icon.png" width="14px" height="14px">': ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["NRO_ORDEN"]>=4)? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["NRO_ORDEN"]>=5)? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["NRO_ORDEN"]>=6)? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>

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