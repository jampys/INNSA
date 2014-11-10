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
            $("#empleado").attr("readonly", false);
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
            <a href="#" id="toggle-list">Lista de Solicitudes de Capacitación</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar solicitud capacitación</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>

                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Solicitante</th>
                    <th>Editar</th>
                    <th>Eliminar</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Solicitante</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cs as $sol) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $sol["FECHA_SOLICITUD"]; ?></td>
                        <td><?php  echo $sol["PERIODO"]; ?></td>
                        <td><?php  echo $sol["APELLIDO"]." ".$sol["NOMBRE"]; ?></td>
                        <td><?php  echo $sol["APR_SOLICITO"]; ?></td>
                        <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $sol["ID_SOLICITUD"];  ?>">Editar</a></td>
                        <td class="cen  ter"><a href="">Eliminar</a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>