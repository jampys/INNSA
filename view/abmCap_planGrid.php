<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "200px",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "350px", "targets": 0 }
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
            $("#curso").attr("readonly", false);
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
            <a href="#" id="toggle-list">Lista de Planes de Capacitación</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar plan capacitación</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Curso</th>
                    <th>Periodo</th>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Duracion</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Importe</th>
                    <th>Moneda</th>
                    <th>Cant.</th>
                    <th>Editar</th>
                    <th>Eliminar</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Curso</th>
                    <th>Periodo</th>
                    <th>Fecha desde</th>
                    <th>Fecha hasta</th>
                    <th>Duracion</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Importe</th>
                    <th>Moneda</th>
                    <th>Cant.</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cp as $plan) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo Conexion::corta_palabra($plan["NOMBRE"], 40);  ?></td>
                        <td><?php  echo $plan["PERIODO"] ?></td>
                        <td><?php  echo $plan["FECHA_DESDE"]; ?></td>
                        <td><?php  echo $plan["FECHA_HASTA"]; ?></td>
                        <td><?php  echo $plan["DURACION"]; ?></td>
                        <td><?php  echo $plan["UNIDAD"]; ?></td>
                        <td><?php  echo $plan["ESTADO"]; ?></td>
                        <td><?php  echo $plan["IMPORTE"]; ?></td>
                        <td><?php  echo $plan["MONEDA"]; ?></td>
                        <td><?php  echo $plan["CANTIDAD"]; ?></td>
                        <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $plan["ID_PLAN"];  ?>">Editar</a></td>
                        <td class="cen  ter"><a href="">Eliminar</a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>