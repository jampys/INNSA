<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="public/js/jquery.validate.js"></script>

    <script type="text/javascript">
    var globalOperacion="";
    var globalId;


        function editar(id_plan){

            $.ajax({
                url:"index.php",
                data:{"accion":"cap_solic","operacion":"update","id":id_plan},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){
                    $("#periodo").val(datas['solicitud'][0]['PERIODO']);
                    $("#empleado").val(datas['solicitud'][0]['APELLIDO']+" "+datas['solicitud'][0]['NOMBRE']);
                    $("#empleado_id").val(datas['solicitud'][0]['ID_EMPLEADO']);
                    $("#situacion_actual").val(datas['solicitud'][0]['SITUACION_ACTUAL']);
                    $("#situacion_deseada").val(datas['solicitud'][0]['SITUACION_DESEADA']);
                    $("#objetivo_medible_1").val(datas['solicitud'][0]['OBJETIVO_MEDIBLE_1']);
                    $("#objetivo_medible_2").val(datas['solicitud'][0]['OBJETIVO_MEDIBLE_2']);
                    $("#objetivo_medible_3").val(datas['solicitud'][0]['OBJETIVO_MEDIBLE_3']);

                    $("#dp_ingreso").attr('checked', (datas['solicitud'][0]['DP_INGRESO']==1)? true:false);
                    $("#dp_crecimiento").attr('checked', (datas['solicitud'][0]['DP_CRECIMIENTO']==1)? true:false);
                    $("#dp_promocion").attr('checked', (datas['solicitud'][0]['DP_PROMOCION']==1)? true:false);
                    $("#dp_futura_transfer").attr('checked', (datas['solicitud'][0]['DP_FUTURA_TRANSFER']==1)? true:false);
                    $("#dp_sustitucion_temp").attr('checked', (datas['solicitud'][0]['DP_SUSTITUCION_TEMP']==1)? true:false);

                    $("#di_nuevas_tecnicas").attr('checked', (datas['solicitud'][0]['DI_NUEVAS_TECNICAS']==1)? true:false);
                    $("#di_crecimiento").attr('checked', (datas['solicitud'][0]['DI_CRECIMIENTO']==1)? true:false);
                    $("#di_competencias_emp").attr('checked', (datas['solicitud'][0]['DI_COMPETENCIAS_EMP']==1)? true:false);

                    $("#rp_falta_comp").attr('checked', (datas['solicitud'][0]['RP_FALTA_COMP']==1)? true:false);
                    $("#rp_no_conformidad").attr('checked', (datas['solicitud'][0]['RP_NO_CONFORMIDAD']==1)? true:false);
                    $("#rp_req_externo").attr('checked', (datas['solicitud'][0]['RP_REQ_EXTERNO']==1)? true:false);
                    $("#apr_solicito").val(datas['solicitud'][0]['APR_SOLICITO']);

                    //Se construye la tabla de asignaciones de planes
                    $.each(datas['planes'], function(indice, val){

                        $('#table_plan tbody').append('<tr id_plan='+datas['planes'][indice]['ID_PLAN']+' '+'id_asignacion='+datas['planes'][indice]['ID_ASIGNACION']+'>' +
                        '<td>'+datas['planes'][indice]['NOMBRE']+" "+datas['planes'][indice]['FECHA_DESDE']+'</td>' +
                        '<td>'+datas['planes'][indice]['OBJETIVO']+'</td>' +
                        '<td>'+datas['planes'][indice]['COMENTARIOS']+'</td>' +
                        '<td>'+datas['planes'][indice]['VIATICOS']+'</td>' +
                        '<td><a class="editar_plan" href="#" id="1"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                        '<td><a class="eliminar_plan" href="#" id="1"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                        '</tr>');


                    });


                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){


            //Codigo para recoger todas las filas de la tabla dinamica de planes
            jsonObj = [];
            $('#table_plan tbody tr').each(function () {
                item = {};
                item['id_plan']=$(this).attr('id_plan');
                item['objetivo']= $(this).find('td').eq(1).html();
                item['comentarios']= $(this).find('td').eq(2).html();
                item['viaticos']= $(this).find('td').eq(3).html();
                //agregado
                item['id_asignacion']=($(this).attr('id_asignacion'))? $(this).attr('id_asignacion') : "";
                item['operacion_asignacion']=$(this).attr('operacion_asignacion');
                //fin agregados
                jsonObj.push(item);
                //alert(item['id_asignacion']);
            });


            if(globalOperacion=="insert"){ //se va a guardar un curso nuevo
                var data={  "accion":"cap_solic",
                            "operacion":"insert",
                            "datos":JSON.stringify(jsonObj),
                            "periodo": $("#periodo").val(),
                            "empleado": $("#empleado_id").val(),
                            "situacion_actual": $("#situacion_actual").val(),
                            "situacion_deseada": $("#situacion_deseada").val(),
                            "objetivo_medible_1": $("#objetivo_medible_1").val(),
                            "objetivo_medible_2": $("#objetivo_medible_2").val(),
                            "objetivo_medible_3": $("#objetivo_medible_3").val(),

                            "dp_ingreso": $('#dp_ingreso').prop('checked')? 1:0,
                            "dp_crecimiento": $('#dp_crecimiento').prop('checked')? 1:0,
                            "dp_promocion": $('#dp_promocion').prop('checked')? 1:0,
                            "dp_futura_transfer": $('#dp_futura_transfer').prop('checked')? 1:0,
                            "dp_sustitucion_temp": $('#dp_sustitucion_temp').prop('checked')? 1:0,
                            "di_nuevas_tecnicas": $('#di_nuevas_tecnicas').prop('checked')? 1:0,
                            "di_crecimiento": $('#di_crecimiento').prop('checked')? 1:0,
                            "di_competencias_emp": $('#di_competencias_emp').prop('checked')? 1:0,
                            "rp_falta_comp": $('#rp_falta_comp').prop('checked')? 1:0,
                            "rp_no_conformidad": $('#rp_no_conformidad').prop('checked')? 1:0,
                            "rp_req_externo": $('#rp_req_externo').prop('checked')? 1:0,

                            "apr_solicito": $("#apr_solicito").val()


                        };
            }
            else{ //se va a guardar un curso editado
                var data={  "accion":"cap_solic",
                        "operacion":"save",
                        "id": globalId, //id de solicitud de capacitacion
                        "datos":JSON.stringify(jsonObj),
                        "periodo": $("#periodo").val(),
                        "empleado": $("#empleado_id").val(),
                        "situacion_actual": $("#situacion_actual").val(),
                        "situacion_deseada": $("#situacion_deseada").val(),
                        "objetivo_medible_1": $("#objetivo_medible_1").val(),
                        "objetivo_medible_2": $("#objetivo_medible_2").val(),
                        "objetivo_medible_3": $("#objetivo_medible_3").val(),

                        "dp_ingreso": $('#dp_ingreso').prop('checked')? 1:0,
                        "dp_crecimiento": $('#dp_crecimiento').prop('checked')? 1:0,
                        "dp_promocion": $('#dp_promocion').prop('checked')? 1:0,
                        "dp_futura_transfer": $('#dp_futura_transfer').prop('checked')? 1:0,
                        "dp_sustitucion_temp": $('#dp_sustitucion_temp').prop('checked')? 1:0,
                        "di_nuevas_tecnicas": $('#di_nuevas_tecnicas').prop('checked')? 1:0,
                        "di_crecimiento": $('#di_crecimiento').prop('checked')? 1:0,
                        "di_competencias_emp": $('#di_competencias_emp').prop('checked')? 1:0,
                        "rp_falta_comp": $('#rp_falta_comp').prop('checked')? 1:0,
                        "rp_no_conformidad": $('#rp_no_conformidad').prop('checked')? 1:0,
                        "rp_req_externo": $('#rp_req_externo').prop('checked')? 1:0,

                        "apr_solicito": $("#apr_solicito").val()
                    };

                }

            $.ajax({
                url:"index.php",
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

                    if(datas==1){
                        $("#dialog-msn").dialog("open");
                        $("#message").html("Registro actualizado en la BD");
                    }

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });


        }




        $(document).ready(function(){


            $("#form_plan").validate({
                rules: {
                    np_plan_capacitacion: {required: true, minlength: 2}

                },
                messages: {
                    name: "Debe introducir su nombre."

                }
            });


            // menu superfish
            $('#navigationTop').superfish();


            //Se envia llamada a dataTable a abmCap_solicGrid.php


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
                            $('#principal').load('index.php',{accion:"cap_solic", operacion: "refreshGrid"});
                        }

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar los campos del formulario
                        $('#form').validate().resetForm(); //para limpiar los errores validate
                        //limpiar la tabla de asignaciones de planes
                        $('#table_plan tbody tr').each(function(){ $(this).remove(); });
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
                   //limpiar la tabla de asignaciones de planes
                   $('#table_plan tbody tr').each(function(){ $(this).remove(); });
                }


            });


            //******************************************************************************************
            //Funcionalidad para la tabla de asignar planes
            $('#asignar_plan').dialog({
                autoOpen: false,
                width: 500,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Guardar": function() {
                        // si se trata de un update
                        if($('#asignar_plan').data('operacion')=='editar'){
                            var row_index=$('#asignar_plan').data('row_index');
                            //console.log($('#asignar_plan').data('operacion'));
                            //Cambio el atributo id_plan del tr por el del plan que eligio el usuario
                            $('#table_plan tbody').find('tr').eq(row_index).attr('id_plan',$("#np_plan_capacitacion_id").val());
                            $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(0).html($('#np_plan_capacitacion').val());
                            $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(1).html($('#np_objetivo').val());
                            $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(2).html($('#np_comentarios').val());
                            $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(3).html($('#np_viaticos').val());
                            $("#form_plan")[0].reset();
                            $(this).dialog("close");

                        }
                        else{  //si se trata de un insert

                            //Se agrega fila a la tabla de planes
                            //$('#table_plan tr:last').after('<tr>' +
                            $('#table_plan tbody').append('<tr id_plan='+$("#np_plan_capacitacion_id").val()+'>' +
                            '<td>'+$('#np_plan_capacitacion').val()+'</td>' +
                            '<td>'+$('#np_objetivo').val()+'</td>' +
                            '<td>'+$('#np_comentarios').val()+'</td>' +
                            '<td>'+$('#np_viaticos').val()+'</td>' +
                            '<td><a class="editar_plan" href="#" id="1"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                            '<td><a class="eliminar_plan" href="#" id="1"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                            '</tr>');
                            $("#form_plan")[0].reset();

                        }


                    },
                    "Cancelar": function() {
                        $("#form_plan")[0].reset(); //para limpiar el formulario
                        $(this).dialog("close");
                    }
                },
                show: {
                    effect: "blind",
                    duration: 300
                },
                hide: {
                    effect: "explode",
                    duration: 300
                },
                close:function(){
                    $("#form_plan")[0].reset(); //para limpiar el formulario cuando sale con x
                }

            });

            //Al presionar la x para agregar planes a la solicitud
            $(document).on("click",".eliminar_plan",function(){
                //pregunta si la fila tiene el atributo id_asignacion.
                //Si lo tiene=> viene de la BD. Sino=> se acaba de agregar dinamicamente y estan solo en memoria
                if($(this).closest('tr').attr('id_asignacion')){
                    //alert('esta fila viene de la BD');
                    $(this).closest('tr').attr('operacion_asignacion', 'delete');
                    $(this).closest('tr').toggle(); //oculta la fila, pero no la elimina
                }else{

                    $(this).closest('tr').remove(); //elimina la fila
                }

            });

            //Al presionar el lapiz para editar los planes de la solicitud
            $(document).on("click",".editar_plan",function(){
                //alert($(this).closest('tr').attr('id_asignacion'));
                $(this).closest('tr').attr('operacion_asignacion', 'update');
                $('#np_plan_capacitacion_id').val($(this).closest('tr').attr('id_plan'));
                $('#np_plan_capacitacion').val($(this).closest('tr').find('td').eq(0).html());
                $('#np_objetivo').val($(this).closest('tr').find('td').eq(1).html());
                $('#np_comentarios').val($(this).closest('tr').find('td').eq(2).html());
                $('#np_viaticos').val($(this).closest('tr').find('td').eq(3).html());
                //Guardo en row_index el identificador de la fila y luego envio ese identificador y la operacion
                //con el metodo .data() en formato json.
                var row_index=$(this).closest('tr').index();
                $('#asignar_plan').data({'row_index':row_index, 'operacion':'editar'}).dialog('open');

                return false;

            });


            // new plan link
            $('#new-plan-link').click(function(){
                //$('#asignar_plan').dialog('open');
                $('#asignar_plan').data('operacion', 'insert').dialog('open');
                return false;
            });


            //Agregado para autocompletar planes
            $("#np_plan_capacitacion").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"cap_solic", "operacion":"autocompletar_planes"},
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.NOMBRE+' - '+item.FECHA_DESDE,
                                    id: item.ID_PLAN

                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#np_plan_capacitacion_id').val(ui.item.id);
                    $('#np_plan_capacitacion').val(ui.item.label);
                }
            });

            //fin agregado autocompletar planes

            //Fin funcionalidad tabla asignar planes
            //---------------------------------------------------------------------------------------

            //**************************************************************************************
            //Agregado dario para autocompletar empleados
            $("#empleado").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"empleado", "operacion":"autocompletar_empleados"},
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
                minLength: 2,
                select: function(event, ui) {
                    $('#empleado_id').val(ui.item.id);
                    $('#empleado').val(ui.item.label);
                }
            });

            //---------------------------------------------------------------------------------------------

            //Se envia llamada a dialogLink a abmCap_solicGrid.php

            //Agregado por dario para editar
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                $("#empleado").attr("readonly", true); //para no permitir editar el empleado
                return false;
            });



            // Datepicker fecha_desde
            $('#fecha_desde').datepicker({
                inline: true
                ,dateFormat:"dd/mm/yy"
            });

            // Datepicker fecha_hasta
            $('#fecha_hasta').datepicker({
                inline: true
                ,dateFormat:"dd/mm/yy"
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
                periodo: {
                    required: true
                },
                empleado: {
                    required: true
                },
                situacion_actual: {
                    required: true
                },
                situacion_deseada: {
                    required: true
                },
                objetivo_medible_1: {
                    required: true
                },
                objetivo_medible_2: {
                    required: true
                },
                objetivo_medible_3:{
                    required: true
                },
                apr_solicito:{
                    required: true
                }

            },
            messages:{
                periodo: "Seleccione el periodo",
                empleado: "Ingrese el empleado",
                situacion_actual: "Ingrese la situación actual",
                situacion_deseada: "Ingrese la situacion deseada",
                objetivo_medible_1: "Ingrese el objetivo medible 1",
                objetivo_medible_2: "Ingrese el objetivo medible 2",
                objetivo_medible_3: "Ingrese el objetivo medible 3",
                apr_solicito: "Ingrese el solicitante"

            }

        });


    };


    </script>

