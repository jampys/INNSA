<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        /* dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "150px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "200px", "targets": 5 },
                { "width": "100px", "targets": 6 }
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } ); */


        // Dialog Link
        $('#dialog_link').click(function(){
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

    <div class="box" style="width: 700px">
        <h2>
            <a href="#" id="toggle-list">Lista de Categorías</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar Categoría</a>
            <table cellpadding="0" cellspacing="0" border="0" id="example" style="width: 700px">
                <thead>
                <tr>
                    <th style="width: 30%">Nombre</th>
                    <th style="width: 45%">Descripción</th>
                    <th style="width: 15%">Estado</th>
                    <th style="width: 10%">Editar</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Editar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->categorias as $cat) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $cat["NOMBRE"]; ?></td>
                        <td><?php  echo $cat["DESCRIPCION"];  ?></td>
                        <td><?php  echo $cat["ESTADO"]; ?></td>
                        <td class="center" style="text-align: center"><a href="" class="categoria_edit_link" id="<?php  echo $cat["ID_CATEGORIA"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>