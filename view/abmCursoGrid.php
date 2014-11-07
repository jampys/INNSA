<script type="text/javascript" language="javascript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "200px",
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "35%", "targets": 0 }
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
                    <th>Descripcion</th>
                    <th>Entidad</th>
                    <th>Editar</th>
                    <th>Eliminar</th>

                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Entidad</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->cursos as $curso) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo Conexion::corta_palabra($curso["NOMBRE"], 35);  ?></td>
                        <td><?php  echo Conexion::corta_palabra($curso["DESCRIPCION"], 35); ?></td>
                        <td><?php  echo $curso["ENTIDAD"]; ?></td>
                        <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $curso["ID_CURSO"];  ?>">Editar</a></td>
                        <td class="center"><a href="">Eliminar</a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>