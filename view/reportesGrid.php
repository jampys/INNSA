<table cellpadding="0" cellspacing="0" width="100%" class="display" id="nada">
    <thead>
    <tr>
        <th>Periodo</th>
        <th>Fecha_solicitud</th>
        <th>Empleado</th>
        <th>Lugar trabajo</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Periodo</th>
        <th>Fecha_solicitud</th>
        <th>Empleado</th>
        <th>Lugar trabajo</th>
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
        <tr>
            <td colspan="4">



                <?php
                require_once("model/cap_solicModel.php");
                $a=new Asignacion_plan();
                $asignacion=$a->getAsignacionPlanBySolicitud($sol["ID_SOLICITUD"]);
                if(isset($asignacion)){

                ?>

                <table border="1">
                    <tr>
                        <th>Curso</th>
                        <th>Modalidad</th>
                        <th>Fecha inicio</th>
                        <th>Estado</th>
                        <th>Comunic</th>
                        <th>Nofif</th>
                        <th>Eval</th>
                    </tr>

                    <?php

                    foreach ($asignacion as $sol) {?>
                        <tr class="odd gradeA">
                            <td style="width: 300px"><?php  echo $sol["NOMBRE"]; ?></td>
                            <td style="width: 70px"><?php  echo $sol["MODALIDAD"]; ?></td>
                            <td style="width: 50px"><?php  echo $sol["FECHA_DESDE"];  ?></td>
                            <td style="width: 100px"><?php  echo $sol["ESTADO"]; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["ESTADO"]=='COMUNICADO' || $sol["ESTADO"]=='NOTIFICADO' || $sol["ESTADO"]=='EVALUADO')? '<img src="public/img/Ok-icon.png" width="15px" height="15px">': ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["ESTADO"]=='NOTIFICADO' || $sol["ESTADO"]=='EVALUADO')? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["ESTADO"]=='EVALUADO')? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>



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