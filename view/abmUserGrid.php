<script type="text/javascript" language="javascript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "sScrollY": 200,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers"
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
            <a href="#" id="toggle-list">Lista de Usuarios</a>
        </h2>


        <div class="block" id="list">
            <a href="javascript:void(0);" id="dialog_link">Agregar Usuario</a>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Login</th>
                    <th>Password</th>
                    <th>Fecha alta</th>
                    <th>Perfil</th>
                    <th>Empleado</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Login</th>
                    <th>Password</th>
                    <th>Fecha alta</th>
                    <th>Perfil</th>
                    <th>Empleado</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->usuarios as $user) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $user["LOGIN"];  ?></td>
                        <td><?php  echo $user["PASSWORD"]; ?></td>
                        <td><?php  echo $user["FECHA_ALTA"]; ?></td>
                        <td><?php  echo $user["PERFIL"]; ?></td>
                        <td><?php  echo $user["APELLIDO"]." ".$user["NOMBRE"]; ?></td>
                        <td><?php  echo ($user["HABILITADO"]==1) ? 'HABILITADO' : 'DESHABILITADO'; ?></td>
                        <td class="center"><a href="" class="edit_link" id="<?php  echo $user["ID_USUARIO"];  ?>">Editar</a></td>
                        <td class="center"><a href="">Eliminar</a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>