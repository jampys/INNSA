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

            //codigo para setear automaticamente el apr_solicito
            $.ajax({
                url: "index.php",
                data: {"accion":"empleado", "operacion":"getEmpleadoBySession"},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#apr_solicito").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                    $("#apr_solicito_id").val(datas[0]['ID_EMPLEADO']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });
            //fin codigo

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
                    <th>Solicitó</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <!--<th>Eliminar</th>-->

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Periodo</th>
                    <th>Empleado</th>
                    <th>Solicitó</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <!--<th>Eliminar</th>-->
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
                        <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $sol["ID_SOLICITUD"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                        <!--<td class="center"><a href="">Eliminar</a></td>-->
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>