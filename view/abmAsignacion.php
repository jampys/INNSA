<!doctype html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;

        function editar(id_asignacion){
            //alert(id_usuario);

            $.ajax({
                url:"index.php",
                data:{"accion":"asignacion","operacion":"update","id":id_asignacion},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#estado").val(datas[0]['ESTADO']);
                    $("#estado_cambio").val(datas[0]['ESTADO_CAMBIO']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }



    function editarComunicacion(id_asignacion){

        $.ajax({
            url:"index.php",
            data:{  "accion":"asignacion",
                    "operacion":"updateComunicacion",
                    "id":id_asignacion
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

                if(datas[0]){ //si la consulta trae algun registro
                    globalOperacion='updateComunicacion';
                    $("#comunicacion").data('id_comunicacion',datas[0]['ID_COMUNICACION']);
                    //console.log( $('#comunicacion').data('id_comunicacion'));
                    $("#situacion").val(datas[0]['SITUACION']);
                    $("#objetivos").val(datas[0]['OBJETIVOS']);
                    $("#indicadores_exito").val(datas[0]['INDICADORES_EXITO']);
                    $("#compromiso").val(datas[0]['COMPROMISO']);
                    $("#comunico").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                    $("#comunico_id").val(datas[0]['COMUNICO']);
                    $("#notificado").val((datas[0]['NOTIFICADO']==1)? 'NOTIFICADO':'NO NOTIFICADO');
                }
                else{
                    setComunicador();
                }




            },
            type:"POST",
            timeout:3000000,
            crossdomain:true

        });

    }


        function guardar(){

            if(globalOperacion=="edit"){ //Se cambia el estado de la asignacion

                var data={  "accion":"asignacion",
                            "operacion":"save",
                            "id":globalId,
                            "estado":$("#estado").val(),
                            "estado_cambio":$("#estado_cambio").val()
                        };
            }
            else if (globalOperacion=="insertComunicacion"){ //Se guarda la comunicacion

                var data={  "accion":"asignacion",
                            "operacion":"insertComunicacion",
                            "id":globalId, //id_asignacion
                            "situacion":$("#situacion").val(),
                            "objetivos":$("#objetivos").val(),
                            "indicadores_exito":$("#indicadores_exito").val(),
                            "compromiso":$("#compromiso").val(),
                            "comunico":$("#comunico_id").val()

                        };

            }
            else if(globalOperacion=="updateComunicacion"){

                var data={  "accion":"asignacion",
                            "operacion":"saveComunicacion",
                            //"id":globalId, //id_asignacion
                            "id_comunicacion": $('#comunicacion').data('id_comunicacion'),
                            "situacion":$("#situacion").val(),
                            "objetivos":$("#objetivos").val(),
                            "indicadores_exito":$("#indicadores_exito").val(),
                            "compromiso":$("#compromiso").val(),
                            "comunico":$("#comunico_id").val()
                        };

            }

            $.ajax({
                url: "index.php",
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



    function setComunicador(){
        //alert('llamada a funcion que carga el comunicador');
        $.ajax({
            url: "index.php",
            data: {"accion":"empleado", "operacion":"getEmpleadoBySession"},
            contentType:"application/x-www-form-urlencoded",
            dataType:"json",//xml,html,script,json
            error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

            },
            ifModified:false,
            processData:true,
            success:function(datas){

                $("#comunico").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                $("#comunico_id").val(datas[0]['ID_EMPLEADO']);

            },
            type:"POST",
            timeout:3000000,
            crossdomain:true

        });

    }



        $(document).ready(function(){


            // menu superfish
            $('#navigationTop').superfish();


            //Aca estaba el dataTable

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
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"asignacion", operacion: "refreshGrid"});
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


            // comunicacion
            $('#comunicacion').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Guardar": function() {
                        //if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#comunicacion").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            //$('#principal').load('index.php',{accion:"asignacion", operacion: "refreshGrid"});
                        //}

                    },
                    "Cancelar": function() {
                        $("#form_comunicacion")[0].reset(); //para limpiar los campos del formulario
                        $('#form_comunicacion').validate().resetForm(); //para limpiar los errores validate
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
                    $("#form_comunicacion")[0].reset(); //para limpiar los campos del formulario cuando sale con la x
                    $('#form_comunicacion').validate().resetForm(); //para limpiar los errores validate
                }

            });


            // comunicacion_link
            $(document).on("click", ".comunicacion_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='insertComunicacion';
                globalId=$(this).attr('id');
                //setComunicador();
                editarComunicacion(globalId);
                $('#comunicacion').dialog('open');
                return false;
            });

            //Agregado para editar
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                return false;
            });


            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );


            //llamada a funcion validar
            $.validar();

        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            rules: {
                estado: {
                    required: true
                }
            },
            messages:{
                estado: "Seleccione un estado"
            }

        });


    };

    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla en el archivo abmEmpleadoGrid.php -->
    <?php require_once('abmAsignacionGrid.php') ?>

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
                                    <label>Estado: </label>
                                    <select name="estado" id="estado">
                                        <option value="">Seleccione un estado</option>
                                        <option value="ASIGNADO">Asignado</option>
                                        <option value="CANCELADO">Cancelado</option>
                                        <option value="SUSPENDIDO">Suspendido</option>
                                        <option value="EN CURSO">En curso</option>
                                        <option value="FINALIZADO">Finalizado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Motivo cambio: </label>
                                    <textarea type="text" name="estado_cambio" id="estado_cambio" rows="5"/></textarea>
                                </div>
                            </div>
                        </div>


                    </fieldset>

                </form>
            </div>
        </div>


    </div>

</div>





<!-- ui-comunicacion -->
<div id="comunicacion" >

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form_comunicacion" action="">
                    <fieldset>
                        <legend>Datos Registro</legend>

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Situación: Porque te vamos a capacitar</label><br/>
                                    <textarea type="text" name="situacion" id="situacion" rows="5"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivos: Que esperamos lograr con esto</label><br/>
                                    <textarea type="text" name="objetivos" id="objetivos" rows="5"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Indicadores de éxito</label><br/>
                                    <textarea type="text" name="indicadores_exito" id="indicadores_exito" rows="5"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Compromiso</label><br/>
                                    <textarea type="text" name="compromiso" id="compromiso" rows="5"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Comunicó: </label>
                                    <input type="text" name="comunico" id="comunico" readonly/>
                                    <input type="hidden" name="comunico_id" id="comunico_id"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Notificado: </label>
                                    <input type="text" name="notificado" id="notificado" readonly/>
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