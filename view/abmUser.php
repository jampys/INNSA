<!doctype html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;

        function editar(id_usuario){
            //alert(id_usuario);

            $.ajax({
                url:"index.php",
                data:{"accion":"user","operacion":"update","id":id_usuario},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#login").val(datas[0]);
                    $("#password").val(datas[1]);
                    $("#fecha").val(datas[2]);
                    $("#perfil").val(datas[3]);
                    $("#estado").val(datas[4]);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            if($("#login").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un login");
                return false;
            }

            if($("#password").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un password");
                return false;
            }

            if($("#fecha").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar una fecha");
                return false;
            }

            if($("#perfil").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un perfil");
                return false;
            }

            if($("#estado").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la habilitacion");
                return false;
            }

            if(globalOperacion=="insert"){ //se va a guardar un usuario nuevo
                var url="http://localhost/INNSA/index.php";
                var data={"accion":"user","operacion":"insert","login":$("#login").val(),"password":$("#password").val(),"fecha":$("#fecha").val(), "perfil":$("#perfil").val(), "estado":$("#estado").val()};
            }
            else{ //se va a guardar un usuario editado
                var url="http://localhost/INNSA/index.php";
                var data={"accion":"user","operacion":"save", "id":globalId, "login":$("#login").val(),"password":$("#password").val(),"fecha":$("#fecha").val(), "perfil":$("#perfil").val(), "estado":$("#estado").val()};
            }

            $.ajax({
                url:url,
                data:data,
                contentType:"application/x-www-form-urlencoded",
                //dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#dialog").dialog("close");
                    //Agregado por dario para recargar grilla al modificar o insertar
                    self.parent.location.reload();

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }




        $(document).ready(function(){

            // menu superfish
            $('#navigationTop').superfish();


            // dataTable
            var uTable = $('#example').dataTable( {
                "sScrollY": 200,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers"
            } );
            $(window).bind('resize', function () {
                uTable.fnAdjustColumnSizing();
            } );



            // Dialog mensaje
            $('#dialog-msn').dialog({
                autoOpen: false,
                width: 300,
                modal:true,
                title:"Alerta",
                buttons: {
                    "Aceptar": function() {
                        $(this).dialog("close");
                    }

                },
                show: {
                    effect: "blind",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 500
                }
            });


            // Dialog
            $('#dialog').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Guardar": function() {
                        guardar();

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar el formulario
                        $(this).dialog("close");
                    }
                },
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
                //Agregado dario
                /*
               , close:function(){

                }

                ,open: function(){
                    alert(globalOperacion);
                    alert(globalId);
                }*/
                //fin agregado dario

            });

            // Dialog Link
            $('#dialog_link').click(function(){
                globalOperacion=$(this).attr("media");
                $('#dialog').dialog('open');
                return false;
            });

            //Agregado por dario para editar

            $('.edit_link').click(function(){
                globalOperacion=$(this).attr("media");
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');

                return false;
            });
            //Fin agregado

            // Datepicker
            $('#fecha').datepicker({
                inline: true
                ,dateFormat:"dd/mm/yy"
                ,disabled:true
            });
            $('#fecha').datepicker('setDate', 'today');


            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );

        });
    </script>

</head>


<body>

<div id="principal">

    <div class="container_16">

        <header>

            <div class="clear"></div>

            <div class="grid_16">

            </div>

        </header>

        <div class="grid_16">
            <div class="box">
                <h2>
                    <a href="#" id="toggle-list">Lista de Usuarios</a>
                </h2>


                <div class="block" id="list">
                    <a href="javascript:void(0);" id="dialog_link" media="insert">Agregar Usuario</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                        <tr>
                            <th>Login</th>
                            <th>Password</th>
                            <th>Fecha alta</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th width="12%">Editar</th>
                            <th width="12%">Eliminar</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Login</th>
                            <th>Password</th>
                            <th>Fecha alta</th>
                            <th>Perfil</th>
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
                                <td><?php  echo ($user["HABILITADO"]==1) ? 'HABILITADO' : 'DESHABILITADO'; ?></td>
                                <td class="center"><a href="" media="edit" class="edit_link" id="<?php  echo $user["ID_USUARIO"];  ?>">Editar</a></td>
                                <td class="center"><a href="">Eliminar</a></td>
                            </tr>
                        <?php }  ?>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>

    </div>

</div>

<!-- ui-dialog mensaje -->
<div id="dialog-msn">
    <p id="message"></p>
</div>

<!-- ui-dialog -->
<div id="dialog" >

    <div class="grid_7">
        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form" action="">
                    <fieldset>
                        <legend>Datos Registro</legend>
                        <div class="sixteen_column section">

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Login: </label>
                                    <input type="text" name="login" id="login"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Password: </label>
                                    <input type="text" name="password" id="password"/>
                                </div>
                            </div>

                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Fecha alta: </label>
                                    <input type="text" name="fecha" id="fecha">
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Perfil: </label>
                                    <select name="perfil" id="perfil">
                                        <option value="0">Ingrese un perfil</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Operador</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Habilitacion: </label>
                                    <select name="estado" id="estado">
                                        <option value="0">Ingrese un estado</option>
                                        <option value="1">Habilitado</option>
                                        <option value="2">Deshabilitado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>


    </div>

</div>





</body>
</html>