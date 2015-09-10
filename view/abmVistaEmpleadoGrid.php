<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
            //"scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "50px", "targets": 0 },
                { "width": "350px", "targets": 1 },
                { "width": "80px", "targets": 2 },
                { "width": "80px", "targets": 3 },
                { "width": "90px", "targets": 4 }
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );


    });

</script>




<div class="container_10">

    <header>

        <div class="clear"></div>


    </header>

    <div class="box">
        <h2>
            <a href="#" id="toggle-list">Capacitaciones de <?php echo $_SESSION['USER_APELLIDO'].' '.$_SESSION['USER_NOMBRE']; ?></a>
        </h2>


        <div class="block" id="list">
            <!-- <a href="javascript:void(0);" id="dialog_link">Agregar Empleado</a> -->
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Período</th>
                    <th>Capacitación</th>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Duración</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Comunic.</th>
                    <th>Evaluación</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Período</th>
                    <th>Capacitación</th>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Duración</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Comunic.</th>
                    <th>Evaluación</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->asignacion as $asig) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $asig["PERIODO"]; ?></td>
                        <td><?php  echo $asig["NOMBRE_CURSO"]; ?></td>
                        <td><?php  echo $asig["FECHA_DESDE"]; ?></td>
                        <td><?php  echo $asig["FECHA_HASTA"]; ?></td>
                        <td><?php  echo $asig["DURACION"].' '.$asig["UNIDAD"]; ?></td>
                        <td><?php  echo $asig["MODALIDAD"]; ?></td>
                        <td><?php  echo $asig["ESTADO"]; ?></td>
                        <td class="center"><a href="#" title="Edición" class="edit_link" id="<?php  echo $asig["ID_ASIGNACION"];  ?>"><img src="public/img/state-icon.png" width="14px" height="14px"></a></td>
                        <td class="center"><a href="#" title="Comunicación" class="<?php echo ($asig["ESTADO"]=='ASIGNADO' ||$asig["ESTADO"]=='SUSPENDIDO')? 'link-desactivado' : 'comunicacion_link' ?>" id="<?php  echo $asig["ID_ASIGNACION"];  ?>"><img src="public/img/Communication-icon.png" width="15px" height="15px"></a></td>
                        <td class="center"><a href="#" title="Evaluación" class="<?php echo ($asig["ESTADO"]=='ASIGNADO' ||$asig["ESTADO"]=='SUSPENDIDO' || $asig["ESTADO"]=='CANCELADO' || $asig["ESTADO"]=='COMUNICADO' )? 'link-desactivado' : 'evaluacion_link' ?>" id="<?php  echo $asig["ID_ASIGNACION"];  ?>"><img src="public/img/tests-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>