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

                    //lleno el select con los estados posibles de cambio
                    $("#estado").html('<option value="">Ingrese un estado</option>');
                    $.each(datas['estado_cambiar'], function(indice, val){
                        $("#estado").append(new Option(datas['estado_cambiar'][indice]["ESTADO"],datas['estado_cambiar'][indice]["ESTADO"] ));

                    });

                    $("#estado").val(datas['estado_actual'][0]['ESTADO']);
                    $("#estado_cambio").val(datas['estado_actual'][0]['ESTADO_CAMBIO']);

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

                if(datas[0]){ //si la consulta trae algun registro =>es una edicion
                    globalOperacion='updateComunicacion';
                    $("#comunicacion").data('id_comunicacion',datas[0]['ID_COMUNICACION']);
                    //console.log( $('#comunicacion').data('id_comunicacion'));
                    $("#situacion").val(datas[0]['SITUACION']).change();
                    $("#objetivo_1").val(datas[0]['OBJETIVO_1']).change();
                    $("#objetivo_2").val(datas[0]['OBJETIVO_2']).change();
                    $("#objetivo_3").val(datas[0]['OBJETIVO_3']).change();
                    $("#indicadores_exito").val(datas[0]['INDICADORES_EXITO']).change();
                    $("#compromiso").val(datas[0]['COMPROMISO']).change();
                    //$("#comunico").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                    //$("#comunico_id").val(datas[0]['COMUNICO']);
                    $("#comunico").val((typeof (datas[0]['COMUNICO'])=='undefined')? 'NO COMUNICADO': datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']); //si todavia no se comunico
                    $("#comunico_id").val((typeof (datas[0]['COMUNICO'])=='undefined')? '': datas[0]['COMUNICO']); //si todavia no se comunico
                    $("#notificado").val((datas[0]['NOTIFICADO']==1)? 'NOTIFICADO':'NO NOTIFICADO');

                    //para bloquear o desbloquear botones y campos
                    //if(datas[0]['ESTADO']!='ASIGNADO' && datas[0]['ESTADO']!='COMUNICADO' ){
                    if(!(datas[0]['ESTADO']=='ASIGNADO' || datas[0]['ESTADO']=='COMUNICADO' )){ //es igual a la expresion de arriba
                        $("#form_comunicacion :input").attr("readonly", true);
                        $('#com_btn_guardar').attr('disabled', true);
                        $('#com_btn_send').attr('disabled', true);
                    }
                    else{
                        //selecciona los input del form_comunicacion... less than 6 (osea del 0 al 5)
                        $("#form_comunicacion :input:lt(6)").attr("readonly", false);
                        $('#com_btn_guardar').attr('disabled', false);
                        $('#com_btn_send').attr('disabled', false);
                    }
                }
                else{ // se trata de una comunicacion nueva.... ESTO YA NO SIRVE, HABRIA QUE BORRARLO 31/03/15
                    //seteo el comunicardor
                    $("#comunico").val('<?php echo $_SESSION['USER_APELLIDO']." ".$_SESSION['USER_NOMBRE']; ?>');
                    $("#comunico_id").val('<?php echo $_SESSION['USER_ID_EMPLEADO']; ?>');
                    //selecciona los input del form_comunicacion... less than 6 (osea del 0 al 5)
                    $("#form_comunicacion :input:lt(6)").attr("readonly", false);
                    $('#com_btn_guardar').attr('disabled', true);
                }


            },
            type:"POST",
            timeout:3000000,
            crossdomain:true

        });

    }



    function editarEvaluacion(id_asignacion){
        //alert(id_asignacion);

        $.ajax({
            url:"index.php",
            data:{  "accion":"evaluacion",
                    "operacion":"updateEvaluacion",
                    "id_asignacion":id_asignacion
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

                if(datas['objetivos'][0]){ //si la consulta trae algun registro

                    //globalOperacion='insertEvaluacion';

                    if(datas['objetivos'][0]['OBJETIVO_1']){
                        $("#objetivos_comunicacion").append('<div class="cbcheck">'+
                            '<div class="check"><input class="spinner" id="obj_1" name="obj_1" readonly></div>'+
                            '<div class="lab">'+datas['objetivos'][0]['OBJETIVO_1']+'</div>'+
                            '</div>'
                        );
                    }
                    if(datas['objetivos'][0]['OBJETIVO_2']){
                        $("#objetivos_comunicacion").append('<div class="cbcheck">'+
                            '<div class="check"><input class="spinner" id="obj_2" name="obj_2" readonly></div>'+
                            '<div class="lab">'+datas['objetivos'][0]['OBJETIVO_2']+'</div>'+
                            '</div>'
                        );
                    }
                    if(datas['objetivos'][0]['OBJETIVO_3']){
                        $("#objetivos_comunicacion").append('<div class="cbcheck">'+
                            '<div class="check"><input class="spinner" id="obj_3" name="obj_3" readonly></div>'+
                            '<div class="lab">'+datas['objetivos'][0]['OBJETIVO_3']+'</div>'+
                            '</div>'
                        );
                    }

                    /*
                    $(".spinner").spinner({
                        max: 5,
                        min: 1
                    }); */

                }

                //si ya existe la evaluacion, la trae para editar
                if(datas['evaluacion'][0]){
                    //globalOperacion='saveEvaluacion';
                    //$("#evaluacion").data('id_evaluacion',datas['evaluacion'][0]['ID_EVALUACION']);
                    //console.log( $('#evaluacion').data('id_evaluacion'));

                    $("#conceptos_importantes").val(datas['evaluacion'][0]['CONCEPTOS_IMPORTANTES']).change();
                    $("#aspectos_faltaron").val(datas['evaluacion'][0]['ASPECTOS_FALTARON']).change();
                    $("#mejorar_desempenio").val(datas['evaluacion'][0]['MEJORAR_DESEMPENIO']).change();

                    $("#obj_1").val(datas['evaluacion'][0]['OBJ_1']);
                    $("#obj_2").val(datas['evaluacion'][0]['OBJ_2']);
                    $("#obj_3").val(datas['evaluacion'][0]['OBJ_3']);

                    $("#ev_i_dominio").val(datas['evaluacion'][0]['EV_I_DOMINIO']);
                    $("#ev_i_lenguaje").val(datas['evaluacion'][0]['EV_I_LENGUAJE']);
                    $("#ev_i_claridad").val(datas['evaluacion'][0]['EV_I_CLARIDAD']);
                    $("#ev_i_material").val(datas['evaluacion'][0]['EV_I_MATERIAL']);
                    $("#ev_i_consultas").val(datas['evaluacion'][0]['EV_I_CONSULTAS']);
                    $("#ev_i_didactico").val(datas['evaluacion'][0]['EV_I_DIDACTICO']);
                    $("#ev_i_participacion").val(datas['evaluacion'][0]['EV_I_PARTICIPACION']);

                    $("#ev_l_duracion").val(datas['evaluacion'][0]['EV_L_DURACION']);
                    $("#ev_l_comunicacion").val(datas['evaluacion'][0]['EV_L_COMUNICACION']);
                    $("#ev_l_material").val(datas['evaluacion'][0]['EV_L_MATERIAL']);
                    $("#ev_l_break").val(datas['evaluacion'][0]['EV_L_BREAK']);
                    $("#ev_l_hotel").val(datas['evaluacion'][0]['EV_L_HOTEL']);

                    $("#comentarios").val(datas['evaluacion'][0]['COMENTARIOS']).change();

                }

                $(".spinner").spinner({
                    max: 5,
                    min: 1
                });

                $(':input').attr('readonly', true); //deshabilito los input
                $('.ui-spinner a.ui-spinner-button').css('display','none'); //deshabilito los spinners

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
                            "objetivo_1":$("#objetivo_1").val(),
                            "objetivo_2":$("#objetivo_2").val(),
                            "objetivo_3":$("#objetivo_3").val(),
                            "indicadores_exito":$("#indicadores_exito").val(),
                            "compromiso":$("#compromiso").val()
                            //"comunico":$("#comunico_id").val()
                            //cambio estado a COMUNICADO
                            //"estado": "COMUNICADO",
                            //"estado_cambio": ""

                        };

            }
            else if(globalOperacion=="updateComunicacion"){

                var data={  "accion":"asignacion",
                            "operacion":"saveComunicacion",
                            "id":globalId, //id_asignacion
                            "id_comunicacion": $('#comunicacion').data('id_comunicacion'),
                            "situacion":$("#situacion").val(),
                            "objetivo_1":$("#objetivo_1").val(),
                            "objetivo_2":$("#objetivo_2").val(),
                            "objetivo_3":$("#objetivo_3").val(),
                            "indicadores_exito":$("#indicadores_exito").val(),
                            "compromiso":$("#compromiso").val()
                            //"comunico":$("#comunico_id").val()
                            //cambio estado a COMUNICADO
                            //"estado": "COMUNICADO",
                            //"estado_cambio": ""
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
                    //$("#message").html("Registro actualizado en la BD");
                    $("#message").html(datas['comment']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function enviarComunicacion(){

            var data={  "accion":"asignacion",
                        "operacion":"sendComunicacion",
                        "id":globalId, //id_asignacion
                        "id_comunicacion": $('#comunicacion').data('id_comunicacion'),
                        //"comunico":$("#comunico_id").val(), //tomo el user en PHP
                        //cambio estado a COMUNICADO
                        "estado": "COMUNICADO",
                        "estado_cambio": ""

            };

            $.ajax({
                url: "index.php",
                data:data,
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    //$("#message").html("ha ocurrido un error");
                    $("#message").html(datas['comment']);

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#dialog-msn").dialog("open");
                    $("#message").html(datas['comment']);
                    (datas['response']!='error')? $("#comunico").val('<?php echo $_SESSION['USER_APELLIDO']." ".$_SESSION['USER_NOMBRE']; ?>') : '';


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


            $(document).on('change', '#filtro_periodo', function(){
                $('#principal').load('index.php',{accion:"asignacion", operacion: "refreshGrid", periodo: $("#filtro_periodo").val()});
            });

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


            // Dialog.... Contiene el modal donde se cambia el estado de una asignacion
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
                            $('#principal').load('index.php',{accion:"asignacion", operacion: "refreshGrid", periodo: $("#filtro_periodo").val()});
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
                title:"Comunicación",
                buttons: [
                    {
                        click: function() {
                                enviarComunicacion();
                                //seteo el comunicardor
                                //$("#comunico").val('<?php echo $_SESSION['USER_APELLIDO']." ".$_SESSION['USER_NOMBRE']; ?>');
                                //$("#comunico_id").val('<?php echo $_SESSION['USER_ID_EMPLEADO']; ?>');

                        },
                        id: 'com_btn_send',
                        text: "Enviar comunicación"

                    },
                    {
                    click: function() {
                        if($("#form_comunicacion").valid()){
                        guardar();
                        $("#comunicacion").dialog("close");
                        //Llamada ajax para refrescar la grilla
                        $('#principal').load('index.php',{accion:"asignacion", operacion: "refreshGrid"});
                        }
                    },
                    id: 'com_btn_guardar',
                    text: "Guardar"

                    },
                    {
                        click: function() {
                            $("#form_comunicacion")[0].reset(); //para limpiar los campos del formulario
                            $('#form_comunicacion').validate().resetForm(); //para limpiar los errores validate
                            $(this).dialog("close");
                        },
                        id: 'com_btn_cancelar',
                        text: 'Cancelar'
                    }],
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



            // evaluacion
            $('#evaluacion').dialog({
                autoOpen: false,
                width: 680,
                modal:true,
                title:"Evaluación",
                buttons: {
                    "Salir": function() {
                        $("#form_evaluacion")[0].reset(); //para limpiar los campos del formulario
                        //limpiar los spinners con objetivos agregados dinamicamente
                        $('#objetivos_comunicacion .cbcheck').each(function(){ $(this).remove(); });
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
                    $("#form_evaluacion")[0].reset(); //para limpiar los campos del formulario cuando sale con la x
                    //limpiar los spinners con objetivos agregados dinamicamente
                    $('#objetivos_comunicacion .cbcheck').each(function(){ $(this).remove(); });
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

            // evaluacion_link
            $(document).on("click", ".evaluacion_link", function(){
                //globalOperacion='evaluacion';
                globalId=$(this).attr('id'); //id_asignacion
                editarEvaluacion(globalId);
                $('#evaluacion').dialog('open');
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


            //llamada a las funciones para validar
            $.validar();
            $.validarComunicacion();

        });


    //Declaracion de funcion para validar los cambios de estado
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

    $.validarComunicacion=function(){
        $('#form_comunicacion').validate({
            rules: {
                situacion: {
                    required: true,
                    maxlength: 500
                },
                objetivo_1: {
                    required: true,
                    maxlength: 150
                },
                objetivo_2: {
                    //required: true,
                    maxlength: 150
                },
                objetivo_3: {
                    //required: true,
                    maxlength: 150
                },
                indicadores_exito: {
                    required: true,
                    maxlength: 500
                },
                compromiso: {
                    required: true,
                    maxlength: 500
                }
            },
            messages:{
                situacion: {
                    required: "Ingrese la situación",
                    maxlength: "Máximo 500 caracteres"
                },
                objetivo_1: {
                    required: "Ingrese al menos un objetivo",
                    maxlength: "Máximo 150 caracteres"
                },
                objetivo_2: {
                    //required: "Ingrese el objetivo 2",
                    maxlength: "Máximo 150 caracteres"
                },
                objetivo_3: {
                    //required: "Ingrese el objetivo 3",
                    maxlength: "Máximo 150 caracteres"
                },
                indicadores_exito: {
                    required: "Ingrese los indicadores de éxito",
                    maxlength: "Máximo 500 caracteres"
                },
                compromiso: {
                    required: "Ingrese el compromiso",
                    maxlenth: "Máximo 500 caracteres"
                }
            }

        });

    };

    </script>

</head>


<body>


<!--se realiza en include del filtro -->
<?php require_once('filtro_periodos.php');?>
</br>

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
                        <!--<legend>Datos Registro</legend>-->
                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <select name="estado" id="estado">
                                        <!--Se genera directamente con javascript -->
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
                        <!--<legend>Datos Registro</legend>-->

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Situación: Porque te vamos a capacitar</label><br/>
                                    <textarea type="text" name="situacion" id="situacion" rows="2"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivos: Que esperamos lograr con esto</label><br/>
                                    <textarea type="text" name="objetivo_1" id="objetivo_1" rows="1"/></textarea>
                                    <textarea type="text" name="objetivo_2" id="objetivo_2" rows="1"/></textarea>
                                    <textarea type="text" name="objetivo_3" id="objetivo_3" rows="1"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Indicadores de éxito:</label><br/>
                                    <textarea type="text" name="indicadores_exito" id="indicadores_exito" rows="2"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Compromiso:</label><br/>
                                    <textarea type="text" name="compromiso" id="compromiso" rows="2"/></textarea>
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




<!-- evaluacion -->
<div id="evaluacion" >

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form_evaluacion" action="">
                    <fieldset>
                        <!--<legend>Datos Registro</legend>-->

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Mencione los tres conceptos mas importantes que haya aprendido en la actividad</label><br/>
                                    <textarea type="text" name="conceptos_importantes" id="conceptos_importantes" rows="2" /></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Mencione aspectos que no le gustaron / faltaron / no cumplió expectativas</label><br/>
                                    <textarea type="text" name="aspectos_faltaron" id="aspectos_faltaron" rows="2" /></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Mencione tres maneras concretas en que cree puede mejorar su desempeño como resultado</label><br/>
                                    <textarea type="text" name="mejorar_desempenio" id="mejorar_desempenio" rows="2" /></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <label>Los siguientes fueron sus objetivos fijados, clasifique los mismos con una escala del 1 al 5 según considere usted que ha alcanzado los mismos</label><br/>
                                <div id="objetivos_comunicacion" class="spinners_objetivos">
                                    <!-- se generan dinamicamente -->
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="spinners">
                                <div class="cbtitulo">Evaluación del instructor / Capacitación:</div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_dominio" name="ev_i_dominio" readonly></div>
                                    <div class="lab">Demuestra dominio sobre el tema</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_lenguaje" name="ev_i_lenguaje" readonly></div>
                                    <div class="lab">Utiliza lenguaje / términos adecuados</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_claridad" name="ev_i_claridad" readonly></div>
                                    <div class="lab">Claridad en la exposición de temas</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_material" name="ev_i_material" readonly></div>
                                    <div class="lab">El material de apoyo es bueno</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_consultas" name="ev_i_consultas" readonly></div>
                                    <div class="lab">Responde con claridad consultas</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_didactico" name="ev_i_didactico" readonly></div>
                                    <div class="lab">La capacitación es didáctica y entretenida</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_i_participacion" name="ev_i_participacion" readonly></div>
                                    <div class="lab">Invita a la participación e integración</div>
                                </div>
                            </div>


                            <div class="spinners">
                                <div class="cbtitulo">Evaluación logística de capacitación:</div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_l_duracion" name="ev_l_duracion" readonly></div>
                                    <div class="lab">La duración de la actividad fue satisfactoria</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_l_comunicacion" name="ev_l_comunicacion" readonly></div>
                                    <div class="lab">Fue informado con tiempo de su participación</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_l_material" name="ev_l_material" readonly></div>
                                    <div class="lab">El material recibido fue adecuado</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_l_break" name="ev_l_break" readonly></div>
                                    <div class="lab">Los tiempos de descanso fueron suficientes</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input class="spinner" id="ev_l_hotel" name="ev_l_hotel" readonly></div>
                                    <div class="lab">Hotel / hospedaje</div>
                                </div>
                            </div>


                        </div>

                        <label>Escala obj: [1] Pobre, [2] Regular-No alcanzó obj., [3] Bueno-Alcanzó obj., [4] Muy bueno, [5] Supera ampliamente</label>
                        <p></p>



                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Comentarios</label><br/>
                                    <textarea type="text" name="comentarios" id="comentarios" rows="2" /></textarea>
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