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
                { "width": "120px", "targets": 0 },
                { "width": "120px", "targets": 1 },
                { "width": "200px", "targets": 3 }
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );



    });

</script>




            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Lugar</th>
                    <th>Capacitación</th>
                    <th>Período</th>
                    <th>Fecha</th>
                    <th>Tema</th>
                    <th>Categoría</th>
                    <th>Modalidad</th>
                    <th>Entidad</th>
                    <th>Tipo Act.</th>
                </tr>
                </thead>
                <!--<tfoot>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Lugar</th>
                    <th>Curso</th>
                    <th>Período</th>
                    <th>Fecha</th>
                    <th>Tema</th>
                    <th>Categoría</th>
                    <th>Modalidad</th>
                    <th>Entidad</th>
                    <th>Tipo Act.</th>
                </tr>
                </tfoot>-->
                <tbody>
                <?php if (isset($view->busqueda)){foreach ($view->busqueda as $emp) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $emp["APELLIDO"]; ?></td>
                        <td><?php  echo $emp["NOMBRE"];  ?></td>
                        <td><?php  echo $emp["LUGAR_TRABAJO"]; ?></td>
                        <td><?php  echo $emp["CAPACITACION"]; ?></td>
                        <td><?php  echo $emp["PERIODO"]; ?></td>
                        <td><?php  echo $emp["FECHA_DESDE"]; ?></td>
                        <td><?php  echo $emp["TEMA"]; ?></td>
                        <td><?php  echo $emp["CATEGORIA"]; ?></td>
                        <td><?php  echo $emp["MODALIDAD"]; ?></td>
                        <td><?php  echo $emp["ENTIDAD"]; ?></td>
                        <td><?php  echo $emp["TIPO_CURSO"]; ?></td>
                    </tr>
                <?php }}  ?>

                </tbody>
            </table>






