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
                { "width": "350px", "targets": 0 }
            ],
            "order": []
        } );

        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );


        // Dialog Link
        $('#dialog_link').click(function(){
            //globalOperacion=$(this).attr("media");
            globalOperacion='insert';
            $('#dialog').dialog('open');
            //$("#curso").attr("readonly", false);


            //Rellenar el combo de periodos
            var per=$.periodos();
            $("#periodo").html('<option value="">Seleccione un período</option>');
            $.each(per, function(indice, val){
                $("#periodo").append(new Option(val,val));
            });

            //Despues de cargar el combo de periodos, selecciona por defecto el año vigente
            $("#periodo option[value="+new Date().getFullYear()+"]").prop('selected', true);

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
            <a href="#" id="toggle-list">Capacitaciones</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar capacitación</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Período</th>
                    <th>Entidad</th>
                    <th title="Cant. de colaboradores asignados">Cant.</th>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Duración</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Importe</th>
                    <th>Moneda</th>
                    <th>.</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Curso</th>
                    <th>Período</th>
                    <th>Entidad</th>
                    <th>Cant.</th>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Duración</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Importe</th>
                    <th>Moneda</th>
                    <th>.</th>

                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cp as $plan) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo Conexion::corta_palabra($plan["NOMBRE"], 40);  ?></td>
                        <td><?php  echo $plan["PERIODO"] ?></td>
                        <td><?php  echo $plan["ENTIDAD"] ?></td>
                        <td><?php  echo $plan["CANTIDAD"]; ?></td>
                        <td><?php  echo $plan["FECHA_DESDE"]; ?></td>
                        <td><?php  echo $plan["FECHA_HASTA"]; ?></td>
                        <td><?php  echo $plan["DURACION"]; ?></td>
                        <td><?php  echo $plan["UNIDAD"]; ?></td>
                        <td><?php  echo $plan["ESTADO"]; ?></td>
                        <td><?php  echo $plan["IMPORTE"]; ?></td>
                        <td><?php  echo $plan["MONEDA"]; ?></td>

                        <?php if($plan['PERIODO']!=date('Y')){ ?>

                            <td class="center"><a href="javascript: void(0);" class="view_link" id="<?php  echo $plan["ID_PLAN"];  ?>" target="<?php  echo $plan["PERIODO"];  ?>" ><img title="Ver" src="public/img/search-icon.png" width="15px" height="15px"></a></td>

                        <?php }else{ ?>
                            <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $plan["ID_PLAN"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                        <?php } ?>


                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>