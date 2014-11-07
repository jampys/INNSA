<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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


            //Aca estaba llamada a dataTable



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
                            $('#principal').load('index.php',{accion:"cap_plan", operacion: "refreshGrid"});
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

            //Aca estaba la llamada al dialog link

            //Agregado por dario para editar

            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                $("#curso").attr("readonly", true); //para no permitir editar el curso
                //alert("funciona el link edit");
                return false;
            });
            //Fin agregado


            /*
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
            */


            //Date picker modificados con validacion de fecha desde y hasta
            $("#fecha_desde").datepicker({
                dateFormat:"dd/mm/yy",
                onClose: function() {
                    $("#fecha_hasta").datepicker("change", { minDate: $('#fecha_desde').val()}
                    );
                }
            });
            $("#fecha_hasta").datepicker({
                dateFormat:"dd/mm/yy",
                onClose: function() {
                    $("#fecha_desde").datepicker("change", { maxDate: $('#fecha_hasta').val()}
                    );
                }
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

            //llamada a funcion validar
            $.validar();

        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            rules: {
                curso: {
                    required: true
                },
                periodo: {
                    required: true
                },
                modalidad: {
                    required: true
                },
                fecha_desde: {
                    required: true
                },
                fecha_hasta: {
                    required: true
                },
                duracion: {
                    required: true,
                    number: true
                },
                unidad:{
                    required: true
                },
                prioridad:{
                    required: true
                },
                estado:{
                    required: true
                },
                importe: {
                    required: true,
                    number: true
                },
                moneda:{
                    required: true
                },
                tipo_cambio: {
                    required: true,
                    number: true
                }

            },
            messages:{
                curso: "Ingrese el curso",
                periodo: "Seleccione el periodo",
                modalidad: "Seleccione la modalidad",
                fecha_desde: "Seleccione la fecha de inicio",
                fecha_hasta: "Seleccione la fecha de finalización",
                duracion: "Ingrese la duración",
                unidad: "Seleccione la unidad",
                prioridad: "Seleccione la prioridad",
                estado: "Seleccione el estado",
                importe: "Ingrese el importe",
                moneda: "Seleccione la moneda",
                tipo_cambio: "Ingrese el tipo de cambio"
            }

        });


    };

    </script>

</head>


<body>

<div id="principal">

<!-- Se llama a la grilla en abmCap_planGrid.php -->
    <?php  require_once('abmCap_planGrid.php');?>

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
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Curso: </label><br/>
                                    <input type="text" name="curso" id="curso"/>
                                    <input type="hidden" name="curso_id" id="curso_id"/>
                                </div>
                            </div>

                        </div>


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
                                    <label>Modalidad: </label>
                                    <select name="modalidad" id="modalidad">
                                        <option value="">Ingrese la modalidad</option>
                                        <option value="presencial">Presencial</option>
                                        <option value="a_distancia">A distancia</option>
                                        <option value="e_learning">E Learning</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Objetivo: </label><br/>
                                    <textarea name="objetivo" id="objetivo" rows="3"></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Fecha desde: </label><br/>
                                    <input type="text" name="fecha_desde" id="fecha_desde">
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Fecha hasta: </label>
                                    <input type="text" name="fecha_hasta" id="fecha_hasta">
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Duración: </label><br/>
                                    <input type="text" name="duracion" id="duracion"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Unidad: </label>
                                    <select name="unidad" id="unidad">
                                        <option value="">Ingrese la unidad</option>
                                        <option value="Horas">Horas</option>
                                        <option value="Dias">Dias</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Prioridad: </label><br/>
                                    <select name="prioridad" id="prioridad">
                                        <option value="">Ingrese la prioridad</option>
                                        <option value="3">Baja</option>
                                        <option value="2">Media</option>
                                        <option value="1">Alta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <select name="estado" id="estado">
                                        <option value="">Ingrese el estado</option>
                                        <option value="Propuesto">Propuesto</option>
                                        <option value="Cancelado">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Importe: </label><br/>
                                    <input type="text" name="importe" id="importe"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Moneda: </label>
                                    <select name="moneda" id="moneda">
                                        <option value="">Ingrese la moneda</option>
                                        <option value="$">$</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Tipo cambio: </label><br/>
                                    <input type="text" name="tipo_cambio" id="tipo_cambio"/>
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
                                    <label>Forma pago: </label><br/>
                                    <select name="forma_pago" id="forma_pago">
                                        <option value="">Ingrese la forma pago</option>
                                        <option value="Tarjeta">Tarjeta</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="Rapipago">Rapipago</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Forma financiación: </label>
                                    <select name="forma_financiacion" id="forma_financiacion">
                                        <option value="">Ingrese la financiación</option>
                                        <option value="1" selected>1 pago</option>
                                        <option value="3">3 pagos</option>
                                        <option value="6">6 pagos</option>
                                        <option value="9">9 pagos</option>
                                        <option value="12">12 pagos</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Profesor 1: </label><br/>
                                    <input type="text" name="profesor_1" id="profesor_1"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Profesor 2: </label>
                                    <input type="text" name="profesor_2" id="profesor_2"/>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">

                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Comentarios: </label>
                                    <textarea type="text" name="comentarios" id="comentarios" rows="2"/></textarea>
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