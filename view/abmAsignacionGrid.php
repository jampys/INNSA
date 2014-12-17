<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        $(document).tooltip();

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "200px",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "60px", "targets": 0 },
                { "width": "60px", "targets": 1 },
                { "width": "240px", "targets": 2 },
                { "width": "350px", "targets": 3 }
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
            <a href="#" id="toggle-list">Lista de Asignaciones</a>
        </h2>


        <div class="block" id="list">
            <!-- <a href="javascript:void(0);" id="dialog_link">Agregar Empleado</a> -->
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Curso</th>
                    <th>Fecha inicio</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Comunic.</th>
                    <th>Evaluac.</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Curso</th>
                    <th>Fecha inicio</th>
                    <th>Modalidad</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Comunic.</th>
                    <th>Evaluac.</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->asignacion as $asig) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $asig["FECHA_SOLICITUD"]; ?></td>
                        <td><?php  echo $asig["PERIODO"]; ?></td>
                        <td><?php  echo $asig["APELLIDO"]." ".$asig["NOMBRE"];  ?></td>
                        <td><?php  echo $asig["NOMBRE_CURSO"]; ?></td>
                        <td><?php  echo $asig["FECHA_DESDE"]; ?></td>
                        <td><?php  echo $asig["MODALIDAD"]; ?></td>
                        <td><?php  echo $asig["ESTADO"]; ?></td>
                        <td class="center"><a href="#" title="Edición" class="edit_link" id="<?php  echo $asig["ID_ASIGNACION"];  ?>"><img src="public/img/state-icon.png" width="14px" height="14px"></a></td>
                        <td class="center"><a href="#" title="Comunicación" class="<?php echo ($asig["ESTADO"]=='CANCELADO'||$asig["ESTADO"]=='SUSPENDIDO' ||$asig["ESTADO_SOLICITUD"]!='APROBADA')? 'link-desactivado' : 'comunicacion_link' ?>" id="<?php  echo $asig["ID_ASIGNACION"];  ?>"><img src="public/img/Communication-icon.png" width="15px" height="15px"></a></td>
                        <td class="center"><a href="#" title="Evaluación" class="<?php echo ($asig["ESTADO"]!='EVALUADO' /*&& $asig["ESTADO"]!='POST-EVALUADO'*/ )? 'link-desactivado' : 'evaluacion_link' ?>" id="<?php  echo $asig["ID_ASIGNACION"];  ?>"><img src="public/img/tests-icon.png" width="15px" height="15px"></a></td>                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>