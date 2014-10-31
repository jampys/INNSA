<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />

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
            if($("#curso").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un curso");
                return false;
            }

            if($("#periodo").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un periodo");
                return false;
            }

            if($("#modalidad").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar una modalidad");
                return false;
            }

            if($("#fecha_desde").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la fecha de inicio");
                return false;
            }

            if($("#fecha_hasta").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la fecha de finalización");
                return false;
            }

            if($("#duracion").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la duración");
                return false;
            }

            if($("#unidad").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la unidad de duración");
                return false;
            }

            if($("#prioridad").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la prioridad");
                return false;
            }

            if($("#estado").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el estado");
                return false;
            }

            if($("#importe").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el importe");
                return false;
            }

            if($("#moneda").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la moneda");
                return false;
            }

            if($("#tipo_cambio").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el tipo de cambio");
                return false;
            }

            if(globalOperacion=="insert"){ //se va a guardar un curso nuevo
                var url="index.php";
                var data={  "accion":"cap_plan",
                            "operacion":"insert",
                            "curso":$("#curso_id").val(),
                            "periodo":$("#periodo").val(),
                            "objetivo":$("#objetivo").val(),
                            "modalidad":$("#modalidad").val(),
                            "fecha_desde":$("#fecha_desde").val(),
                            "fecha_hasta":$("#fecha_hasta").val(),
                            "duracion":$("#duracion").val(),
                            "unidad":$("#unidad").val(),
                            "prioridad":$("#prioridad").val(),
                            "estado":$("#estado").val(),
                            "importe":$("#importe").val(),
                            "moneda":$("#moneda").val(),
                            "tipo_cambio":$("#tipo_cambio").val(),
                            "forma_pago":$("#forma_pago").val(),
                            "forma_financiacion":$("#forma_financiacion").val(),
                            "profesor_1":$("#profesor_1").val(),
                            "profesor_2":$("#profesor_2").val(),
                            "comentarios":$("#comentarios").val()};
            }
            else{ //se va a guardar un curso editado
                var data={  "accion":"cap_plan",
                            "operacion":"save",
                            "id":globalId,
                            //"curso":$("#curso").val(),
                            "periodo":$("#periodo").val(),
                            "objetivo":$("#objetivo").val(),
                            "modalidad":$("#modalidad").val(),
                            "fecha_desde":$("#fecha_desde").val(),
                            "fecha_hasta":$("#fecha_hasta").val(),
                            "duracion":$("#duracion").val(),
                            "unidad":$("#unidad").val(),
                            "prioridad":$("#prioridad").val(),
                            "estado":$("#estado").val(),
                            "importe":$("#importe").val(),
                            "moneda":$("#moneda").val(),
                            "tipo_cambio":$("#tipo_cambio").val(),
                            "forma_pago":$("#forma_pago").val(),
                            "forma_financiacion":$("#forma_financiacion").val(),
                            "profesor_1":$("#profesor_1").val(),
                            "profesor_2":$("#profesor_2").val(),
                            "comentarios":$("#comentarios").val()};
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

            });

        }




        $(document).ready(function(){

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
                width: 300,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Agregar": function() {
                        //se agrega la funcionalidad
                        $('#table_plan tr:last').after('<tr>' +
                                                            '<td>'+$('#np_plan_capacitacion').val()+'</td>' +
                                                            '<td>'+$('#np_objetivo').val()+'</td>' +
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

            //Fin funcionalidad tabla asignar planes
            //**********************************************************************************************

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

            //Agregado dario para autocompletar cursos
            $("#curso").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"cap_plan", "operacion":"autocompletar_cursos"},
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.NOMBRE,
                                    id: item.ID_CURSO

                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#curso_id').val(ui.item.id);
                    $('#curso').val(ui.item.label);
                }
            });


            //fin agregado

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
                                            <td>Plan</td>
                                            <td>Objetivo</td>
                                            <td>Viaticos</td>
                                            <td>Eliminar</td>
                                        </thead>
                                        <tbody>

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



<div class="block" id="forms">
<form id="form_plan" action="">
<fieldset>
<legend>Datos Registro</legend>

    <div class="sixteen_column section">
        <div class="sixteen_column">
            <div class="column_content">
                <label>Plan capacitación: </label><br/>
                <input type="text" name="np_plan_capacitacion" id="np_plan_capacitacion"/>
            </div>
        </div>
    </div>

<div class="sixteen_column section">
    <div class="sixteen_column">
        <div class="column_content">
            <label>Objetivo: </label><br/>
            <textarea name="np_objetivo" id="np_objetivo" rows="3"></textarea>
        </div>
    </div>
</div>


<div class="sixteen_column section">
    <div class="sixteen_column">
        <div class="column_content">
            <label>Comentarios: </label><br/>
            <textarea name="np_comentarios" id="np_comentarios" rows="3"></textarea>
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