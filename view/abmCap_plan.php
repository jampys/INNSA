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
                    $("#curso").val(datas['plan'][0]['NOMBRE']);
                    $("#periodo").val(datas['plan'][0]['PERIODO']);
                    $("#objetivo").val(datas['plan'][0]['OBJETIVO']);
                    $("#modalidad").val(datas['plan'][0]['MODALIDAD']);
                    $("#fecha_desde").val(datas['plan'][0]['FECHA_DESDE']);
                    $("#fecha_hasta").val(datas['plan'][0]['FECHA_HASTA']);
                    $("#duracion").val(datas['plan'][0]['DURACION']);
                    $("#unidad").val(datas['plan'][0]['UNIDAD']);
                    $("#prioridad").val(datas['plan'][0]['PRIORIDAD']);
                    $("#estado").val(datas['plan'][0]['ESTADO']);
                    $("#importe").val(parseFloat(datas['plan'][0]['IMPORTE'].replace(/,/, '.')));
                    $("#moneda").val(datas['plan'][0]['MONEDA']);
                    $("#tipo_cambio").val(parseFloat(datas['plan'][0]['TIPO_CAMBIO'].replace(/,/, '.')));
                    $("#forma_pago").val(datas['plan'][0]['FORMA_PAGO']);
                    $("#forma_financiacion").val(datas['plan'][0]['FORMA_FINANCIACION']);
                    $("#profesor_1").val(datas['plan'][0]['PROFESOR_1']);
                    $("#profesor_2").val(datas['plan'][0]['PROFESOR_2']);
                    $("#comentarios").val(datas['plan'][0]['COMENTARIOS_PLAN']);
                    $("#entidad").val(datas['plan'][0]['ENTIDAD_PLAN']);

                    //para el campo tipo de cambio al editar
                    (datas['plan'][0]['MONEDA']=='USD')? $('#tipo_cambio').attr('readonly', false) : $('#tipo_cambio').attr('readonly', true);



                    //Se construye la tabla de empleados
                    $.each(datas['empleados'], function(indice, val){

                        var idCheck=datas['empleados'][indice]['ID_ASIGNACION'];
                        var comentarios=(typeof(datas['empleados'][indice]['COMENTARIOS'])!='undefined')? datas['empleados'][indice]['COMENTARIOS']: '';
                        var viaticos=(typeof(datas['empleados'][indice]['VIATICOS'])!='undefined')? datas['empleados'][indice]['VIATICOS']: '';

                        $('#table_empleados tbody').append('<tr id_asignacion='+datas['empleados'][indice]['ID_ASIGNACION']+' id_solicitud="'+datas['empleados'][indice]['ID_SOLICITUD']+'">' +
                        '<td><input type="checkbox" id="check_'+idCheck+'" name="check_'+idCheck+'"></td>' +
                        '<td>'+datas['empleados'][indice]['APELLIDO']+' '+datas['empleados'][indice]['NOMBRE']+'</td>' +
                        '<td><input type="text" class="emp_comentarios" value="'+comentarios+'" ></td>' +
                        '<td><input type="text" class="emp_viaticos" value="'+viaticos+'" ></td>' +
                        //'<td style="display: none">'+datas['propuestas'][indice]['SITUACION']+'</td>' +
                        //'<td style="display: none">'+datas['propuestas'][indice]['OBJETIVO_1']+'</td>' +
                        //'<td style="text-align: center"><a class="editar_curso" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                        //'<td style="text-align: center"><a class="eliminar_curso" href="#"><img src="public/img/delete-icon.png" width="15px" height="15px"></a></td>' +
                        '</tr>');

                        $("#check_"+idCheck+"").prop('checked', ((typeof (datas['empleados'][indice]['ID_ASIGNACION']))!="undefined")? true:false);
                        //(datas['empleados'][indice]['ESTADO']=='AUTORIZADA' || datas['empleados'][indice]['ESTADO']=='APROBADA')? $('#table_empleados tbody tr td input').attr('disabled', 'disabled'): '';
                        (datas['empleados'][indice]['APROBADA']==1 || datas['empleados'][indice]['PERIODO']!= (new Date).getFullYear())? $("#table_empleados tbody tr:eq("+indice+") td input").attr('disabled', 'disabled'): '';

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
            $('#table_empleados tbody tr').each(function () {
                item = {};
                item['id_asignacion']=($(this).attr('id_asignacion')!='undefined')? $(this).attr('id_asignacion') : "";
                item['id_solicitud']=$(this).attr('id_solicitud');
                //item['id_plan']=$(this).attr('id_plan');
                item['id_plan']=globalId; //id_plan
                item['check']= ($(this).find('td').eq(0).find('[type=checkbox]').prop('checked'))? 1: 0;
                item['comentarios']= $(this).find('td').eq(2).find('input').val();
                item['viaticos']= $(this).find('td').eq(3).find('input').val();
                item['estado'] = 'ASIGNADO';
                // 4 posibles operaciones
                if(item['id_asignacion']!='' && item['check']==1) item['operacion']='update';
                else if(item['id_asignacion']!='' && item['check']==0) item['operacion']='delete';
                else if(item['id_asignacion']=='' && item['check']==1) item['operacion']='insert';
                else if(item['id_asignacion']=='' && item['check']==0) item['operacion']='null';

                jsonObj.push(item);
                //alert(item['id_plan']);
            });



            if(globalOperacion=="insert"){ //se va a guardar un plan nuevo
                var url="index.php";
                var data={  "accion":"cap_plan",
                            "operacion":"insert",
                            "datos":JSON.stringify(jsonObj),
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
                            "entidad":$("#entidad").val(),
                            //nuevo curso
                            "nc_nombre": $('#asignar_plan').data('nc_nombre'),
                            "nc_tipo_curso": $('#asignar_plan').data('nc_tipo_curso'),
                            "nc_id_tema": $('#asignar_plan').data('nc_id_tema')

                    };
            }
            else{ //se va a guardar un plan editado
                var data={  "accion":"cap_plan",
                            "operacion":"save",
                            "datos":JSON.stringify(jsonObj),
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
                    //alert(error.responseText);
                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

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
                title:"Plan de Capacitación",
                buttons: [
                    {
                    class: "button-guardar",
                    text: "Guardar",
                    click: function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"cap_plan", operacion: "refreshGrid"});
                            }

                        }
                    },
                    {
                        class: "button-cancel",
                        text: "Cancelar",
                        click: function() {
                        $("#form")[0].reset(); //para limpiar los campos del formulario
                        $('#form').validate().resetForm(); //para limpiar los errores validate
                        //Limpia los minDate y maxDate de los datepicker
                        $('#fecha_desde, #fecha_hasta').datepicker( "option" , {minDate: null, maxDate: null} );
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
                   //Limpia los minDate y maxDate de los datepicker
                   $('#fecha_desde, #fecha_hasta').datepicker( "option" , {minDate: null, maxDate: null} );
                   $(":input").attr("disabled", false); //para volver a habilitar todos los campos, por si fueron deshabilitados
                   $('#table_empleados tbody tr').each(function(){ $(this).remove(); });
                }

            });



            //Funcionalidad para la tabla de asignar planes
            $('#asignar_plan').dialog({
                autoOpen: false,
                width: 500,
                modal:true,
                title:"Seleccionar curso",
                buttons: {
                    "Guardar": function() {

                        if($('input[name=radio_curso]').is(':checked')){ //si hay alguno radio button seleccionado
                            //alert("hay alguno seleccionado");
                            $('#curso_id').val($('input[name=radio_curso]:checked').val());
                            $('#curso').val($('input[name=radio_curso]:checked').closest('tr').find('td').eq(0).html());
                            $(this).dialog("close");
                        }
                        else{ //si ingreso un curso nuevo

                            if($("#form_plan").valid()){

                                $('#asignar_plan').data('nc_nombre', $('#nc_nombre').val());
                                $('#curso').val($('#nc_nombre').val());
                                $('#asignar_plan').data('nc_tipo_curso', $('#nc_tipo_curso').val());
                                $('#asignar_plan').data('nc_id_tema', $('#curso_tema :selected').val());
                                console.log($('#asignar_plan').data('nc_tipo_curso'));
                                $("#form_plan")[0].reset();
                                $(this).dialog("close");
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
                    $('#table_cursos tbody tr').each(function(){ $(this).remove(); });
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


            $(document).on('change', '#curso_tema', function(){
                var label=$('#curso_tema :selected').parent().attr('label');
                if(label=='Temas'){
                    var id_tema=$('#curso_tema :selected').val();

                    $.ajax({
                        url:"index.php",
                        data:{"accion":"curso","operacion":"getCursosByTema","id_tema":id_tema},
                        contentType:"application/x-www-form-urlencoded",
                        dataType:"json",//xml,html,script,json
                        error:function(){

                            $("#dialog-msn").dialog("open");
                            $("#message").html("ha ocurrido un error");

                        },
                        ifModified:false,
                        processData:true,
                        success:function(datas){

                            //Se construye la de cursos by tema
                            $.each(datas, function(indice, val){

                                $('#table_cursos tbody').append('<tr id_curso='+datas[indice]['ID_CURSO']+'>' +
                                '<td>'+datas[indice]['NOMBRE']+'</td>' +
                                '<td><input type="radio" name="radio_curso" value="'+datas[indice]['ID_CURSO']+'"></td>' +
                                '</tr>');

                            });

                        },
                        type:"POST",
                        timeout:3000000,
                        crossdomain:true

                    });


                    //$('#asignar_plan').data('operacion', 'insert').dialog('open');
                    $('#asignar_plan').dialog('open');
                    return false;
                }
                else{

                    $("#curso").val($('#curso_tema :selected').text());
                    $("#curso_id").val($('#curso_tema :selected').val());

                }

            });


            // nuevo curso
            $(document).on('click', '.new-curso-link', function(){
                $('#oculto').css('display', 'block');
                $('input[name=radio_curso]').attr('checked', false);
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
            /*$("#curso").autocomplete({
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

            });*/


            //Al cambiar el select de moneda. Si la moneda es USD se habilita el campo tipo_cambio, sino => se deshabilita
            $('#moneda').change(function() {
                $('#tipo_cambio').val('');
                ($('#moneda').val()=='USD')? $('#tipo_cambio').attr('readonly', false) : $('#tipo_cambio').attr('readonly', true) ;
            });

            //llamada a funcion validar
            $.validar();
            $.validarCurso();

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
                    //required: function(){return ($('#curso').val().length>0 && globalOperacion!='edit');}
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


    $.validarCurso=function(){
        $('#form_plan').validate({
            /*lo pone en vacio, ya que por defecto es igual a hiddenn  (default: ":hidden"). Y asi evito que ignore el campo oculto http://jqueryvalidation.org/validate/ */
            ignore:"",
            rules: {
                nc_nombre: {
                    required: function(){return !$('input[name=radio_curso]').is(':checked')}, //si no selecciono ninguno de los sugeridos es required
                    maxlength: 100
                },
                nc_tipo_curso:{
                    required: function(){return !$('input[name=radio_curso]').is(':checked')} //si no selecciono ninguno de los sugeridos es required
                }
            },
            messages:{
                nc_nombre: {
                    required: "Ingrese el nombre del curso",
                    maxlength: "Max. 100 caracteres "
                },
                nc_tipo_curso: "Seleccione el tipo de curso"
            }

        });


    };

    //validacion de inputs de tabla empleados

    //personalizo los metodos http://stackoverflow.com/questions/3247305/how-to-add-messages-to-a-class-with-addclassrules
    $.validator.addMethod("cMaxLength", $.validator.methods.maxlength,
        "Máximo 100 caracteres");

    //asigno metodos personalizados
    jQuery.validator.addClassRules({
        emp_comentarios: {
            cMaxLength: 100
        },
        emp_viaticos: {
            digits: true,
            maxlength: 4
        }
    });


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
                        <!--<legend>Datos Registro</legend>-->

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Curso / tema: </label><br/>
                                    <!--<input type="text" name="curso" id="curso"/>
                                    <input type="hidden" name="curso_id" id="curso_id"/>-->

                                    <select name="curso_tema" id="curso_tema">
                                        <option value="">Seleccione el curso /tema</option>
                                        <optgroup label="Cursos">
                                        <?php foreach($cursosTemasSinAsignacion as $cu) {
                                            if ($cu['TABLA'] == 'CURSOS') {
                                                ?>
                                                <option value="<?php echo $cu['IDS']; ?>"><?php echo $cu['NOMBRE']; ?></option>
                                            <?php
                                            }
                                        }
                                            ?>
                                        </optgroup>


                                        <optgroup label="Temas">
                                            <?php foreach($cursosTemasSinAsignacion as $te) {
                                                if ($te['TABLA'] == 'TEMAS') {
                                                    ?>
                                                    <option value="<?php echo $te['IDS']; ?>"><?php echo $te['NOMBRE']; ?></option>
                                                <?php
                                                }
                                                }
                                            ?>
                                        </optgroup>

                                    </select>


                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <input type="text" name="curso" id="curso" readonly/>
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
                                        /*$periodos=Conexion::periodos();
                                        foreach ($periodos as $per){
                                            ?>
                                            <option value="<?php echo $per; ?>"><?php echo $per; ?></option>
                                        <?php
                                        }*/
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
                                        <!--Entidades capacitadoras se cargan dinamicamente de la BD -->
                                        <?php foreach($entidadesCapacitadoras as $ec){
                                            $estado=(($ec['ESTADO']=='ACTIVA')? '':'disabled');
                                            ?>
                                            <option value="<?php echo $ec['ID_ENTIDAD_CAPACITADORA']; ?>"  <?php echo $estado ?> ><?php echo $ec['NOMBRE']; ?></option>
                                        <?php } ?>
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
                                        <!--<option value="CANCELADO">Cancelado</option>-->
                                        <option value="SUSPENDIDO">Suspendido</option>
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


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Empleados:</label><br/>
                                    <table id="table_empleados" class="tablaSolicitud">
                                        <thead>
                                        <tr>
                                            <td style="width: 10%">Check</td>
                                            <td style="width: 40%">Apellido y nombre</td>
                                            <td style="width: 40%">Comentarios</td>
                                            <td style="width: 10%">Viaticos</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!-- el cuerpo se genera dinamicamente con javascript -->
                                        </tbody>
                                    </table>
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

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="block" id="formus">
            <form id="form_plan" name="form_plan" action="">
                <fieldset>
                    <!--<legend>Datos Registro</legend>-->

                    <div class="sixteen_column section">
                        <div class="sixteen_column">
                            <div class="column_content">
                                <table id="table_cursos" class="tablaSolicitud">
                                    <thead>
                                    <tr>
                                        <td style="width: 70%">Curso</td>
                                        <td>Seleccionar</td>
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
                                <label>Nuevo curso: </label><br/>
                                <a class="new-curso-link" href="#"><img src="public/img/add-icon.png" width="15px" height="15px"></a>
                            </div>
                        </div>
                        <div class="eight column">
                            <div class="column_content">

                            </div>
                        </div>
                    </div>



                    <div id="oculto" style="display: none">


                        <div class="sixteen_column section">

                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Nombre: </label>
                                    <input type="text" name="nc_nombre" id="nc_nombre"/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Tipo de actividad: </label><br/>
                                    <select name="nc_tipo_curso" id="nc_tipo_curso">
                                        <option value="">Seleccione el tipo de actividad</option>
                                        <?php foreach($tipo_curso as $tip){?>
                                            <option value="<?php echo $tip['ID_TIPO_CURSO']?>"><?php echo $tip['NOMBRE']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">

                                </div>
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