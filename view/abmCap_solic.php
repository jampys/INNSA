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
                error:function(error){

                $("#dialog-msn").dialog("open");
                //$("#message").html("Error al abrir solicitud de capacitación");
                $("#message").html(error.responseText);

                },
                ifModified:false,
                processData:true,
                success:function(datas){
                    $("#periodo").val(datas['solicitud'][0]['PERIODO']);
                    $("#empleado").val(datas['solicitud'][0]['APELLIDO']+" "+datas['solicitud'][0]['NOMBRE']);
                    $("#empleado_id").val(datas['solicitud'][0]['ID_EMPLEADO']);
                    $("#situacion_actual").val(datas['solicitud'][0]['SITUACION_ACTUAL']);
                    $("#situacion_deseada").val(datas['solicitud'][0]['SITUACION_DESEADA']);
                    $("#objetivo_medible_1").val(datas['solicitud'][0]['OBJETIVO_MEDIBLE_1']).change(); //.trigger('change')
                    $("#objetivo_medible_2").val(datas['solicitud'][0]['OBJETIVO_MEDIBLE_2']).change();
                    $("#objetivo_medible_3").val(datas['solicitud'][0]['OBJETIVO_MEDIBLE_3']).change();

                    $("#dp_ingreso").prop('checked', (datas['solicitud'][0]['DP_INGRESO']==1)? true:false);
                    $("#dp_crecimiento").prop('checked', (datas['solicitud'][0]['DP_CRECIMIENTO']==1)? true:false);
                    $("#dp_promocion").prop('checked', (datas['solicitud'][0]['DP_PROMOCION']==1)? true:false);
                    $("#dp_futura_transfer").prop('checked', (datas['solicitud'][0]['DP_FUTURA_TRANSFER']==1)? true:false);
                    $("#dp_sustitucion_temp").prop('checked', (datas['solicitud'][0]['DP_SUSTITUCION_TEMP']==1)? true:false);

                    $("#di_nuevas_tecnicas").prop('checked', (datas['solicitud'][0]['DI_NUEVAS_TECNICAS']==1)? true:false);
                    $("#di_crecimiento").prop('checked', (datas['solicitud'][0]['DI_CRECIMIENTO']==1)? true:false);
                    $("#di_competencias_emp").prop('checked', (datas['solicitud'][0]['DI_COMPETENCIAS_EMP']==1)? true:false);

                    $("#rp_falta_comp").prop('checked', (datas['solicitud'][0]['RP_FALTA_COMP']==1)? true:false);
                    $("#rp_no_conformidad").prop('checked', (datas['solicitud'][0]['RP_NO_CONFORMIDAD']==1)? true:false);
                    $("#rp_req_externo").prop('checked', (datas['solicitud'][0]['RP_REQ_EXTERNO']==1)? true:false);

                    //Completa los campos Solicito, autorizo, aprobo
                    $("#apr_solicito").val(datas['solicitud'][0]['APELLIDO_SOLICITO']+' '+datas['solicitud'][0]['NOMBRE_SOLICITO']);
                    $("#apr_solicito_id").val(datas['solicitud'][0]['ID_SOLICITO']);

                    /*if(datas['solicitud'][0]['APELLIDO_AUTORIZO'] && datas['solicitud'][0]['NOMBRE_AUTORIZO']){ //Si el array autorizo tiene datos =>esta autorizada y se completan los campos.
                        $("#apr_autorizo").val(datas['solicitud'][0]['APELLIDO_AUTORIZO']+' '+datas['solicitud'][0]['NOMBRE_AUTORIZO']);
                    }*/

                    /*if(datas['solicitud'][0]['APELLIDO_APROBO'] && datas['solicitud'][0]['NOMBRE_APROBO']){ //Si el array aprobo tiene datos =>esta autorizada y se completan los campos.
                        $("#apr_aprobo").val(datas['solicitud'][0]['APELLIDO_APROBO']+' '+datas['solicitud'][0]['NOMBRE_APROBO']);
                    }*/
                    //Fin completa los campos Solicito, autorizo, aprobo

                    //Se construye la tabla de asignaciones de planes
                    $.each(datas['planes'], function(indice, val){
                        
                        var comentarios= (datas['planes'][indice]['COMENTARIOS'])? datas['planes'][indice]['COMENTARIOS']: "";

                        $('#table_plan tbody').append('<tr id_plan='+datas['planes'][indice]['ID_PLAN']+' '+'id_asignacion='+datas['planes'][indice]['ID_ASIGNACION']+'>' +
                        '<td>'+datas['planes'][indice]['NOMBRE']+" - "+datas['planes'][indice]['FECHA_DESDE']+" - "+datas['planes'][indice]['MODALIDAD']+'</td>' +
                        '<td style="display: none">'+comentarios+'</td>' +
                        '<td>'+datas['planes'][indice]['DURACION']+" "+datas['planes'][indice]['UNIDAD']+'</td>' +
                        '<td>'+datas['planes'][indice]['MONEDA']+" "+datas['planes'][indice]['IMPORTE']+'</td>' +
                        '<td style="text-align: center">'+datas['planes'][indice]['VIATICOS']+'</td>' +
                        //'<td style="text-align: center"><a class="editar_plan" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                        //'<td style="text-align: center"><a class="eliminar_plan" href="#"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                        '<td style="text-align: center"><a class="<?php  echo ($_SESSION['ACCESSLEVEL']==2)? "editar_plan": "link-desactivado"      ?>" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                        '<td style="text-align: center"><a class="<?php  echo ($_SESSION['ACCESSLEVEL']==2)? "eliminar_plan": "link-desactivado"      ?>" href="#"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                        '</tr>');
                        if(datas['planes'][indice]['APROBADA']==1 || datas['solicitud'][0]['PERIODO']!=(new Date).getFullYear() ){ //Si la asignacion esta aprobada deshabilito los campos
                            //$('#table_plan tbody').find('a.eliminar_plan').removeClass('eliminar_plan').addClass('link-desactivado').click(function(e){e.preventDefault();});
                            //$('#table_plan tbody').find('a.editar_plan').removeClass('editar_plan').addClass('link-desactivado').click(function(e){e.preventDefault();});
                            $('#table_plan tbody tr:last').find('a.eliminar_plan').removeClass('eliminar_plan').addClass('link-desactivado').click(function(e){e.preventDefault();});
                        }
                    });


                    //Se construye la tabla de cursos propuestos
                    $.each(datas['propuestas'], function(indice, val){

                        //var nombre= (typeof(datas['propuestas'][indice]['ID_CURSO'])!='undefined')? datas['propuestas'][indice]['CURSO_NOMBRE']: datas['propuestas'][indice]['TEMA_NOMBRE'];
                        var nombre;
                        var id_curso;
                        if(typeof(datas['propuestas'][indice]['ID_CURSO'])!='undefined'){
                            nombre= 'CURSO: '+datas['propuestas'][indice]['CURSO_NOMBRE'];
                            id_curso=datas['propuestas'][indice]['ID_CURSO'];
                        }
                        else{
                            nombre='TEMA: '+datas['propuestas'][indice]['TEMA_NOMBRE'];
                            id_curso='null';

                        }
                        var id_reemplazo= (typeof(datas['propuestas'][indice]['ID_REEMPLAZO'])!='undefined')? datas['propuestas'][indice]['ID_REEMPLAZO'] : '';
                        var reemplazo= (typeof(datas['propuestas'][indice]['ID_REEMPLAZO'])!='undefined')? datas['propuestas'][indice]['REEMPLAZO_APELLIDO']+' '+datas['propuestas'][indice]['REEMPLAZO_NOMBRE'] : '';
                        //var asignada= (typeof(datas['propuestas'][indice]['ASIGNADA'])!='undefined')? datas['propuestas'][indice]['ASIGNADA'] : '';
                        //Si la propuesta tiene alguna asignacion, no se puede eliminar
                        var asignada= (datas['propuestas'][indice]['ASIGNADA'] > 0)? datas['propuestas'][indice]['ASIGNADA'] : '';

                        $('#table_curso tbody').append('<tr id_curso='+id_curso+' '+'id_propuesta='+datas['propuestas'][indice]['ID_PROPUESTA']+'>' +
                        '<td>'+nombre+'</td>' +
                        '<td style="display: none">'+id_reemplazo+'</td>' +
                        '<td>'+reemplazo+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['SITUACION']+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['OBJETIVO_1']+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['OBJETIVO_2']+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['OBJETIVO_3']+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['INDICADORES_EXITO']+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['COMPROMISO']+'</td>' +
                        '<td style="display: none">'+datas['propuestas'][indice]['ID_TEMA']+'</td>' +
                        '<td style="display: none">'+asignada+'</td>' +
                        '<td style="text-align: center"><a class="editar_curso" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                        '<td style="text-align: center"><a class="eliminar_curso" href="#"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                        '</tr>');
                        if(asignada !='' || datas['solicitud'][0]['PERIODO']!=(new Date).getFullYear() ){
                            //$('#table_curso tbody').find('a.eliminar_curso').removeClass('eliminar_curso').addClass('link-desactivado').click(function(e){e.preventDefault();});
                            $('#table_curso tbody tr:last').find('a.eliminar_curso').removeClass('eliminar_curso').addClass('link-desactivado').click(function(e){e.preventDefault();});
                        }
                    });

                    /*Si esta aprobada o autorizada
                    if(datas['solicitud'][0]['ESTADO']=='APROBADA' ||datas['solicitud'][0]['ESTADO']=='AUTORIZADA' ){
                        $('#new-plan').removeClass('new-plan-link').addClass('link-desactivado').click(function(e){e.preventDefault();});
                        $('#new-propuesta').removeClass('new-propuesta-link').addClass('link-desactivado').click(function(e){e.preventDefault();});
                        $(":input:not(.button-cancel)").attr("disabled", true);

                    }*/


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
                item['comentarios']= $(this).find('td').eq(1).html();
                item['viaticos']= $(this).find('td').eq(4).html();
                item['id_asignacion']=($(this).attr('id_asignacion'))? $(this).attr('id_asignacion') : "";
                item['operacion_asignacion']=$(this).attr('operacion_asignacion');
                item['estado'] = 'ASIGNADO';
                jsonObj.push(item);
            });

            //Codigo para recoger todas las filas de la tabla dinamica de propuestas
            jsonObjCursos = [];
            $('#table_curso tbody tr').each(function () {
                item = {};
                //item['id_curso']=($(this).attr('id_curso').length>0)? $(this).attr('id_curso'): 'null' ;
                item['id_curso']=($(this).attr('id_curso')== 'null')? 'null': $(this).attr('id_curso') ;
                item['reemplazo']=($(this).find('td').eq(1).html().length>0)? $(this).find('td').eq(1).html(): 'null' ;
                item['situacion']= $(this).find('td').eq(3).html();
                item['objetivo_1']= $(this).find('td').eq(4).html();
                item['objetivo_2']= $(this).find('td').eq(5).html();
                item['objetivo_3']= $(this).find('td').eq(6).html();
                item['indicadores_exito']= $(this).find('td').eq(7).html();
                item['compromiso']= $(this).find('td').eq(8).html();
                item['id_tema']= $(this).find('td').eq(9).html();
                item['id_propuesta']=($(this).attr('id_propuesta'))? $(this).attr('id_propuesta') : "";
                item['operacion_curso']=$(this).attr('operacion_curso');
                jsonObjCursos.push(item);
            });


            if(globalOperacion=="insert"){ //se va a guardar una solicitud capacitacion nueva
                var data={  "accion":"cap_solic",
                            "operacion":"insert",
                            "datos":JSON.stringify(jsonObj),
                            "datosCursos":JSON.stringify(jsonObjCursos),
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

                            "estado": 'PENDIENTE',
                            "apr_solicito": $("#apr_solicito_id").val()

                        };
            }
            else{ //se va a guardar una solicitud editada
                var data={  "accion":"cap_solic",
                        "operacion":"save",
                        "id": globalId, //id de solicitud de capacitacion
                        "datos":JSON.stringify(jsonObj),
                        "datosCursos":JSON.stringify(jsonObjCursos),
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

                        "apr_solicito": $("#apr_solicito_id").val()
                    };

                }

            $.ajax({
                url:"index.php",
                data:data,
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(error){

                    $("#dialog-msn").dialog("open");
                    //$("#message").html("ha ocurrido un error");
                    $("#message").html(error.responseText);

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

            //Al hacer click en un link desactivado, evita que el foco se vaya para arriba
            $(document).on('click', '.link-desactivado',  function(e){e.preventDefault()});


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
                width: 700,
                modal:true,
                title:"Solicitud de Capacitación",
                buttons: [
                    {
                        class: "button-guardar",
                        text: "Guardar",
                        click: function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"cap_solic", operacion: "refreshGrid"});
                            }
                        }
                    },
                    {
                        class: "button-cancel",
                        text: "Cancelar",
                        click: function () {
                            $("#form")[0].reset(); //para limpiar los campos del formulario
                            $('#form').validate().resetForm(); //para limpiar los errores validate
                            $(":checked").removeAttr("checked"); //para limpiar los checkbox
                            //limpiar la tabla de asignaciones de planes
                            $('#table_plan tbody tr').each(function () {
                                $(this).remove();
                            });
                            $(this).dialog("close");
                        }
                    }
                ],
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
                   $(":checked").removeAttr("checked"); //para limpiar los checkbox
                   //limpiar la tabla de asignaciones de planes y tabla de cursos propuestos
                   $('#table_plan tbody tr').each(function(){ $(this).remove(); });
                   $('#table_curso tbody tr').each(function(){ $(this).remove(); });

                    //Vuelve a habilitar el link new plan, por si fue desactivado
                   $('#new-plan').removeClass('link-desactivado').addClass('new-plan-link');
                   $('#new-propuesta').removeClass('link-desactivado').addClass('new-propuesta-link');
                   $(":input").attr("disabled", false); //para volver a habilitar todos los campor, por si fueron deshabilitados
                }


            });


            //******************************************************************************************
            //Funcionalidad para la tabla de asignar planes
            $('#asignar_plan').dialog({
                autoOpen: false,
                width: 500,
                modal:true,
                title:"Agignar capacitación",
                buttons: {
                    "Guardar": function() {
                        if($("#form_plan").valid()){
                            //alert('form plan');

                            // si se trata de un update
                            if($('#asignar_plan').data('operacion')=='editar'){
                                var row_index=$('#asignar_plan').data('row_index');
                                //console.log($('#asignar_plan').data('operacion'));
                                //Cambio el atributo id_plan del tr por el del plan que eligio el usuario
                                $('#table_plan tbody').find('tr').eq(row_index).attr('id_plan',$("#np_plan_capacitacion_id").val());
                                $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(0).html($('#np_plan_capacitacion').val());
                                $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(1).html($('#np_comentarios').val());
                                $('#table_plan tbody').find('tr').eq(row_index).find('td').eq(4).html($('#np_viaticos').val());
                                $("#form_plan")[0].reset();
                                $(this).dialog("close");

                            }
                            else{  //si se trata de un insert

                                //Se agrega fila a la tabla de planes
                                //$('#table_plan tr:last').after('<tr>' +
                                $('#table_plan tbody').append('<tr id_plan='+$("#np_plan_capacitacion_id").val()+'>' +
                                '<td>'+$('#np_plan_capacitacion').val()+'</td>' +
                                '<td style="display: none">'+$('#np_comentarios').val()+'</td>' +
                                '<td>'+$('#np_plan_capacitacion_duracion').val()+'</td>' +
                                '<td>'+$('#np_plan_capacitacion_costo').val()+'</td>' +
                                '<td style="text-align: center">'+$('#np_viaticos').val()+'</td>' +
                                '<td style="text-align: center"><a class="editar_plan" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                                '<td style="text-align: center"><a class="eliminar_plan" href="#"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                                '</tr>');
                                $("#form_plan")[0].reset();

                            }

                        }

                    },
                    "Cancelar": function() {
                        $("#form_plan")[0].reset(); //para limpiar el formulario
                        $('#form_plan').validate().resetForm(); //para limpiar los errores validate
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
                    $('#form_plan').validate().resetForm(); //para limpiar los errores validate
                }

            });

            //Al presionar la x para eliminar planes de la solicitud
            $(document).on("click",".eliminar_plan",function(e){
                //pregunta si la fila tiene el atributo id_asignacion.
                //Si lo tiene=> viene de la BD. Sino=> se acaba de agregar dinamicamente y estan solo en memoria
                if($(this).closest('tr').attr('id_asignacion')){
                    //alert('esta fila viene de la BD');
                    $(this).closest('tr').attr('operacion_asignacion', 'delete');
                    $(this).closest('tr').toggle(); //oculta la fila, pero no la elimina
                }else{

                    $(this).closest('tr').remove(); //elimina la fila
                }
                e.preventDefault(); //para evitar que suba el foco al eliminar un plan

            });

            //Al presionar el lapiz para editar los planes de la solicitud
            $(document).on("click",".editar_plan",function(){
                //alert($(this).closest('tr').attr('id_asignacion'));
                $(this).closest('tr').attr('operacion_asignacion', 'update');
                $('#np_plan_capacitacion_id').val($(this).closest('tr').attr('id_plan'));
                $('#np_plan_capacitacion').val($(this).closest('tr').find('td').eq(0).html());
                $('#np_comentarios').val($(this).closest('tr').find('td').eq(1).html());
                $('#np_viaticos').val($(this).closest('tr').find('td').eq(4).html());
                //Guardo en row_index el identificador de la fila y luego envio ese identificador y la operacion
                //con el metodo .data() en formato json.
                var row_index=$(this).closest('tr').index();
                $('#asignar_plan').data({'row_index':row_index, 'operacion':'editar'}).dialog('open');
                $('#np_plan_capacitacion').attr('readonly', true); //Deshabilita el campo plan_capacitacion
                return false;

            });


            // new plan link
            $(document).on('click', '.new-plan-link', function(){
                //$('#asignar_plan').dialog('open');
                $('#asignar_plan').data('operacion', 'insert').dialog('open');
                $('#np_plan_capacitacion').attr('readonly', false); //Vuelve a habilitar el campo plan_capacitacion
                return false;
            });

            // new propuesta link
            $(document).on('click', '.new-propuesta-link', function(){
                //$('#asignar_plan').dialog('open');
                $('#proponer_curso').data('operacion', 'insert').dialog('open');
                //$('#np_plan_capacitacion').attr('readonly', false); //Vuelve a habilitar el campo plan_capacitacion
                return false;
            });


            //Agregado para autocompletar planes
            $("#np_plan_capacitacion").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"cap_solic", "operacion":"autocompletar_planes", "id_solicitud": globalId},
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.NOMBRE+' - '+item.FECHA_DESDE+' - '+item.MODALIDAD,
                                    id: item.ID_PLAN,
                                    duracion: item.DURACION+' '+item.UNIDAD,
                                    costo: item.MONEDA+' '+item.IMPORTE
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                change: function(event, ui) {
                    $('#np_plan_capacitacion_id').val(ui.item? ui.item.id : '');
                    $('#np_plan_capacitacion').val(ui.item.label);
                    $('#np_plan_capacitacion_duracion').val(ui.item.duracion);
                    $('#np_plan_capacitacion_costo').val(ui.item.costo);
                }
            });


            //Agregado dario para autocompletar empleado reemplazo
            $("#nc_reemplazo").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"empleado", "operacion":"autocompletar_empleados", "target":"BYUSER"},
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
                change: function(event, ui) {
                    $('#nc_reemplazo_id').val(ui.item? ui.item.id : '');
                    $('#nc_reemplazo').val(ui.item.label);
                }
            });


            //Fin funcionalidad tabla asignar planes
            //---------------------------------------------------------------------------------------


            //********************************************************************************************
            //Funcionalidad para la tabla cursos propuestos


            //Agregado dario para autocompletar cursos
            $("#nc_curso").autocomplete({

                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"cap_plan", "operacion":"autocompletar_cursos_temas", "target":"BYPERIODO", "id_solicitud": globalId},
                        success: function(data) {

                            jsonObjTemas = [];
                            jsonObjCursos = [];
                            $('#table_curso tbody tr').each(function () {
                                itemT = $(this).find('td').eq(9).html();
                                itemC = $(this).attr('id_curso') ;
                                if($(this).attr('id_curso')== 'null') jsonObjTemas.push(itemT);
                                if($(this).attr('id_curso')!= 'null')jsonObjCursos.push(itemC);
                            });

                            response($.map(data, function(item) {

                                if( $.inArray(item.ID_CURSO, jsonObjCursos)==-1 && ($.inArray(item.ID_TEMA, jsonObjTemas)==-1 || item.TABLA=='CURSO')  ) { // ==-1 si no esta

                                    return {
                                        label: item.TABLA + ': ' + item.NOMBRE + ' ' + ((typeof(item.FECHA_DESDE) == 'undefined') ? '' : item.FECHA_DESDE) + '  ' + ((typeof(item.MODALIDAD) == 'undefined') ? '' : item.MODALIDAD) + '  ' + ((typeof(item.ENTIDAD) == 'undefined') ? '' : item.ENTIDAD),
                                        id_curso: item.ID_CURSO,
                                        id_tema: item.ID_TEMA
                                    };

                                }
                            }));
                        }
                    });
                },
                minLength: 0,
                change: function(event, ui) {
                    $('#nc_curso_id').val(ui.item? ui.item.id_curso : '');
                    $('#nc_tema_id').val(ui.item? ui.item.id_tema : '');
                    $('#nc_curso').val(ui.item.label);
                },
                open: function(){
                    $('.ui-autocomplete').css({'max-height': '200px', 'max-width': '407px', 'overflow-y': 'scroll', 'padding-right': '20px'} );

                }
            }).click(function() {
                $(this).autocomplete("search", $(this).val());
            });



            $('#proponer_curso').dialog({
                autoOpen: false,
                width: 550,
                modal:true,
                title:"Proponer capacitación",
                buttons: [{
                    class: "button-save",
                    text: "Guardar",
                    click: function() {
                        if($("#form_curso").valid()){
                            //alert('form plan');

                            // si se trata de un update
                            if($('#proponer_curso').data('operacion')=='editar'){
                                var row_index=$('#proponer_curso').data('row_index');
                                var id_curso= ($("#nc_curso_id").val()=='')? 'null' : $("#nc_curso_id").val();
                                //Cambio el atributo id_plan del tr por el del plan que eligio el usuario
                                $('#table_curso tbody').find('tr').eq(row_index).attr('id_curso',id_curso);
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(0).html($('#nc_curso').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(1).html($('#nc_reemplazo_id').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(2).html($('#nc_reemplazo').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(3).html($('#nc_situacion').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(4).html($('#nc_objetivo_1').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(5).html($('#nc_objetivo_2').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(6).html($('#nc_objetivo_3').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(7).html($('#nc_indicadores_exito').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(8).html($('#nc_compromiso').val());
                                $('#table_curso tbody').find('tr').eq(row_index).find('td').eq(9).html($('#nc_tema_id').val());
                                $("#form_curso")[0].reset();
                                //Agregado 25/08/15
                                $('#table_curso tbody tr:eq('+row_index+')').attr('operacion_curso', 'update'); //Se coloca aca para que solo ponga el attr "update" cuando el usuario guarda los cambios

                                $(this).dialog("close");

                            }
                            else{  //si se trata de un insert

                                //Se agrega fila a la tabla de planes
                                //$('#table_plan tr:last').after('<tr>' +
                                var id_curso= ($("#nc_curso_id").val()=='')? 'null' : $("#nc_curso_id").val();
                                $('#table_curso tbody').append('<tr id_curso='+id_curso+'>' +
                                '<td>'+$('#nc_curso').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_reemplazo_id').val()+'</td>' +
                                '<td>'+$('#nc_reemplazo').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_situacion').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_objetivo_1').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_objetivo_2').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_objetivo_3').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_indicadores_exito').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_compromiso').val()+'</td>' +
                                '<td style="display: none">'+$('#nc_tema_id').val()+'</td>' +

                                '<td style="text-align: center"><a class="editar_curso" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                                '<td style="text-align: center"><a class="eliminar_curso" href="#"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                                '</tr>');
                                $("#form_curso")[0].reset();

                            }

                        }

                    }
                },
                    {
                        class: "button-cancel",
                        text: "Cancelar",
                        click: function() {
                            $("#form_curso")[0].reset(); //para limpiar el formulario
                            $('#form_curso').validate().resetForm(); //para limpiar los errores validate
                            $(this).dialog("close");
                        }
                }],
                show: {
                    effect: "blind",
                    duration: 300
                },
                hide: {
                    effect: "explode",
                    duration: 300
                },
                close:function(){
                    $("#form_curso")[0].reset(); //para limpiar el formulario cuando sale con x
                    $('#form_curso').validate().resetForm(); //para limpiar los errores validate
                    $('#nc_curso').attr('readonly', false);
                }

            });

            //Al presionar la x para eliminar cursos propuestos de la solicitud
            $(document).on("click",".eliminar_curso",function(e){
                //pregunta si la fila tiene el atributo id_propuesta.
                //Si lo tiene=> viene de la BD. Sino=> se acaba de agregar dinamicamente y estan solo en memoria
                if($(this).closest('tr').attr('id_propuesta')){
                    $(this).closest('tr').attr('operacion_curso', 'delete');
                    $(this).closest('tr').toggle(); //oculta la fila, pero no la elimina
                }else{

                    $(this).closest('tr').remove(); //elimina la fila
                }
                e.preventDefault(); //para evitar que suba el foco al eliminar un plan

            });


            //Al presionar el lapiz para editar los cursos propuestos de la solicitud
            $(document).on("click",".editar_curso",function(){

                //$(this).closest('tr').attr('operacion_curso', 'update'); //Se elimina para que el atributo se ponga en "update" solo si el usuario acepta los cambios y no siempre
                $('#nc_curso_id').val($(this).closest('tr').attr('id_curso'));
                $('#nc_curso').val($(this).closest('tr').find('td').eq(0).html());
                $('#nc_reemplazo_id').val($(this).closest('tr').find('td').eq(1).html());
                $('#nc_reemplazo').val($(this).closest('tr').find('td').eq(2).html());
                $('#nc_situacion').val($(this).closest('tr').find('td').eq(3).html());
                $('#nc_objetivo_1').val($(this).closest('tr').find('td').eq(4).html()).change();
                $('#nc_objetivo_2').val($(this).closest('tr').find('td').eq(5).html()).change();
                $('#nc_objetivo_3').val($(this).closest('tr').find('td').eq(6).html()).change();
                $('#nc_indicadores_exito').val($(this).closest('tr').find('td').eq(7).html());
                $('#nc_compromiso').val($(this).closest('tr').find('td').eq(8).html());
                $('#nc_tema_id').val($(this).closest('tr').find('td').eq(9).html());

                //Guardo en row_index el identificador de la fila y luego envio ese identificador y la operacion con el metodo .data() en formato json.
                var row_index=$(this).closest('tr').index();
                //Verifico si la propuesta tiene asignacion, si es asi => el campo curso/tema se inhabilita
                ($(this).closest('tr').find('td').eq(10).html()!='')? $('#nc_curso').attr('readonly', true): $('#nc_curso').attr('readonly', false);
                $('#proponer_curso').data({'row_index':row_index, 'operacion':'editar'}).dialog('open');

                $('#nc_objetivo_1').change();
                $('#nc_objetivo_2').change();
                $('#nc_objetivo_3').change();

                return false;

            });

            //Fin funcionalidad cursos propuestos
            //-------------------------------------------------------------------------------------------------------


            //**************************************************************************************
            //Agregado dario para autocompletar empleados
            $("#empleado").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"empleado", "operacion":"autocompletar_empleados", "target":"BYUSER"},
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
                change: function(event, ui) {
                    $('#empleado_id').val(ui.item? ui.item.id : '');
                    $('#empleado').val(ui.item.label);
                }
            });

            //---------------------------------------------------------------------------------------------

            //Se envia llamada a dialogLink a abmCap_solicGrid.php

            //Para editar una solicitud de capacitacion
            $(document).on("click", ".edit_link", function(){
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id de la solicitud
                $('#dialog').dialog('open');
                $("#empleado").attr("readonly", true); //para no permitir editar el empleado

                //Rellenar el combo de periodos
                var per=$.periodos();
                $("#periodo").html('<option value="">Seleccione un periodo</option>');
                $.each(per, function(indice, val){
                    $("#periodo").append(new Option(val,val));
                });

                return false;
            });


            //Para ver una solicitud de capacitacion
            $(document).on("click", ".view_link", function(){
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                //No debe permitir editar ningun campo
                $('#new-plan').removeClass('new-plan-link').addClass('link-desactivado').click(function(e){e.preventDefault();});
                $('#new-propuesta').removeClass('new-propuesta-link').addClass('link-desactivado').click(function(e){e.preventDefault();});
                $(":input:not(.button-cancel)").attr("disabled", true);
                /* Agrego el periodo de la solicitud seleccionada al select */
                $("#periodo").html('<option value="'+$(this).attr("target")+'">'+$(this).attr("target")+'</option>');

                return false;
            });




            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );


            //llamada a funcion validar
            $.validar();
            $.validarPlan();
            $.validarCurso();

        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            /*lo pone en vacio, ya que por defecto es igual a hiddenn  (default: ":hidden"). Y asi evito que ignore el campo oculto http://jqueryvalidation.org/validate/ */
            ignore:"",
            rules: {
                periodo: {
                    required: true
                },
                empleado: {
                    required: true
                },
                empleado_id:{
                    required: function(item){return $('#empleado').val().length>0;}
                },
                situacion_actual: {
                    required: true,
                    maxlength: 500
                },
                situacion_deseada: {
                    required: true,
                    maxlength: 500
                },
                objetivo_medible_1: {
                    required: true,
                    maxlength: 150
                },
                objetivo_medible_2: {
                    required: true,
                    maxlength: 150
                },
                objetivo_medible_3:{
                    required: true,
                    maxlength: 150
                }

            },
            messages:{
                periodo: "Seleccione el periodo",
                empleado: "Seleccione un empleado",
                empleado_id: "Seleccione un empleado sugerido",
                situacion_actual: {
                    required: "Ingrese la situación actual",
                    maxlenth: "Máximo 500 caracteres"
                },
                situacion_deseada: {
                    required: "Ingrese la situación deseada",
                    maxlenth: "Máximo 500 caracteres"
                },
                objetivo_medible_1: {
                    required: "Ingrese el objetivo medible 1",
                    maxlenth: "Máximo 100 caracteres"
                },
                objetivo_medible_2: {
                    required: "Ingrese el objetivo medible 2",
                    maxlenth: "Máximo 100 caracteres"
                },
                objetivo_medible_3: {
                    required: "Ingrese el objetivo medible 3",
                    maxlenth: "Máximo 100 caracteres"
                }
            }

        });


    };


    $.validarPlan=function(){
        $('#form_plan').validate({
            ignore:"",
            rules: {
                np_plan_capacitacion: {
                    required: true
                },
                np_plan_capacitacion_id:{
                    required: function(item){return $('#np_plan_capacitacion').val().length>0;}
                },
                np_objetivo: {
                    maxlength: 100
                },
                np_comentarios: {
                    maxlength: 100
                },
                np_viaticos: {
                    number: true
                }

            },
            messages:{
                np_plan_capacitacion: "Seleccione un plan de capacitación",
                np_plan_capacitacion_id: "Seleccione un plan de capacitación sugerido",
                np_objetivo: "Máximo 100 caracteres",
                np_comentarios: "Máximo 100 caracteres"
            }

        });

    };


    $.validarCurso=function(){
        $('#form_curso').validate({
            ignore:"",
            rules: {
                nc_curso: {
                    required: true
                },
                /*nc_reemplazo: {
                    required: true
                },*/
                nc_reemplazo_id:{
                    required: function(item){return $('#nc_reemplazo').val().length>0;}
                },
                nc_curso_id:{
                    required: function(item){return $('#nc_curso').val().length>0 && $('#nc_tema_id').val().length<0 ;}
                },
                nc_situacion: {
                    required: true,
                    maxlength: 500
                },
                nc_objetivo_1: {
                    required: true,
                    maxlength: 150
                },
                nc_objetivo_2: {
                    required: true,
                    maxlength: 150
                },
                nc_objetivo_3: {
                    required: true,
                    maxlength: 150
                },
                nc_indicadores_exito: {
                    required: true,
                    maxlength: 500
                },
                nc_compromiso: {
                    required: true,
                    maxlength: 500
                }


            },
            messages:{
                nc_curso: "Seleccione un curso o tema",
                nc_curso_id: "Seleccione un curso o tema sugerido",
                nc_reemplazo_id: "Seleccione un empleado sugerido",
                nc_situacion: {
                    required: "Ingrese la situación",
                    maxlength: "Máximo 500 caracteres"
                },
                nc_objetivo_1: {
                    required: "Ingrese el objetivo 1",
                    maxlength: "Máximo 150 caracteres"
                },
                nc_objetivo_2: {
                    required: "Ingrese el objetivo 2",
                    maxlength: "Máximo 150 caracteres"
                },
                nc_objetivo_3: {
                    required: "Ingrese el objetivo 3",
                    maxlength: "Máximo 150 caracteres"
                },
                nc_indicadores_exito: {
                    required: "Ingrese los indicadores de éxito",
                    maxlength: "Máximo 500 caracteres"
                },
                nc_compromiso: {
                    required: "Ingrese el compromiso",
                    maxlenth: "Máximo 500 caracteres"
                }
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
                                    <label>Periodo: </label>
                                    <select name="periodo" id="periodo">
                                        <!--<option value="">Seleccione el periodo</option>
                                        <?php
                                        /*$periodos=Conexion::periodos();
                                        foreach ($periodos as $per){
                                            ?>
                                            <option value="<?php echo $per; ?>"><?php echo $per; ?></option>
                                        <?php
                                        } */
                                        ?> -->
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Colaborador: </label>
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
                                    <a id="new-propuesta" class="new-propuesta-link" href="#"><img src="public/img/add-icon.png" width="15px" height="15px"></a>
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
                                    <table id="table_curso" class="tablaSolicitud">
                                        <thead>
                                        <tr>
                                            <td style="width: 45%">Capacitación</td>
                                            <td style="width: 40%">Reemplazo</td>
                                            <td style="text-align: center">Editar</td>
                                            <td style="text-align: center">Eliminar</td>
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
                                    <label>Capacitaciones asignadas: </label><br/>
                                    <!--<a id="new-plan" class="new-plan-link" href="#"><img src="public/img/add-icon.png" width="15px" height="15px"></a>-->
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
                                    <table id="table_plan" class="tablaSolicitud">
                                        <thead>
                                            <tr>
                                                <td style="width: 55%">Capacitación</td>
                                                <td style="width: 10%">Duración</td>
                                                <td style="width: 10%">Imp. Un.</td>
                                                <td style="width: 10%">Viáticos</td>
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
                                    <label>Solicitó - Gerencia de área: </label><br/>
                                    <input type="text" name="apr_solicito" id="apr_solicito" readonly/>
                                    <input type="hidden" name="apr_solicito_id" id="apr_solicito_id" readonly/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <!--<label>Autorizó - Gerencia de RRHH: </label><br/>
                                    <input type="text" name="apr_autorizo" id="apr_autorizo" readonly/>-->
                                </div>
                            </div>
                        </div>

                        <!--<div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Aprobó - Dirección: </label><br/>
                                    <input type="text" name="apr_aprobo" id="apr_aprobo" readonly/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
                            </div>
                        </div>-->



                    </fieldset>

                </form>
            </div>
        </div>


    </div>

</div>


<!-- funcionalidad para proponer curso y hacer comunicacion -->
<div id="proponer_curso" >

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form_curso" action="">
                    <fieldset>
                        <!--<legend>Datos Registro</legend>-->

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Capacitación propuesta: </label><br/>
                                    <input type="text" name="nc_curso" id="nc_curso"/>
                                    <input type="hidden" name="nc_curso_id" id="nc_curso_id"/>
                                    <input type="hidden" name="nc_tema_id" id="nc_tema_id"/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Reemplazo: </label><br/>
                                    <input type="text" name="nc_reemplazo" id="nc_reemplazo"/>
                                    <input type="hidden" name="nc_reemplazo_id" id="nc_reemplazo_id"/>
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
                                    <label>Situación: Porque te vamos a capacitar</label><br/>
                                    <textarea type="text" name="nc_situacion" id="nc_situacion" rows="5"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivos: Que esperamos lograr con esto</label><br/>
                                    <textarea type="text" name="nc_objetivo_1" id="nc_objetivo_1" rows="1"/></textarea>
                                    <textarea type="text" name="nc_objetivo_2" id="nc_objetivo_2" rows="1"/></textarea>
                                    <textarea type="text" name="nc_objetivo_3" id="nc_objetivo_3" rows="1"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Indicadores de éxito:</label><br/>
                                    <textarea type="text" name="nc_indicadores_exito" id="nc_indicadores_exito" rows="5"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Compromiso:</label><br/>
                                    <textarea type="text" name="nc_compromiso" id="nc_compromiso" rows="5"/></textarea>
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
            <form id="form_plan" name="form_plan" action="">
                <fieldset>
                    <!--<legend>Datos Registro</legend>-->

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Capacitación asignada: </label><br/>
                                    <input type="text" name="np_plan_capacitacion" id="np_plan_capacitacion"/>
                                    <input type="hidden" name="np_plan_capacitacion_id" id="np_plan_capacitacion_id"/>
                                    <input type="hidden" name="np_plan_capacitacion_duracion" id="np_plan_capacitacion_duracion"/>
                                    <input type="hidden" name="np_plan_capacitacion_costo" id="np_plan_capacitacion_costo"/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Comentarios: </label>
                                    <textarea name="np_comentarios" id="np_comentarios" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Viaticos: </label><br/>
                                    <input type="text" name="np_viaticos" id="np_viaticos"/>
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