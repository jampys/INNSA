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
                            //"password":$("#password").val(),
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

            $(document).tooltip();

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
                    $("#empleado").prop('disabled', false);
                }

            });




            $('#password_clear').dialog({
                autoOpen: false,
                width: 400,
                modal:true,
                title:"Blanqueo de password",
                buttons: {
                    "Aceptar": function() {
                        //$("#form").submit();
                        //if($('#form_password_clear').valid()){
                            //alert('todo ok');

                            $.ajax({
                                url:"index.php",
                                data:{  "accion":"login",
                                        "operacion":"clear_pass_first",
                                        "id_usuario":globalId, //id_usuario
                                        "password": $('#pc_password').val()
                                },
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
                                    //$("#message").html("Registro actualizado en la BD");
                                    $("#message").html(datas['comment']);


                                },
                                type:"POST",
                                timeout:3000000,
                                crossdomain:true

                            });

                            $("#password_clear").dialog("close");
                        //}

                    },
                    "Cancelar": function() {
                        $("#form_password_clear")[0].reset(); //para limpiar el formulario
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

            });

            //ACA ESTABA EL DIALOG LINK. SE COLOCO EN abmUserGrid.php

            //Al hacer click en editar
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                $("#empleado").prop('disabled', true);

                return false;
            });


            $(document).on("click", ".password_link", function(){
                //globalOperacion=$(this).attr("media");
                //globalOperacion='edit';
                globalId=$(this).attr('id');
                //editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#password_clear').dialog('open');
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
                        data: { "term": request.term,
                                "accion":"user",
                                "operacion":"autocompletar_empleados_sin_user",
                                "user": globalId //id_usuario
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.APELLIDO+" "+item.NOMBRE,
                                    id: item.ID_EMPLEADO,
                                    n_legajo: item.N_LEGAJO,
                                    empresa: item.EMPRESA

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
                    $('#login').val(ui.item.empresa.substr(0,1)+ui.item.n_legajo);
                }
            });

            //llamada a funcion validar
            $.validar();
            //$.validar_clear_pass();


        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            /*lo pone en vacio, ya que por defecto es igual a hiddenn  (default: ":hidden"). Y asi evito que ignore el campo oculto http://jqueryvalidation.org/validate/ */
            ignore:"",
            rules: {
                /*login: {
                    required: true,
                    maxlength: 40,
                    //minlength: 3,
                    email: true,
                    remote: {
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            //login: function(){ return $("#login").val(); },
                            login: function(){ return (globalOperacion=='insert')? $("#login").val() : '' },
                            accion: "user",
                            operacion: "AvailableUser"
                        }
                    }

                }, */
                /*password: {
                    required: true,
                    maxlength: 20,
                    minlength: 3
                }, */
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
                /*login:{
                    required: "Ingrese un usuario",
                    remote: "El usuario ya existe, intente con otro",
                    email: "El usuario debe ser un e-mail"
                }, */
                //password: "Ingrese un password",
                perfil: "Seleccione un perfil",
                estado: "Seleccione un estado",
                empleado: "Seleccione un empleado",
                empleado_id: "Seleccione un empleado sugerido"
            }

        });


    };




    /*$.validar_clear_pass=function(){

        //validacion de formulario
        $('#form_password_clear').validate({
            rules: {
                pc_password: {
                    required: true,
                    maxlength: 20,
                    minlength: 3
                },
                pc_password_again: {
                    equalTo: "#pc_password"
                }
            },
            messages:{
                pc_password: "Ingrese un password (Máx 10 caracteres)",
                pc_password_again: "Reingrese el password"
            }

        });

    }; */

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

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form" action="">
                    <fieldset>
                        <legend>Datos Registro</legend>

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
                                    <!--<label>Password: </label>
                                    <input type="text" name="password" id="password"/>-->
                                </div>
                            </div>

                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Login: </label>
                                    <input type="text" name="login" id="login" readonly/>
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
                                    <label>Perfil:<img src="public/img/information-icon.png" width="12px" height="12px" title="
                                    Dirección: Aprobar solicitud<br/>
                                    RRHH: Personal de recursos humanos<br/>
                                    Referente: Crear solicitud de capacitación<br/>
                                    Empleado: Visualizar sus planes de capacitación
                                    "></label>
                                    <select name="perfil" id="perfil">
                                        <option value="">Ingrese un perfil</option>
                                        <!--<option value="1">Administrador</option>
                                        <option value="2">Operador</option>-->
                                        <option value="1">Dirección</option>
                                        <option value="2">RRHH</option>
                                        <option value="3">Referente</option>
                                        <option value="4">Empleado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Habilitacion: </label>
                                    <select name="estado" id="estado">
                                        <option value="">Ingrese un estado</option>
                                        <option value="1" selected>Habilitado</option>
                                        <option value="2">Inhabilitado</option>
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



<!-- dialog para cambio de password -->
<div id="password_clear">

    <div class="grid_7">
        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form_password_clear" action="index.php" method="post">
                    <fieldset>
                        <legend>Blanqueo de password</legend>

                        <!--<div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Ingrese password: </label>
                                    <input type="password" name="pc_password" id="pc_password"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Reingrese password: </label>
                                    <input type="password" name="pc_password_again" id="pc_password_again"/>
                                    <input type="hidden" name="operacion" value='clear_pass' />
                                    <input type="hidden" name="id_usuario" value='<?php echo $view->id_usuario; ?>' />
                                </div>
                            </div>
                        </div> -->

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>¿Desea blanquear el password?</label>
                                    <br/>
                                    <span>* Se enviará un nuevo password por email al empleado</span>
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