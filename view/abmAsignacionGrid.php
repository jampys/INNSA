<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "200px",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );


        // Dialog Link
        $('#dialog_link').click(function(){
            //globalOperacion=$(this).attr("media");
            globalOperacion='insert';
            $('#dialog').dialog('open');
            return false;
        });

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
                    <th>Empleado</th>
                    <th>Curso</th>
                    <th>Estado</th>
                    <th>Editar</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Empleado</th>
                    <th>Curso</th>
                    <th>Estado</th>
                    <th>Editar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->asignacion as $asig) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $asig["FECHA_SOLICITUD"]; ?></td>
                        <td><?php  echo $asig["APELLIDO"]." ".$asig["NOMBRE"];  ?></td>
                        <td><?php  echo $asig["NOMBRE_CURSO"]." ".$asig["FECHA_DESDE"]." ".$asig["MODALIDAD"]; ?></td>
                        <td><?php  echo $asig["ESTADO"]; ?></td>
                        <td class="center"><a href="" class="edit_link" id="<?php  echo $asig["ID_ASIGNACION"];  ?>">Editar</a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>