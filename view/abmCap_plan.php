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
                    $("#importe").val(parseFloat(datas[0]['IMPORTE'].replace(/,/, '.')));
                    $("#moneda").val(datas[0]['MONEDA']);
                    $("#tipo_cambio").val(parseFloat(datas[0]['TIPO_CAMBIO'].replace(/,/, '.')));
                    $("#forma_pago").val(datas[0]['FORMA_PAGO']);
                    $("#forma_financiacion").val(datas[0]['FORMA_FINANCIACION']);
                    $("#profesor_1").val(datas[0]['PROFESOR_1']);
                    $("#profesor_2").val(datas[0]['PROFESOR_2']);
                    $("#comentarios").val(datas[0]['COMENTARIOS_PLAN']);
                    $("#entidad").val(datas[0]['ENTIDAD_PLAN']);

                    //para el campo tipo de cambio al editar
                    (datas[0]['MONEDA']=='USD')? $('#tipo_cambio').attr('readonly', false) : $('#tipo_cambio').attr('readonly', true);

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
                            "comentarios":$("#comentarios").val(),
                            "entidad":$("#entidad").val()
                    };
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
                            "comentarios":$("#comentarios").val(),
                            "entidad":$("#entidad").val()
                        };
            }

            $.ajax({
                url:url,
                data:data,
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(error){
                    alert(error.responseText);
                    //$("#dialog-msn").dialog("open");
                    //$("#message").html("ha ocurrido un error");

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
                        //Limpia los minDate y maxDate de los datepicker
                        $('#fecha_desde, #fecha_hasta').datepicker( "option" , {minDate: null, maxDate: null} );
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
                   //Limpia los minDate y maxDate de los datepicker
                   $('#fecha_desde, #fecha_hasta').datepicker( "option" , {minDate: null, maxDate: null} );
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

                //Rellenar el combo de periodos
                var per=$.periodos();
                $("#periodo").html('<option value="">Seleccione un periodo</option>');
                $.each(per, function(indice, val){
                    $("#periodo").append(new Option(val,val));
                });

                return false;
            });


            //Para ver un plan de capacitacion
            $(document).on("click", ".view_link", function(){
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                //No debe permitir editar ningun campo
                $(":input:not(.button-cancel)").attr("disabled", true);
                /* Agrego el periodo de la solicitud seleccionada al select */
                $("#periodo").html('<option value="'+$(this).attr("target")+'">'+$(this).attr("target")+'</option>');

                return false;
            });


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

            /*este es un truco para hacer que el plugin validate valide las fechas readonly. Si se pone el atributo readonly en el input
            no funciona, por eso se hace de esta manera con eventos */
            $(document).on("focusin", "#fecha_desde, #fecha_hasta", function(event) {
                $(this).prop('readonly', true);
            });
            $(document).on("focusout", "#fecha_desde, #fecha_hasta", function(event) {
                $(this).prop('readonly', false);
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
                change: function(event, ui) {
                    $('#curso_id').val(ui.item? ui.item.id : '');
                    $('#curso').val(ui.item.label);
                }

            });


            //Al cambiar el select de moneda. Si la moneda es USD se habilita el campo tipo_cambio, sino => se deshabilita
            $('#moneda').change(function() {
                $('#tipo_cambio').val('');
                ($('#moneda').val()=='USD')? $('#tipo_cambio').attr('readonly', false) : $('#tipo_cambio').attr('readonly', true) ;
            });

            //llamada a funcion validar
            $.validar();

        });


    //Declaracion de funcion para validar
    $.validar=function(){
        $('#form').validate({
            /*lo pone en vacio, ya que por defecto es igual a hiddenn  (default: ":hidden"). Y asi evito que ignore el campo oculto http://jqueryvalidation.org/validate/ */
            ignore:"",
            rules: {
                curso: {
                    required: true
                },
                curso_id:{
                    required: function(){return ($('#curso').val().length>0 && globalOperacion!='edit');}
                },
                periodo: {
                    required: true
                },
                objetivo: {
                    required:true,
                    maxlength: 150
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
                    digits: true
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
                    required: function(){ return $('#moneda').val()=='USD';},
                    number: true
                },
                comentarios: {
                    maxlength: 150
                }

            },
            messages:{
                curso: "Seleccione el curso",
                curso_id: "Seleccione un curso sugerido",
                periodo: "Seleccione el periodo",
                objetivo: {
                    required: "Ingrese el título del curso en la entidad capacitadora",
                    maxlength: "Max. 150 caracteres "
                },
                modalidad: "Seleccione la modalidad",
                fecha_desde: "Seleccione la fecha de inicio",
                fecha_hasta: "Seleccione la fecha de finalización",
                duracion: "Ingrese la duración",
                unidad: "Seleccione la unidad",
                prioridad: "Seleccione la prioridad",
                estado: "Seleccione el estado",
                importe: "Ingrese el importe",
                moneda: "Seleccione la moneda",
                tipo_cambio: "Ingrese el tipo de cambio. Separe decimales con (.)",
                comentarios: "Max. 150 caracteres"
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
                                        <!--<option value="">Seleccione el periodo</option>
                                        <?php
                                        $periodos=Conexion::periodos();
                                        foreach ($periodos as $per){
                                            ?>
                                            <option value="<?php echo $per; ?>"><?php echo $per; ?></option>
                                        <?php
                                        }
                                        ?>-->
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Modalidad: </label>
                                    <select name="modalidad" id="modalidad">
                                        <option value="">Seleccione la modalidad</option>
                                        <option value="PRESENCIAL">Presencial</option>
                                        <option value="A DISTANCIA">A distancia</option>
                                        <option value="E-LEARNING">E-Learning</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Entidad: </label>
                                    <select name="entidad" id="entidad">
                                        <option value="">Seleccione la entidad</option>
                                        <option value="IAPG">IAPG</option>
                                        <option value="PERSEUS">Perseus</option>
                                        <option value="UTN">UTN</option>
                                        <option value="OTRA">Otra</option>
                                    </select>
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
                                    <label>Título del curso en la entidad: </label><br/>
                                    <textarea name="objetivo" id="objetivo" rows="2"></textarea>
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
                                        <option value="">Seleccione la unidad</option>
                                        <option value="HORAS">Horas</option>
                                        <option value="DIAS">Dias</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Prioridad: </label><br/>
                                    <select name="prioridad" id="prioridad">
                                        <option value="">Seleccione la prioridad</option>
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
                                        <option value="">Seleccione el estado</option>
                                        <option value="PROPUESTO" selected>Propuesto</option>
                                        <option value="CANCELADO">Cancelado</option>
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
                                        <option value="">Seleccione la moneda</option>
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
                                    <input type="text" name="tipo_cambio" id="tipo_cambio" readonly="readonly"/>
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
                                        <option value="">Seleccione la forma pago</option>
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
                                        <option value="">Seleccione la financiación</option>
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