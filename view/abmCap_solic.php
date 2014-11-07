<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="public/js/jquery.validate.js"></script>

    <script type="text/javascript">
    var globalOperacion="";
    var globalId;

    var globalOperacionPlan="";
    var globalIdPlan="";


        function editar(id_plan){
                //alert(id_plan);

            $.ajax({
                url:"index.php",
                data:{"accion":"cap_plan","operacion":"update","id":id_plan},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){
                    $("#curso").val(datas[0]['NOMBRE']);
                    $("#periodo").val(datas[0]['PERIODO']);
                    $("#objetivo").val(datas[0]['OBJETIVO']);
                    $("#modalidad").val(datas[0]['MODALIDAD']);
                    $("#fecha_desde").val(datas[0]['FECHA_DESDE']);
                    $("#fecha_hasta").val(datas[0]['FECHA_HASTA']);
                    $("#duracion").val(datas[0]['DURACION']);
                    $("#unidad").val(datas[0]['UNIDAD']);
                    $("#prioridad").val(datas[0]['PRIORIDAD']);
                    $("#estado").val(datas[0]['ESTADO']);
                    $("#importe").val(datas[0]['IMPORTE']);
                    $("#moneda").val(datas[0]['MONEDA']);
                    $("#tipo_cambio").val(datas[0]['TIPO_CAMBIO']);
                    $("#forma_pago").val(datas[0]['FORMA_PAGO']);
                    $("#forma_financiacion").val(datas[0]['FORMA_FINANCIACION']);
                    $("#profesor_1").val(datas[0]['PROFESOR_1']);
                    $("#profesor_2").val(datas[0]['PROFESOR_2']);
                    $("#comentarios").val(datas[0]['COMENTARIOS_PLAN']);
                    //cargarTemas(datas[5]);


                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            /*
            if(globalOperacion=="insert"){ //se va a guardar un curso nuevo
                var url="index.php";
                var data={  "accion":"cap_plan",
                            "operacion":"insert",
                            "curso":$("#curso_id").val(),
                            "periodo":$("#periodo").val(),
                            "objetivo":$("#objetivo").val()

                        };
            }
            else{ //se va a guardar un curso editado
                var data={  "accion":"cap_plan",
                            "operacion":"save",
                            "id":globalId,
                            //"curso":$("#curso").val(),
                            "periodo":$("#periodo").val(),
                            "objetivo":$("#objetivo").val()

                        };
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

            });     */

            //****************************************************************************
            //Codigo para insertar tabla dinamica

            jsonObj = [];
            $('#table_plan tbody tr').each(function () {
                item = {};
                item['id_plan']=$(this).attr('id_plan');
                item['objetivo']= $(this).find('td').eq(1).html();
                item['comentarios']= $(this).find('td').eq(2).html();
                item['viaticos']= $(this).find('td').eq(3).html();
                //alert(item['id_plan'])
                jsonObj.push(item);

            });

            $.ajax({
                url:"index.php",
                data:{"accion":"cap_solic","operacion":"insert_planes","datos":JSON.stringify(jsonObj)},
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
                        alert("registros ingresados ok");
                    }

                    $("#dialog").dialog("close");
                    //Agregado por dario para recargar grilla al modificar o insertar
                    self.parent.location.reload();

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });









            //fin codigo insertar tabla dinamica
            //-----------------------------------------------------------------------------

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


            // dataTable
            var uTable = $('#example').dataTable( {
                "scrollY": "200px",
                "scrollX": true,
                "autoWidth": true,
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
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            //$('#principal').load('index.php',{accion:"cap_plan", operacion: "refreshGrid"});
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


            //******************************************************************************************
            //Funcionalidad para la tabla de asignar planes
            $('#asignar_plan').dialog({
                autoOpen: false,
                width: 500,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Agregar": function() {

                        if(globalOperacionPlan=='editar'){

                            //$('#np_plan_capacitacion_id').val($(this).parent().parent().attr('id_plan'));
                            //$(this).parent().parent().find('td').eq(0).html(('#np_plan_capacitacion').val());
                            $(this).child().child().find('td').eq(1).html(('#np_objetivo').val());
                            //$('#np_comentarios').val($(this).parent().parent().find('td').eq(2).html());
                            //$('#np_viaticos').val($(this).parent().parent().find('td').eq(3).html());

                        }
                        else{

                            //se agrega la funcionalidad
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
                        $("#form")[0].reset(); //para limpiar el formulario
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
                var parent = $(this).parents().parents().get(0);
                //alert($(this).attr("id"));
                $(parent).remove();
            });

            //Al presionar el lapiz para editar los planes de la solicitud
            $(document).on("click",".editar_plan",function(){
                $('#asignar_plan').dialog('open');

                //probando
                //subo hasta el tr
                globalOperacionPlan='editar';
                $('#np_plan_capacitacion_id').val($(this).parent().parent().attr('id_plan'));
                $('#np_plan_capacitacion').val($(this).parent().parent().find('td').eq(0).html());
                $('#np_objetivo').val($(this).parent().parent().find('td').eq(1).html());
                $('#np_comentarios').val($(this).parent().parent().find('td').eq(2).html());
                $('#np_viaticos').val($(this).parent().parent().find('td').eq(3).html());

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

            // Dialog Link
            $('#dialog_link').click(function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='insert';
                $('#dialog').dialog('open');
                $("#curso").attr("readonly", false);
                return false;
            });

            //Agregado por dario para editar
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                $("#curso").attr("readonly", true); //para no permitir editar el curso
                return false;
            });


            // new plan link
            $('#new-plan-link').click(function(){
                $('#asignar_plan').dialog('open');
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
                    required: true,
                    number: true
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

    <div class="container_10">

        <header>

            <div class="clear"></div>


        </header>


            <div class="box">
                <h2>
                    <a href="#" id="toggle-list">Lista de Solicitudes de Capacitación</a>
                </h2>


                <div class="block" id="list">
                    <a href="javascript:void(0);" id="dialog_link">Agregar solicitud capacitación</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                        <tr>

                            <th>Fecha solicitud</th>
                            <th>Periodo</th>
                            <th>Empleado</th>
                            <th>Solicitante</th>
                            <th>Editar</th>
                            <th>Eliminar</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Fecha solicitud</th>
                            <th>Periodo</th>
                            <th>Empleado</th>
                            <th>Solicitante</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($view->cs as $sol) {?>
                            <tr class="odd gradeA">
                                <td><?php  echo $sol["FECHA_SOLICITUD"]; ?></td>
                                <td><?php  echo $sol["PERIODO"]; ?></td>
                                <td><?php  echo $sol["APELLIDO"]." ".$sol["NOMBRE"]; ?></td>
                                <td><?php  echo $sol["APR_SOLICITO"]; ?></td>
                                <td class="center"><a href="javascript: void(0);" class="edit_link" id="<?php  echo $sol["ID_SOLICITUD"];  ?>">Editar</a></td>
                                <td class="cen  ter"><a href="">Eliminar</a></td>
                            </tr>
                        <?php }  ?>

                        </tbody>
                    </table>
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
                                        <div class="check"><input type="checkbox" /></div>
                                        <div class="lab">Ingreso</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" /></div>
                                        <div class="lab">Crecimiento</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" /></div>
                                        <div class="lab">Promoción</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" /></div>
                                        <div class="lab">Futura transfer.</div>
                                    </div>

                                    <div class="cbcheck">
                                        <div class="check"><input type="checkbox" /></div>
                                        <div class="lab">Sustitución temporal</div>
                                    </div>
                            </div>


                            <div class="checkboxes">
                                <div class="cbtitulo">Desarrollo institucional:</div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" /></div>
                                    <div class="lab">Nuevas tecnicas/procesos</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" /></div>
                                    <div class="lab">Crecimiento/diversificación</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" /></div>
                                    <div class="lab">Des. cometencias empresa</div>
                                </div>
                            </div>


                            <div class="checkboxes">
                                <div class="cbtitulo">Respuesta a problema:</div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" /></div>
                                    <div class="lab">Falta de competencias</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" /></div>
                                    <div class="lab">No conformidad</div>
                                </div>

                                <div class="cbcheck">
                                    <div class="check"><input type="checkbox" /></div>
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