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
        $('#division_new_link').click(function(){
            globalOperacion='division_insert';
            $('#division').dialog('open');
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
            <a href="#" id="toggle-list">Lista de Divisiones</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="division_new_link">Agregar División</a>
            <table cellpadding="0" cellspacing="0" border="0" id="example" style="width: 700px">
                <thead>
                <tr>
                    <th style="width: 75%">Nombre</th>
                    <th style="width: 15%">Estado</th>
                    <th style="width: 10%">Editar</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Editar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->divisiones as $div) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $div["NOMBRE"]; ?></td>
                        <td><?php  echo $div["ESTADO"]; ?></td>
                        <td class="center" style="text-align: center"><a href="" class="division_edit_link" id="<?php  echo $div["ID_DIVISION"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>