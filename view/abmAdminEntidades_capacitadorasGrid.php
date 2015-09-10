<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        //dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "150px", "targets": 0 }
                /*{ "width": "50px", "targets": 1 },
                { "width": "50px", "targets": 2 }*/
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );


        // Dialog Link
        $('#entidad_new_link').click(function(){
            globalOperacion='entidad_insert';
            $('#entidad').dialog('open');
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
            <a href="#" id="toggle-list">Entidades Capacitadoras</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="entidad_new_link">Agregar Entidad Capacitadora</a>
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
                <?php foreach ($view->entidadesCapacitadoras as $ec) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $ec["NOMBRE"]; ?></td>
                        <td><?php  echo $ec["ESTADO"]; ?></td>
                        <td class="center" style="text-align: center"><a href="" class="entidad_edit_link" id="<?php  echo $ec["ID_ENTIDAD_CAPACITADORA"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>