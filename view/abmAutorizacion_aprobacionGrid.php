<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                //{ "width": "70px", "targets": 0 },
                //{ "width": "70px", "targets": 1 },
                { "width": "240px", "targets": 2 },
                { "width": "240px", "targets": 3 }
            ]

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
            <!--<a href="javascript:void(0);" id="dialog_link">Agregar solicitud capacitación</a>-->
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>

                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Solicitó</th>
                    <th>Estado</th>
                    <th>Autor/Aprob</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Solicitó</th>
                    <th>Estado</th>
                    <th>Autor/Aprob</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cs as $sol) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $sol["FECHA_SOLICITUD"]; ?></td>
                        <td><?php  echo $sol["PERIODO"]; ?></td>
                        <td><?php  echo $sol["EMPLEADO_APELLIDO"]." ".$sol["EMPLEADO_NOMBRE"]; ?></td> <!-- apellido y nombre del empleado -->
                        <td><?php  echo $sol["SOLICITO_APELLIDO"].' '.$sol["SOLICITO_NOMBRE"]; ?></td> <!-- apellido y nombre de quien solicito-->
                        <td><?php  echo $sol["ESTADO"]; ?></td>
                        <td class="center"><a href="#" title="Autorizar / Aprobar" class="edit_link" id="<?php  echo $sol["ID_SOLICITUD"];  ?>"><img src="public/img/check-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>