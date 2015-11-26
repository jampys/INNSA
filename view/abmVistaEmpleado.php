<!doctype html>

<head xmlns="http://www.w3.org/1999/html">
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;


        function editar(id_asignacion){ //funcion que trae los datos del estado de una asignacion

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

                if(datas[0]){ //si la consulta trae algun registro
                    globalOperacion='comunicacion';
                    $("#comunicacion").data('id_comunicacion',datas[0]['ID_COMUNICACION']);
                    console.log( $('#comunicacion').data('id_comunicacion'));
                    $("#situacion").val(datas[0]['SITUACION']).change();
                    $("#objetivos").val(datas[0]['OBJETIVO_1']+
                            '\n'+((datas[0]['OBJETIVO_2'])? datas[0]['OBJETIVO_2']: "") + //Se valida que el objetivo_2 tenga datos
                            '\n'+((datas[0]['OBJETIVO_3'])? datas[0]['OBJETIVO_3']: "")).change(); ////Se valida que el objetivo_3 tenga datos
                    $("#indicadores_exito").val(datas[0]['INDICADORES_EXITO']).change();
                    $("#compromiso").val(datas[0]['COMPROMISO']).change();
                    $("#comunico").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                    $("#comunico_id").val(datas[0]['COMUNICO']);
                    $("#notificado").attr('checked', (datas[0]['NOTIFICADO']==1)? true:false);
                    $("#mensaje").val(datas[0]['ESTADO_CAMBIO']);

                    var estado=(datas[0]['ESTADO']=='COMUNICADO' || datas[0]['ESTADO']=='NOTIFICADO' || datas[0]['ESTADO']=='EVALUADO' || datas[0]['ESTADO']=='POST-EVALUADO')? 'NOTIFICADO': 'CANCELADO';
                    $("input:radio[name=group1][value="+estado+"]").attr("checked", "checked"); //selecciona en el radio button
                    ($("input:radio[name=group1][value=CANCELADO]").attr("checked"))? $('#div-mensaje').show(): $('#div-mensaje').hide();

                    /*si el empleado ya esta notificado (dio su conformidad con el check) el checkbox se inhabilita
                    para que no lo pueda volver a deltildar */
                    if(datas[0]['NOTIFICADO']==1){
                        $("#notificado").attr("disabled", true);
                        $('#com_btn_guardar').attr('disabled', true);
                        $('input:radio[name=group1]').attr('disabled', true);
                        $("#mensaje").attr('readonly', true);
                    }
                    else{
                        $("#notificado").attr("disabled", false);
                        $('#com_btn_guardar').attr('disabled', false);
                        $('input:radio[name=group1]').attr('disabled', false);
                        $("#mensaje").attr('readonly', false);

                    }
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

                    globalOperacion='insertEvaluacion';

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


                    $(".spinner").spinner({
                        max: 5,
                        min: 1
                    }).val(1);

                }

                //si ya existe la evaluacion, la trae para editar
                if(datas['evaluacion'][0]){
                    globalOperacion='saveEvaluacion';
                    $("#evaluacion").data('id_evaluacion',datas['evaluacion'][0]['ID_EVALUACION']);
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



            },
            type:"POST",
            timeout:3000000,
            crossdomain:true

        });

    }


        function guardar(){

            if(globalOperacion=="edit"){ //Se cambia el estado de la asignacion

                var data={
                    "accion":"asignacion",
                    "operacion":"save",
                    "id":globalId,
                    "estado":$("#estado").val(),
                    "estado_cambio":$("#estado_cambio").val()
                };
            }
            else if(globalOperacion=="comunicacion"){ //para guardar la notificacion de la comunicacion

                var data={  "accion":"asignacion",
                            "operacion":"updateComunicacionNotificacion",
                            "id_comunicacion": $('#comunicacion').data('id_comunicacion'),
                            "notificado": $('#notificado').prop('checked')? 1:0,

                            //cambio estado asignacion a NOTIFICADO
                            "id": globalId, //id_asignacion
                            "estado": $("input:radio[name=group1]:checked").val(), //NOTIFICADO o CANCELADO
                            "estado_cambio": $("#mensaje").val()


                        };
            }
            else if (globalOperacion=="insertEvaluacion" || globalOperacion=="saveEvaluacion"){ //Para guardar (por insert o save(al editar))

                var data={  "accion":"evaluacion",
                            "operacion": globalOperacion, //globalOperacion=insertEvaluacion o updateEvaluacion
                            "id_asignacion":globalId, //id_asignacion
                            "id_evaluacion": $('#evaluacion').data('id_evaluacion'), //si no existe (porque es un insert) no pasa nada
                            "conceptos_importantes":$("#conceptos_importantes").val(),
                            "aspectos_faltaron":$("#aspectos_faltaron").val(),
                            "mejorar_desempenio":$("#mejorar_desempenio").val(),
                            "ev_i_dominio":$("#ev_i_dominio").val(),
                            "ev_i_lenguaje":$("#ev_i_lenguaje").val(),
                            "ev_i_claridad":$("#ev_i_claridad").val(),
                            "ev_i_material":$("#ev_i_material").val(),
                            "ev_i_consultas":$("#ev_i_consultas").val(),
                            "ev_i_didactico":$("#ev_i_didactico").val(),
                            "ev_i_participacion":$("#ev_i_participacion").val(),
                            "ev_l_duracion":$("#ev_l_duracion").val(),
                            "ev_l_comunicacion":$("#ev_l_comunicacion").val(),
                            "ev_l_material":$("#ev_l_material").val(),
                            "ev_l_break":$("#ev_l_break").val(),
                            "ev_l_hotel":$("#ev_l_hotel").val(),
                            "obj_1":$("#obj_1").val(),
                            "obj_2":($("#obj_2").length >0)? $("#obj_2").val() : 'null', //Si obj_2 existe, envio el valor. Sino null
                            "obj_3":($("#obj_3").length >0)? $("#obj_3").val() : 'null', //Si obj_3 existe, envio el valor. Sino null
                            "comentarios":$("#comentarios").val(),

                            //cambio estado asignacion a EVALUADA
                            "estado": 'EVALUADO',
                            "estado_cambio":''

                        };


            }


            $.ajax({
                url: "index.php",
                data:data,
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(e){

                    $("#dialog-msn").dialog("open");
                    //$("#message").html("ha ocurrido un error");
                    $("#message").html(e.responseText);

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#dialog-msn").dialog("open");
                    $("#message").html(datas['comment']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }



        $(document).ready(function(){

            $(document).tooltip();

            $(document).on('change', '#filtro_periodo', function(){
                $('#principal').load('index.php',{accion:"vista_empleado", operacion: "refreshGrid", periodo: $("#filtro_periodo").val()});
            });


            $( ".spinner" ).spinner({
                    max: 5,
                    min: 1
                }).val(1);


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




            // comunicacion
            $('#comunicacion').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"Comunicación",
                buttons: [{
                        click: function() {
                            if($("#form_comunicacion").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#comunicacion").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"vista_empleado", operacion: "refreshGrid", periodo: $("#filtro_periodo").val()});
                            }
                        },
                        id: 'com_btn_guardar',
                        text: "Guardar"
                    },
                        {
                        click: function() {
                            $("#form_comunicacion")[0].reset(); //para limpiar los campos del formulario
                            //$('#form_comunicacion').validate().resetForm(); //para limpiar los errores validate
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
                    "Guardar": function() {
                        if($("#form_evaluacion").valid()){
                        guardar();
                        $("#evaluacion").dialog("close");
                        //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"vista_empleado", operacion: "refreshGrid", periodo: $("#filtro_periodo").val()});
                        }

                    },
                    "Cancelar": function() {
                        $("#form_evaluacion")[0].reset(); //para limpiar los campos del formulario
                        $('#form_evaluacion').validate().resetForm(); //para limpiar los errores validate
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
                    $('#form_evaluacion').validate().resetForm(); //para limpiar los errores validate
                    //limpiar los spinners con objetivos agregados dinamicamente
                    $('#objetivos_comunicacion .cbcheck').each(function(){ $(this).remove(); });
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
                            $('#principal').load('index.php',{accion:"vista_empleado", operacion: "refreshGrid", periodo: $("#filtro_periodo").val()});
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


            // comunicacion_link
            $(document).on("click", ".comunicacion_link", function(){
                globalOperacion='comunicacion';
                globalId=$(this).attr('id'); //id_asignacion
                editarComunicacion(globalId);
                $('#comunicacion').dialog('open');
                return false;
            });


            // evaluacion_link
            $(document).on("click", ".evaluacion_link", function(){
            //$('.evaluacion_link').on('click', function(e){
                //globalOperacion='evaluacion';
                globalId=$(this).attr('id'); //id_asignacion
                editarEvaluacion(globalId);
                $('#evaluacion').dialog('open');
                //return false;
                e.preventDefault();
            });

            //Agregado para editar (cambiar de estado)
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id de la asignacion a editar que esta en el atributo id
                $('#dialog').dialog('open');
                return false;
            });


            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );


            //llamada a funcion validar
            $.validarComunicacion();
            $.validarEvaluacion();


            //muestra el campo de mensaje si rechazo al hacer click en Rechazar del radio button

            $("input:radio[name=group1]").click(function(){

                if($("input:radio[name=group1]:checked").val()=="CANCELADO"){
                    $('#div-mensaje').show();
                }
                else{
                    $('#div-mensaje').hide();
                    $('#div-mensaje #mensaje').val("");
                    $('#form_comunicacion').validate().resetForm(); //para limpiar los errores validate
                }

            });

        });



    $.validarComunicacion=function(){
        $('#form_comunicacion').validate({
            rules: {
                mensaje: {
                    required: function(){return $("input:radio[name=group1]:checked").val()=="CANCELADO" },
                    maxlength: 250
                },
                notificado: {
                    required: true
                }

            },
            messages:{
                mensaje: "Ingrese el motivo del rechazo",
                notificado: "Debe_leer_la_comunicación"

            }

        });

    };


    //Declaracion de funcion para validar la evaluacion
    $.validarEvaluacion=function(){
        $('#form_evaluacion').validate({
            rules: {
                conceptos_importantes: {
                    required: true,
                    maxlength: 500
                },
                aspectos_faltaron: {
                    required: true,
                    maxlength: 500
                },
                mejorar_desempenio: {
                    required: true,
                    maxlength: 500
                },
                comentarios: {
                    maxlength: 500
                }

            },
            messages:{
                conceptos_importantes: {
                    required: "Ingrese los conceptos importantes",
                    maxlength: "Máximo 500 caracteres"
                },
                aspectos_faltaron: {
                    required: "Ingrese los aspectos que faltaron",
                    maxlength: "Máximo 500 caracteres"
                },
                mejorar_desempenio: {
                    required: "Ingrese la mejora de desempeño",
                    maxlength: "Máximo 500 caracteres"
                },
                comentarios: "Máximo 500 caracteres"
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
    <?php require_once('abmVistaEmpleadoGrid.php') ?>

</div>

<!-- ui-dialog mensaje -->
<div id="dialog-msn">
    <p id="message"></p>
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
                                    <textarea type="text" name="situacion" id="situacion" rows="2" readonly/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivos: Que esperamos lograr con esto</label><br/>
                                    <textarea type="text" name="objetivos" id="objetivos" rows="2" readonly/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Indicadores de éxito</label><br/>
                                    <textarea type="text" name="indicadores_exito" id="indicadores_exito" rows="2" readonly/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Compromiso</label><br/>
                                    <textarea type="text" name="compromiso" id="compromiso" rows="2" readonly/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Comunicó: </label>
                                    <input type="text" name="comunico" id="comunico" readonly/>
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

                                    <div class="checkbox_individual">
                                        <div class="cbtitulo">Conformidad comunicación:</div>

                                        <div class="cbcheck">
                                            <div class="check"><input type="checkbox" id="notificado" name="notificado" /></div>
                                            <div class="lab">He leído la comunicación propuesta</div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <div class="spinners">
                                        <div class="cbcheck">
                                            <div class="check"><input type="radio" name="group1" value="NOTIFICADO" checked></div>
                                            <div class="lab">Acepto</div>
                                        </div>
                                        <div class="cbcheck">
                                            <div class="check"><input type="radio" name="group1" value="CANCELADO"></div>
                                            <div class="lab">Rechazo</div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>


                        <div id="div-mensaje" style="display: none" class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Motivo del rechazo</label><br/>
                                    <textarea type="text" name="mensaje" id="mensaje" rows="3"/></textarea>
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


<!-- cambio de estado -->
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
                                        <!--<option value="">Seleccione un estado</option>
                                        <option value="ASIGNADO">Asignado</option>
                                        <option value="CANCELADO">Cancelado</option>
                                        <option value="SUSPENDIDO">Suspendido</option>
                                        <option value="COMUNICADO">Comunicado</option>
                                        <option value="NOTIFICADO">Notificado</option>
                                        <option value="EVALUADO">Evaluado</option>
                                        <option value="POST-EVALUADO">Post-Evaluado</option>-->
                                        <!-- se carga dinamicamente  -->
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





</body>
</html>