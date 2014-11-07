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

                    $("#login").val(datas[0]['LOGIN']);
                    $("#password").val(datas[0]['PASSWORD']);
                    $("#fecha").val(datas[0]['FECHA_ALTA']);
                    $("#perfil").val(datas[0]['ID_PERFIL']);
                    $("#estado").val(datas[0]['HABILITADO']);
                    $("#empleado").val(datas[0]['APELLIDO']+" "+datas[0]['NOMBRE']);
                    $("#empleado_id").val(datas[0]['ID_EMPLEADO']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            if(globalOperacion=="insert"){ //se va a guardar un usuario nuevo
                var url="index.php";
                var data={  "accion":"user",
                            "operacion":"insert",
                            "login":$("#login").val(),
                            "password":$("#password").val(),
                            "fecha":$("#fecha").val(),
                            "perfil":$("#perfil").val(),
                            "estado":$("#estado").val(),
                            "empleado":$("#empleado_id").val()
                        };
            }
            else{ //se va a guardar un usuario editado
                var url="index.php";
                var data={  "accion":"user",
                            "operacion":"save",
                            "id":globalId,
                            "login":$("#login").val(),
                            "password":$("#password").val(),
                            "fecha":$("#fecha").val(),
                            "perfil":$("#perfil").val(),
                            "estado":$("#estado").val(),
                            "empleado":$("#empleado_id").val()
                        };
            }

            $.ajax({
                url:url,
                data:data,
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("Registro actualizado en la BD");

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }




        $(document).ready(function(){

            // menu superfish
            $('#navigationTop').superfish();


            //Aqui se cargaban el dataTable


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


            // Dialog para insert y edit
            $('#dialog').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title: "Registro de usuarios",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"user", operacion: "refreshGrid"});
                        }

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar los campos del formulario
                        $('#form').validate().resetForm(); //para limpiar los errores validate
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
                },
                close:function(){
                    $("#form")[0].reset(); //para limpiar los campos del formulario cuando sale con la x
                    $('#form').validate().resetForm(); //para limpiar los errores validate
                }

            });

            //ACA ESTABA EL DIALOG LINK. SE COLOCO EN abmUserGrid.php

            //Al hacer click en editar
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                return false;
            });

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


            //Agregado dario para autocompletar empleados
            $("#empleado").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"user", "operacion":"autocompletar_empleados_sin_user"},
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.APELLIDO+" "+item.NOMBRE,
                                    id: item.ID_EMPLEADO

                                };
                            }));
                        }
                    });
                },
                delay: 0,
                minLength: 2,
                change: function(event, ui) {
                    $('#empleado_id').val(ui.item? ui.item.id : '');
                    $('#empleado').val(ui.item.label);
                }
            });
            //fin agregado

            //llamada a funcion validar
            $.validar();


        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            ignore:"",
            rules: {
                login: {
                    required: true,
                    maxlength: 20,
                    minlength: 3
                },
                password: {
                    required: true,
                    maxlength: 20,
                    minlength: 3
                },
                perfil: {
                    required: true
                },
                estado: {
                    required: true
                },
                empleado:{
                    required: true
                },
                empleado_id:{
                    required: function(item){return $('#empleado').val().length>0;}
                }
            },
            messages:{
                login: "Ingrese un login",
                password: "Ingrese un password",
                perfil: "Seleccione un perfil",
                estado: "Seleccione un estado",
                empleado: "Seleccione un empleado",
                empleado_id: "Seleccione un empleado sugerido"
            }

        });


    };

    </script>

</head>


<body>

<div id="principal">

<!-- Llamada al archivo abmUserGrid.php -->
    <?php require_once('abmUserGrid.php');?>

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
                                    <label>Empleado: </label>
                                    <input type="text" name="empleado" id="empleado"/>
                                    <input type="hidden" name="empleado_id" id="empleado_id"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Fecha alta: </label>
                                    <input type="text" name="fecha" id="fecha">
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Perfil: </label>
                                    <select name="perfil" id="perfil">
                                        <option value="">Ingrese un perfil</option>
                                        <option value="1">Administrador</option>
                                        <option value="2">Operador</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Habilitacion: </label>
                                    <select name="estado" id="estado">
                                        <option value="">Ingrese un estado</option>
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