</head>


<body>

<div id="principal">

<!-- Se incluye llamada a abmCapSolicGrid.php -->
    <?php require_once('abmCap_solicGrid.php');?>

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
                                    <label>Periodo: </label>
                                    <select name="periodo" id="periodo">
                                        <option value="">Ingrese el periodo</option>
                                        <option value="2010">2010</option>
                                        <option value="2011">2011</option>
                                        <option value="2012">2012</option>
                                        <option value="2013">2013</option>
                                        <option value="2014">2014</option>
                                        <option value="2015">2015</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Empleado: </label>
                                    <input type="text" name="empleado" id="empleado">
                                    <input type="hidden" name="empleado_id" id="empleado_id">
                                </div>
                            </div>
                        </div>




                        <div class="sixteen_column section">
                            <div class="checkboxes">
                                <div class="cbtitulo">Desarrollo personal:</div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" id="dp_ingreso" name="dp_ingreso" /></div>
                                        <div class="lab">Ingreso</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" id="dp_crecimiento" name="dp_crecimiento" /></div>
                                        <div class="lab">Crecimiento</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" id="dp_promocion" name="dp_promocion" /></div>
                                        <div class="lab">Promoción</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" id="dp_futura_transfer" name="dp_futura_transfer" /></div>
                                        <div class="lab">Futura transfer.</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" id="dp_sustitucion_temp" name="dp_sustitucion_temp" /></div>
                                        <div class="lab">Sustitución temporal</div>
                                    </div>
                            </div>


                            <div class="checkboxes">
                                <div class="cbtitulo">Desarrollo institucional:</div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" id="di_nuevas_tecnicas" name="di_nuevas_tecnicas" /></div>
                                    <div class="lab">Nuevas tecnicas/procesos</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" id="di_crecimiento" name="di_crecimiento" /></div>
                                    <div class="lab">Crecimiento/diversificación</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" id="di_competencias_emp" name="di_competencias_emp" /></div>
                                    <div class="lab">Des. cometencias empresa</div>
                                </div>
                            </div>


                            <div class="checkboxes">
                                <div class="cbtitulo">Respuesta a problema:</div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" id="rp_falta_comp" name="rp_falta_comp" /></div>
                                    <div class="lab">Falta de competencias</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" id="rp_no_conformidad" name="rp_no_conformidad" /></div>
                                    <div class="lab">No conformidad</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" id="rp_req_externo" name="rp_req_externo" /></div>
                                    <div class="lab">Req. externo</div>
                                </div>
                            </div>


                        </div>



                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Situación actual: </label><br/>
                                    <textarea name="situacion_actual" id="situacion_actual" rows="3"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Situación deseada: </label><br/>
                                    <textarea name="situacion_deseada" id="situacion_deseada" rows="3"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivo medible 1: </label><br/>
                                    <textarea name="objetivo_medible_1" id="objetivo_medible_1" rows="1"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivo medible 2: </label><br/>
                                    <textarea name="objetivo_medible_2" id="objetivo_medible_2" rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivo medible 3: </label><br/>
                                    <textarea name="objetivo_medible_3" id="objetivo_medible_3" rows="1"></textarea>
                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Capacitaciones propuestas: </label><br/>
                                    <a id="new-plan-link" href="#"><img src="public/img/add-icon.png" width="15px" height="15px"></a>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <table id="table_plan">
                                        <thead>
                                            <tr>
                                                <td>Plan</td>
                                                <td>Objetivo</td>
                                                <td>Comentarios</td>
                                                <td>Viaticos</td>
                                                <td>Editar</td>
                                                <td>Eliminar</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- el cuerpo se genera dinamicamente con javascript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Solicitó: </label><br/>
                                    <input type="text" name="apr_solicito" id="apr_solicito"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Gerencia de área: </label>
                                    <input type="text" name="" id=""/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Autorizó: </label><br/>
                                    <input type="text" name="apr_autorizo" id="apr_autorizo"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Gerencia de RRHH: </label>
                                    <input type="text" name="" id=""/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Aprobación: </label><br/>
                                    <input type="text" name="apr_aprobacion" id="apr_aprobacion"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Dirección: </label>
                                    <input type="text" name="" id=""/>
                                </div>
                            </div>
                        </div>



                    </fieldset>

                </form>
            </div>
        </div>


    </div>

