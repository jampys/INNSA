<!doctype html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;


        function editar(id_programa){

            $.ajax({
                url:"index.php",
                data:{"accion":"programa","operacion":"update","id":id_programa},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(e){

                $("#dialog-msn").dialog("open");
                //$("#message").html("ha ocurrido un error");
                    $("#message").html(e.responseText);

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#tipo_programa").val(datas[0]['TIPO_PROGRAMA']);
                    $("#periodo").val(datas[0]['PERIODO']);
                    $("#nro_programa").val(datas[0]['NRO_PROGRAMA']);
                    $("#estado").val(datas[0]['ESTADO']);
                    $("#fecha_ingreso").val(datas[0]['FECHA_INGRESO']);
                    $("#fecha_evaluacion").val(datas[0]['FECHA_EVALUACION']);
                    $("#fecha_preaprobacion").val(datas[0]['FECHA_PREAPROBACION']);
                    $("#fecha_aprobacion").val(datas[0]['FECHA_APROBACION']);
                    $("#contacto").val(datas[0]['CONTACTO']);
                    $("#email").val(datas[0]['EMAIL']);
                    //cargarFunciones(datas[0]['FUNCION']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            if(globalOperacion=="insert"){ //se va a guardar un usuario nuevo
                var url="index.php";
                var data={  "accion":"programa",
                            "operacion":"insert",
                            "tipo_programa":$("#tipo_programa").val(),
                            "periodo":$("#periodo").val(),
                            "nro_programa":$("#nro_programa").val(),
                            "estado":$("#estado").val(),
                            "fecha_ingreso":$("#fecha_ingreso").val(),
                            "fecha_evaluacion":$("#fecha_evaluacion").val(),
                            "fecha_preaprobacion":$("#fecha_preaprobacion").val(),
                            "fecha_aprobacion":$("#fecha_aprobacion").val(),
                            "contacto":$("#contacto").val(),
                            "email":$("#email").val()
                        };
            }
            else{ //se va a guardar un usuario editado
                var url="index.php";
                var data={  "accion":"programa",
                            "operacion":"save",
                            "id":globalId,
                            "tipo_programa":$("#tipo_programa").val(),
                            "periodo":$("#periodo").val(),
                            "nro_programa":$("#nro_programa").val(),
                            "estado":$("#estado").val(),
                            "fecha_ingreso":$("#fecha_ingreso").val(),
                            "fecha_evaluacion":$("#fecha_evaluacion").val(),
                            "fecha_preaprobacion":$("#fecha_preaprobacion").val(),
                            "fecha_aprobacion":$("#fecha_aprobacion").val(),
                            "contacto":$("#contacto").val(),
                            "email":$("#email").val()

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

            // menu superfish
            $('#navigationTop').superfish();


            //Rellenar el combo de periodos
            var per=$.periodos();
            $("#periodo").html('<option value="">Seleccione un período</option>');
            $.each(per, function(indice, val){
                $("#periodo").append(new Option(val,val));
            });


            //Aca estaba el dataTable

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
                title:"Programa",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"programa", operacion: "refreshGrid"});
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

            //Aca estaba el llamado al dialog link

            //Agregado para editar
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');

                return false;
            });


            // Datepicker
            $('#fecha_ingreso, #fecha_evaluacion, #fecha_preaprobacion, #fecha_aprobacion ').datepicker({
                //inline: true,
                dateFormat:"dd/mm/yy"
            });

            /*este es un truco para hacer que el plugin validate valide las fechas readonly. Si se pone el atributo readonly en el input
             no funciona, por eso se hace de esta manera con eventos */
            $(document).on("focusin", "#fecha", function(event) {
                $(this).prop('readonly', true);
            });
            $(document).on("focusout", "#fecha", function(event) {
                $(this).prop('readonly', false);
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
                tipo_programa: {
                    required: true
                },
                periodo: {
                    required: true
                }
                /*contacto: {
                    //required: function(){return $('#lugar_trabajo').val()==''}
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }*/
            },
            messages:{
                tipo_programa: "Seleccione el tipo de programa",
                periodo: "Seleccione el período"
                /*contacto: "Ingrese el contacto",
                email: {
                    required: "Ingrese el correo electrónico",
                    email: "Ingrese un correo electrónico válido"
                }*/
            }

        });


    };

    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla en el archivo abmEmpleadoGrid.php -->
    <?php require_once('abmProgramaGrid.php') ?>

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
                                    <label>Tipo programa: </label>
                                    <select name="tipo_programa" id="tipo_programa">
                                        <option value="0">Seleccione el tipo programa</option>
                                        <option value="SEPYME">SEPYME</option>
                                        <option value="PYMES PAE">PYMES PAE</option>
                                        <option value="UTN">UTN</option>
                                    </select>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Período: </label>

                                    <select name="periodo" id="periodo">
                                        <!-- se genera en forma dinamica -->
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Nro. Programa: </label>
                                    <input type="text" name="nro_programa" id="nro_programa"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <input type="text" name="estado" id="estado"/>

                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="four column">
                                <div class="column_content">
                                    <label>Fecha Ingreso: </label>
                                    <input type="text" name="fecha_ingreso" id="fecha_ingreso">
                                </div>
                            </div>

                            <div class="four column">
                                <div class="column_content">
                                    <label>Fecha Evaluación: </label>
                                    <input type="text" name="fecha_evaluacion" id="fecha_evaluacion">
                                </div>
                            </div>

                            <div class="four column">
                                <div class="column_content">
                                    <label>Fecha Preaprobación: </label>
                                    <input type="text" name="fecha_preaprobacion" id="fecha_preaprobacion">
                                </div>
                            </div>

                            <div class="four column">
                                <div class="column_content">
                                    <label>Fecha Aprobación: </label>
                                    <input type="text" name="fecha_aprobacion" id="fecha_aprobacion">
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Contacto: </label>
                                    <input type="text" name="contacto" id="contacto"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>E-mail: </label>
                                    <input type="text" name="email" id="email"/>
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