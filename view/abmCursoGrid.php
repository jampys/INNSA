<script type="text/javascript" language="javascript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "200px",
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "50%", "targets": 0 }
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







<div class="container_16">

    <header>

        <div class="clear"></div>


    </header>


    <div class="box">
        <h2>
            <a href="#" id="toggle-list">Lista de Cursos</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar Curso</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Tema</th>
                    <th>Editar</th>
                    <th>Eliminar</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Tema</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cursos as $curso) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo Conexion::corta_palabra($curso["NOMBRE_CURSO"], 55);  ?></td>
                        <!--<td><?php  echo Conexion::corta_palabra($curso["DESCRIPCION"], 35); ?></td>-->
                        <td><?php  echo $curso["NOMBRE_CATEGORIA"]; ?></td>
                        <td><?php  echo $curso["NOMBRE_TEMA"]; ?></td>
                        <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $curso["ID_CURSO"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                        <td class="center"><a href="javascript: void(0);" class="delete_link" id="<?php  echo $curso["ID_CURSO"];  ?>"><img title="Eliminar" src="public/img/delete-icon.png" width="15px" height="15px"></a></td>
                        <!--<td class="center"><a href="">Eliminar</a></td>-->
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>