</div>







<div id="asignar_plan" >

<div class="grid_7">



<div class="block" id="formus">
<form id="form_plan" action="">
<fieldset>
<legend>Datos Registro</legend>

    <div class="sixteen_column section">
        <div class="sixteen_column">
            <div class="column_content">
                <label>Plan capacitación: </label><br/>
                <input type="text" name="np_plan_capacitacion" id="np_plan_capacitacion"/>
                <input type="hidden" name="np_plan_capacitacion_id" id="np_plan_capacitacion_id"/>
            </div>
        </div>
    </div>

    <div class="sixteen_column section">
        <div class="eight column">
            <div class="column_content">
                <label>Objetivo: </label><br/>
                <textarea name="np_objetivo" id="np_objetivo" rows="5"></textarea>
            </div>
        </div>
        <div class="eight column">
            <div class="column_content">
                <label>Comentarios: </label>
                <textarea name="np_comentarios" id="np_comentarios" rows="5"></textarea>
            </div>
        </div>
    </div>



<div class="sixteen_column section">
    <div class="eight column">
        <div class="column_content">
            <label>Viaticos: </label><br/>
            <input type="text" name="np_viaticos" id="np_viaticos"/>
        </div>
    </div>
    <div class="eight column">
        <div class="column_content">

        </div>
    </div>
</div>


</fieldset>

</form>


</div>



</div>

</div>












</body>
</html>