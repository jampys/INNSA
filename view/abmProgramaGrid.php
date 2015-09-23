<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
            /*"columnDefs": [
                { "width": "150px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "100px", "targets": 5 },
                { "width": "200px", "targets": 6 }
            ]*/
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );


        // Dialog Link
        $('#dialog_link').click(function(){
            //globalOperacion=$(this).attr("media");
            globalOperacion='insert';
            $('#dialog').dialog('open');

            //selecciona por defecto el año vigente
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
            <a href="#" id="toggle-list">Programas</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar programa</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Período</th>
                    <th>Tipo programa</th>
                    <th>Nro. programa</th>
                    <th>Estado</th>
                    <th>F. Ingreso</th>
                    <th>F. Evaluación</th>
                    <th>F. Preaprobación</th>
                    <th>F. Aprobación</th>
                    <th>Editar</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Período</th>
                    <th>Tipo programa</th>
                    <th>Nro. programa</th>
                    <th>Estado</th>
                    <th>F. Ingreso</th>
                    <th>F. Evaluación</th>
                    <th>F. Preaprobación</th>
                    <th>F. Aprobación</th>
                    <th>Editar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->programas as $pro) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $pro["PERIODO"]; ?></td>
                        <td><?php  echo $pro["TIPO_PROGRAMA"];  ?></td>
                        <td><?php  echo $pro["NRO_PROGRAMA"]; ?></td>
                        <td><?php  echo $pro["ESTADO"]; ?></td>
                        <td><?php  echo $pro["FECHA_INGRESO"]; ?></td>
                        <td><?php  echo $pro["FECHA_EVALUACION"]; ?></td>
                        <td><?php  echo $pro["FECHA_PREAPROBACION"]; ?></td>
                        <td><?php  echo $pro["FECHA_APROBACION"]; ?></td>
                        <td class="center"><a href="" class="edit_link" id="<?php  echo $pro["ID_PROYECTO"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>