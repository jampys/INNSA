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
                { "width": "150px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "150px", "targets": 5 },
                { "width": "150px", "targets": 6 }
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
            <a href="#" id="toggle-list">Lista de Empleados</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar Empleado</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Lugar</th>
                    <th>Legajo</th>
                    <th>Empresa</th>
                    <th>Función</th>
                    <th>Categoria</th>
                    <th>División</th>
                    <th>Editar</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Lugar</th>
                    <th>Legajo</th>
                    <th>Empresa</th>
                    <th>Función</th>
                    <th>Categoria</th>
                    <th>División</th>
                    <th>Editar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->empleados as $emp) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $emp["APELLIDO"]; ?></td>
                        <td><?php  echo $emp["NOMBRE"];  ?></td>
                        <td><?php  echo $emp["LUGAR_TRABAJO"]; ?></td>
                        <td><?php  echo $emp["N_LEGAJO"]; ?></td>
                        <td><?php  echo $emp["EMPRESA"]; ?></td>
                        <td><?php  echo $emp["FUNCION"]; ?></td>
                        <td><?php  echo $emp["CATEGORIA"]; ?></td>
                        <td><?php  echo $emp["DIVISION"]; ?></td>
                        <td class="center"><a href="" class="edit_link" id="<?php  echo $emp["ID_EMPLEADO"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>