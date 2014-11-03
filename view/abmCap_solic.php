<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="public/js/jquery.validate.js"></script>

    <script type="text/javascript">
    var globalOperacion="";
    var globalId;


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
            if($("#periodo").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un periodo");
                return false;
            }

            if($("#empleado").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un empleado");
                return false;
            }

            if($("#situacion_actual").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la situación actual");
                return false;
            }

            if($("#situacion_deseada").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la situación deseada");
                return false;
            }

            if($("#objetivo_medible_1").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el objetivo medible 1");
                return false;
            }

            if($("#objetivo_medible_2").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el objetivo medible 2");
                return false;
            }

            if($("#objetivo_medible_3").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el objetivo medible 3");
                return false;
            }

            */

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
                "sScrollY": 200,
                //"scrollX": true,
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
                        guardar();

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar el formulario
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
                    $("#form")[0].reset(); //para limpiar el formulario cuando sale con x
                }
                /*
                ,open: function(){
                    alert(globalOperacion);
                    alert(globalId);
                }*/
                //fin agregado dario

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

                        //validacion


                        //se agrega la funcionalidad
                        //$('#table_plan tr:last').after('<tr>' +
                        $('#table_plan tbody').append('<tr id_plan='+$("#np_plan_capacitacion_id").val()+'>' +
                                                            '<td>'+$('#np_plan_capacitacion').val()+'</td>' +
                                                            '<td>'+$('#np_objetivo').val()+'</td>' +
                                                            '<td>'+$('#np_comentarios').val()+'</td>' +
                                                            '<td>'+$('#np_viaticos').val()+'</td>' +
                                                            '<td><a class="eliminar" href="#" id="1"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                                                        '</tr>');
                        $("#form_plan")[0].reset();

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


            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().parents().get(0);
                alert($(this).attr("id"));
                $(parent).remove();
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

            //fin agregado
            //---------------------------------------------------------------------------------------------

            // Dialog Link
            $('#dialog_link').click(function(){
                globalOperacion=$(this).attr("media");
                $('#dialog').dialog('open');
                $("#curso").attr("readonly", false);
                return false;
            });

            //Agregado por dario para editar

            $(document).on("click", ".edit_link", function(){
                globalOperacion=$(this).attr("media");
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                $("#curso").attr("readonly", true); //para no permitir editar el curso
                //alert("funciona el link edit");
                return false;
            });
            //Fin agregado


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



        });
    </script>

</head>


<body>

<div id="principal">

    <div class="container_10">

        <header>

            <div class="clear"></div>

            <div class="grid_10">

            </div>

        </header>

        <div class="grid_10">
            <div class="box">
                <h2>
                    <a href="#" id="toggle-list">Lista de Solicitudes de Capacitación</a>
                </h2>


                <div class="block" id="list">
                    <a href="javascript:void(0);" id="dialog_link" media="insert">Agregar solicitud capacitación</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Periodo</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th>Duracion</th>
                            <th>Unidad</th>
                            <th>Estado</th>
                            <th>Importe</th>
                            <th>Moneda</th>
                            <th>Cant.</th>
                            <th width="12%">Editar</th>
                            <th width="12%">Eliminar</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Curso</th>
                            <th>Periodo</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th>Duracion</th>
                            <th>Unidad</th>
                            <th>Estado</th>
                            <th>Importe</th>
                            <th>Moneda</th>
                            <th>Cant.</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($view->cp as $plan) {?>
                            <tr class="odd gradeA">
                                <td><?php  echo Conexion::corta_palabra($plan["NOMBRE"], 20)."...";  ?></td>
                                <td><?php  echo $plan["PERIODO"] ?></td>
                                <td><?php  echo $plan["FECHA_DESDE"]; ?></td>
                                <td><?php  echo $plan["FECHA_HASTA"]; ?></td>
                                <td><?php  echo $plan["DURACION"]; ?></td>
                                <td><?php  echo $plan["UNIDAD"]; ?></td>
                                <td><?php  echo $plan["ESTADO"]; ?></td>
                                <td><?php  echo $plan["IMPORTE"]; ?></td>
                                <td><?php  echo $plan["MONEDA"]; ?></td>
                                <td><?php  echo $plan["CANTIDAD"]; ?></td>
                                <td class="center"><a href="javascript: void(0);" media="edit" class="edit_link" id="<?php  echo $plan["ID_PLAN"];  ?>">Editar</a></td>
                                <td class="cen  ter"><a href="">Eliminar</a></td>
                            </tr>
                        <?php }  ?>

                        </tbody>
                    </table>
                </div>


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
                                        <option value="0">Ingrese el periodo</option>
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
                                    <input type="text" name="profesor_1" id="profesor_1"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Gerencia de área: </label>
                                    <input type="text" name="profesor_2" id="profesor_2"/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Autorizó: </label><br/>
                                    <input type="text" name="profesor_1" id="profesor_1"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Gerencia de RRHH: </label>
                                    <input type="text" name="profesor_2" id="profesor_2"/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Aprobación: </label><br/>
                                    <input type="text" name="profesor_1" id="profesor_1"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Dirección: </label>
                                    <input type="text" name="profesor_2" id="profesor_2"/>
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