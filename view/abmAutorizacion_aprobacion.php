<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="public/js/jquery.validate.js"></script>

    <script type="text/javascript">
    var globalOperacion="";
    var globalId;
    var estadoSolicitud;


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

                    $("#apr_solicito").val(datas['solicitud'][0]['APELLIDO_SOLICITO']+' '+datas['solicitud'][0]['NOMBRE_SOLICITO']);

                    if(datas['solicitud'][0]['APELLIDO_AUTORIZO'] && datas['solicitud'][0]['NOMBRE_AUTORIZO']){ //Si el array autorizo tiene datos =>esta autorizada y se completan los campos.
                        $("#apr_autorizo").val(datas['solicitud'][0]['APELLIDO_AUTORIZO']+' '+datas['solicitud'][0]['NOMBRE_AUTORIZO']);
                        $("#apr_autorizo_id").val(datas['solicitud'][0]['ID_AUTORIZO']);
                        $('#btn_autorizar').attr("disabled", true);
                    }

                    if(datas['solicitud'][0]['APELLIDO_APROBO'] && datas['solicitud'][0]['NOMBRE_APROBO']){ //Si el array aprobo tiene datos =>esta aprobada y se completan los campos.
                        $("#apr_aprobo").val(datas['solicitud'][0]['APELLIDO_APROBO']+' '+datas['solicitud'][0]['NOMBRE_APROBO']);
                        $("#apr_aprobo_id").val(datas['solicitud'][0]['ID_APROBO']);
                        $('#btn_aprobar').attr("disabled", true);
                        $("#button-guardar").button("disable");
                    }



                    //Se construye la tabla de asignaciones de planes
                    $.each(datas['planes'], function(indice, val){

                        $('#table_plan tbody').append('<tr id_plan='+datas['planes'][indice]['ID_PLAN']+' '+'id_asignacion='+datas['planes'][indice]['ID_ASIGNACION']+'>' +
                        '<td>'+datas['planes'][indice]['NOMBRE']+'</td>' +
                        '<td>'+datas['planes'][indice]['FECHA_DESDE']+'</td>' +
                        '<td>'+datas['planes'][indice]['MODALIDAD']+'</td>' +
                        '<td>'+datas['planes'][indice]['DURACION']+" "+datas['planes'][indice]['UNIDAD']+'</td>' +
                        '<td>'+datas['planes'][indice]['MONEDA']+" "+datas['planes'][indice]['IMPORTE']+'</td>' +
                        '<td>'+'$ '+datas['planes'][indice]['VIATICOS']+'</td>' +
                        '</tr>');
                    });

                    //validaciones previas
                    //$("#importe").val(parseFloat(datas[0]['IMPORTE'].replace(/,/, '.')));
                    var viaticos= (datas['totales'][0]['VIATICOS'])? parseFloat(datas['totales'][0]['VIATICOS'].replace(/,/, '.')) : 0;
                    var pesos= (datas['totales'][0]['PESOS'])? parseFloat(datas['totales'][0]['PESOS'].replace(/,/, '.')) : 0;
                    var dolares= (datas['totales'][0]['DOLARES'])? parseFloat(datas['totales'][0]['DOLARES'].replace(/,/, '.')) : 0;
                    //alert(typeof(dolares))

                    //Genera el tfoot con los totales
                    $('#table_plan tfoot').append('<tr>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>Subtotal</td>' +
                    '<td>'+'$ '+(pesos+dolares)+'</td>' +
                    '<td>'+'$ '+viaticos+'</td>' +
                    '</tr>');

                    $('#table_plan tfoot').append('<tr>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td></td>' +
                    '<td>Total general</td>' +
                    '<td colspan="2" style="text-align:center">'+'$ '+(pesos+dolares+viaticos)+'</td>' +
                    //'<td></td>' +
                    '</tr>');


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
                        "apr_aprobo":($("#apr_aprobo_id").length >0)? $("#apr_aprobo_id").val() : '',   //$("#apr_aprobo_id").val(),
                        "estado": ($("#apr_aprobo_id").length && $("#apr_aprobo_id").val()!='' )? 'APROBADA':'AUTORIZADA'
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

            $(document).tooltip();


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
                buttons: [
                    {
                        id: "button-guardar",
                        text: "Guardar",
                        click: function() {
                            if($("#form").valid()){ //OJO valid() devuelve un booleano
                                guardar();
                                $("#dialog").dialog("close");
                                //Llamada ajax para refrescar la grilla
                                $('#principal').load('index.php',{accion:"autorizacion_aprobacion", operacion: "refreshGrid"});
                            }

                        }
                    },
                    {
                        id: "button-cancelar",
                        text: "Cancelar",
                        click: function() {
                            //$("#form")[0].reset(); //para limpiar los campos del formulario
                            $(":input:not([type=button])").val(''); //limpia los campos, incluso los ocultos (la sentencia de arriba no limpia ocultos)
                            $('#form').validate().resetForm(); //para limpiar los errores validate
                            //limpiar la tabla de asignaciones de planes
                            $('#table_plan tbody tr').each(function(){ $(this).remove(); });
                            $('#table_plan tfoot tr').each(function(){ $(this).remove(); });
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
                   //$("#form")[0].reset(); //para limpiar los campos del formulario cuando sale con la x
                   $(":input:not([type=button])").val(''); //limpia los campos, incluso los ocultos (la sentencia de arriba no limpia ocultos)
                   $('#form').validate().resetForm(); //para limpiar los errores validate
                   //limpiar la tabla de asignaciones de planes y tabla de cursos propuestos
                   $('#table_plan tbody tr').each(function(){ $(this).remove(); });
                   $('#table_plan tfoot tr').each(function(){ $(this).remove(); });
                }


            });


            //Al hacer click en el boton btn_autorizar
            $(document).on("click", "#btn_autorizar", function(){

                $("#apr_autorizo").val('<?php echo $_SESSION['USER_APELLIDO']." ".$_SESSION['USER_NOMBRE']; ?>');
                $("#apr_autorizo_id").val('<?php echo $_SESSION['USER_ID_EMPLEADO']; ?>');
                estadoSolicitud='AUTORIZADA';
                //alert($("#apr_autorizo_id").val());

            });


            //Al hacer click en el boton btn_aprobar
            $(document).on("click", "#btn_aprobar", function(){

                $("#apr_aprobo").val('<?php echo $_SESSION['USER_APELLIDO']." ".$_SESSION['USER_NOMBRE']; ?>');
                $("#apr_aprobo_id").val('<?php echo $_SESSION['USER_ID_EMPLEADO']; ?>');
                estadoSolicitud='APROBADA';

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
                $("#button-guardar").button("enable");
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
                                                <td>Fecha inicio</td>
                                                <td>Modalidad</td>
                                                <td>Duración</td>
                                                <td>Costo</td>
                                                <td>Viaticos</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!-- el cuerpo se genera dinamicamente con javascript -->
                                        </tbody>
                                        <tfoot>
                                        <!-- el foot se genera dinamicamente con javascript con los totales-->
                                        </tfoot>
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


                        <!--Seccion para APROBAR la solicitud -->
                        <?php if($_SESSION['ACCESSLEVEL']==1){ ?>

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

                        <?   } ?>


                    </fieldset>

                </form>
            </div>
        </div>


    </div>

</div>







</body>
</html>