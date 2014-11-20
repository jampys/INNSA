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
                data:{"accion":"autorizacion_aprobacion","operacion":"update","id":id_plan},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#apr_solicito").val(datas['solicito'][0]['APELLIDO']+' '+datas['solicito'][0]['NOMBRE']);

                    if(datas['autorizo'].length!=0){ //Si el array autorizo tiene datos =>esta autorizada y se completan los campos.
                        $("#apr_autorizo").val(datas['autorizo'][0]['APELLIDO']+' '+datas['autorizo'][0]['NOMBRE']);
                        $("#apr_autorizo_id").val(datas['autorizo'][0]['APR_AUTORIZO']);
                        $('#btn_autorizar').attr("disabled", true);
                    }

                    if(datas['aprobo'].length!=0){ //Si el array aprobo tiene datos =>esta autorizada y se completan los campos.
                        $("#apr_aprobo").val(datas['aprobo'][0]['APELLIDO']+' '+datas['aprobo'][0]['NOMBRE']);
                        $("#apr_autorizo_id").val(datas['aprobo'][0]['APR_APROBO']);
                        $('#btn_aprobar').attr("disabled", true);
                    }



                    //Se construye la tabla de asignaciones de planes
                    $.each(datas['planes'], function(indice, val){

                        $('#table_plan tbody').append('<tr id_plan='+datas['planes'][indice]['ID_PLAN']+' '+'id_asignacion='+datas['planes'][indice]['ID_ASIGNACION']+'>' +
                        '<td>'+datas['planes'][indice]['NOMBRE']+" - "+datas['planes'][indice]['FECHA_DESDE']+" - "+datas['planes'][indice]['MODALIDAD']+'</td>' +
                        '<td>'+datas['planes'][indice]['DURACION']+" "+datas['planes'][indice]['UNIDAD']+'</td>' +
                        '<td>'+datas['planes'][indice]['MONEDA']+" "+datas['planes'][indice]['IMPORTE']+'</td>' +
                        '<td>'+datas['planes'][indice]['VIATICOS']+'</td>' +
                        '</tr>');
                    });

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            var data={  "accion":"autorizacion_aprobacion",
                        "operacion":"save",
                        "id": globalId,
                        "apr_autorizo": $("#apr_autorizo_id").val(),
                        "apr_aprobo": $("#apr_aprobo_id").val(),
                        "estado": ($("#apr_aprobo_id").val()=='')? 'AUTORIZADA':'APROBADA'
                    };

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
                width: 900,
                modal:true,
                title:"Autorizar/Aprobar Solicitud de capacitación",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"autorizacion_aprobacion", operacion: "refreshGrid"});
                        }

                    },
                    "Cancelar": function() {
                        //$("#form")[0].reset(); //para limpiar los campos del formulario
                        $(":input:not([type=button])").val(''); //limpia los campos, incluso los ocultos (la sentencia de arriba no limpia ocultos)
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
                   //$("#form")[0].reset(); //para limpiar los campos del formulario cuando sale con la x
                   $(":input:not([type=button])").val(''); //limpia los campos, incluso los ocultos (la sentencia de arriba no limpia ocultos)
                   $('#form').validate().resetForm(); //para limpiar los errores validate
                   //limpiar la tabla de asignaciones de planes y tabla de cursos propuestos
                   $('#table_plan tbody tr').each(function(){ $(this).remove(); });
                   $('#table_curso tbody tr').each(function(){ $(this).remove(); });
                }


            });


            //Al hacer click en el boton btn_autorizar
            $(document).on("click", "#btn_autorizar", function(){

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

                            $("#apr_autorizo").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                            $("#apr_autorizo_id").val(datas[0]['ID_EMPLEADO']);

                        },
                        type:"POST",
                        timeout:3000000,
                        crossdomain:true

                    });


                return false;
            });


            //Al hacer click en el boton btn_aprobar
            $(document).on("click", "#btn_aprobar", function(){

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

                        $("#apr_aprobo").val(datas[0]['APELLIDO']+' '+datas[0]['NOMBRE']);
                        $("#apr_aprobo_id").val(datas[0]['ID_EMPLEADO']);

                    },
                    type:"POST",
                    timeout:3000000,
                    crossdomain:true

                });


                return false;
            });



            //Se envia llamada a dialogLink a abmCap_solicGrid.php

            //Para editar una solicitud de capacitacion
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                $('#btn_autorizar').attr("disabled", false);
                $('#btn_aprobar').attr("disabled", false);
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

        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            rules: {
                apr_solicito:{
                    required: true
                }

            },
            messages:{
                apr_solicito: "Ingrese el solicitante"

            }

        });


    };


    $.validarPlan=function(){
        $('#form_plan').validate({
            rules: {
                np_plan_capacitacion: {
                    required: true
                },
                np_viaticos: {
                    required: true,
                    number: true
                }

            },
            messages:{
                np_plan_capacitacion: "Seleccione un plan de capacitación",
                np_viaticos: "Ingrese los viaticos"
            }

        });


    };


    </script>

    <style type="text/css">
        #table_plan tr td {
            text-align: left;
        }
    </style>

</head>


<body>

<div id="principal">

<!-- Se incluye llamada a abmCapSolicGrid.php -->
    <?php require_once('abmAutorizacion_aprobacionGrid.php');?>

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
                                    <label>Planes asignados: </label><br/>
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
                                                <td>Plan</td>
                                                <td>Duración</td>
                                                <td>Costo</td>
                                                <td>Viaticos</td>
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
                            <div class="five column">
                                <div class="column_content">
                                    <label>Solicitó - Gerencia de área: </label><br/>
                                    <input type="text" name="apr_solicito" id="apr_solicito" readonly/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="four column">
                                <div class="column_content">
                                    <label>Autorizó - Gerencia de RRHH: </label><br/>
                                    <input type="text" name="apr_autorizo" id="apr_autorizo" readonly/>
                                    <input type="hidden" name="apr_autorizo_id" id="apr_autorizo_id"/>
                                </div>
                            </div>
                            <div class="one column">
                                <div class="column_content">
                                    <label> </label><br/>
                                    <input type="button" name="btn_autorizar" id="btn_autorizar" value="Autorizar">
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="four column">
                                <div class="column_content">
                                    <label>Aprobó - Dirección: </label><br/>
                                    <input type="text" name="apr_aprobo" id="apr_aprobo" readonly/>
                                    <input type="hidden" name="apr_aprobo_id" id="apr_aprobo_id"/>
                                </div>
                            </div>
                            <div class="one column">
                                <div class="column_content">
                                    <label> </label><br/>
                                    <input type="button" name="btn_aprobar" id="btn_aprobar" value="Aprobar">
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

</div>







</body>
</html>