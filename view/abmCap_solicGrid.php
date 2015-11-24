<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
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

            globalOperacion='insert';
            $('#dialog').dialog('open');
            $("#empleado").attr("readonly", false);

            //Rellenar el combo de periodos
            var per=$.periodos();
            $("#periodo").html('<option value="">Seleccione un periodo</option>');
            $.each(per, function(indice, val){
                $("#periodo").append(new Option(val,val));
            });

            $("#periodo option[value="+new Date().getFullYear()+"]").prop('selected', true);

            //codigo para setear automaticamente el apr_solicito
            /*
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
            */

            $("#apr_solicito").val('<?php echo $_SESSION['USER_APELLIDO']." ".$_SESSION['USER_NOMBRE']; ?>');
            $("#apr_solicito_id").val('<?php echo $_SESSION['USER_ID_EMPLEADO']; ?>');
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
            <a href="#" id="toggle-list">Solicitudes de Capacitación</a>
        </h2>


        <div class="block" id="list">


            <a href="javascript:void(0);" id="dialog_link">Agregar solicitud capacitación</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>

                    <th>Fecha solicitud</th>
                    <th>Período</th>
                    <th>Colaborador</th>
                    <th>Solicitó</th>
                    <th>Estado</th>
                    <th>.</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Fecha solicitud</th>
                    <th>Período</th>
                    <th>Colaborador</th>
                    <th>Solicitó</th>
                    <th>Estado</th>
                    <th>.</th>

                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cs as $sol) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $sol["FECHA_SOLICITUD"]; ?></td>
                        <td><?php  echo $sol["PERIODO"]; ?></td>
                        <td><?php  echo $sol["EMPLEADO_APELLIDO"]." ".$sol["EMPLEADO_NOMBRE"]; ?></td> <!-- apellido y nombre del empleado -->
                        <td><?php  echo $sol["SOLICITO_APELLIDO"].' '.$sol["SOLICITO_NOMBRE"]; ?></td> <!-- apellido y nombre de quien solicito-->
                        <td><?php  echo ($sol["PERIODO"]== date('Y'))? 'ABIERTA': 'CERRADA' ?></td>
                        <?php if($sol['PERIODO'] < date('Y')){ ?>

                            <td class="center"><a href="javascript: void(0);" class="view_link" id="<?php  echo $sol["ID_SOLICITUD"];  ?>" target="<?php  echo $sol["PERIODO"];  ?>" ><img title="Ver" src="public/img/search-icon.png" width="15px" height="15px"></a></td>

                        <?php }else{ ?>
                            <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $sol["ID_SOLICITUD"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                        <?php } ?>


                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>