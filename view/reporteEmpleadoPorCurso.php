<!doctype html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;








        function guardar(){

            if(globalOperacion=="insert"){ //se va a guardar un usuario nuevo
                var url="index.php";
                var data={  "accion":"empleado",
                            "operacion":"insert",
                            "apellido":$("#apellido").val(),
                            "nombre":$("#nombre").val(),
                            "lugar_trabajo":$("#lugar_trabajo").val(),
                            "n_legajo":$("#n_legajo").val(),
                            "empresa":$("#empresa").val(),
                            "funcion":$("#funcion").val(),
                            //"categoria":$("#categoria").val(),
                            "division":$("#division").val(),
                            "fecha_ingreso":$("#fecha").val(),
                            "activo":$("#activo").val(),
                            "email":$("#email").val(),
                            "cuil":$("#cuil").val()
                        };
            }
            else{ //se va a guardar un usuario editado
                var url="index.php";
                var data={  "accion":"empleado",
                    "operacion":"save",
                    "id":globalId,
                    "apellido":$("#apellido").val(),
                    "nombre":$("#nombre").val(),
                    "lugar_trabajo":$("#lugar_trabajo").val(),
                    "n_legajo":$("#n_legajo").val(),
                    "empresa":$("#empresa").val(),
                    "funcion":$("#funcion").val(),
                    //"categoria":$("#categoria").val(),
                    "division":$("#division").val(),
                    "fecha_ingreso":$("#fecha").val(),
                    "activo":$("#activo").val(),
                    "email":$("#email").val(),
                    "cuil":$("#cuil").val()
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
            //$('#dialog').dialog({
            $('#dialog').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"Colaborador",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"empleado", operacion: "refreshGrid"});
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
            $('#fecha').datepicker({
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
                apellido: {
                    required: true
                },
                nombre: {
                    required: true
                },
                /*n_legajo: {
                    required: true,
                    digits: true
                }, */
                n_legajo: {
                    required: true,
                    digits: true,
                    maxlength: 5,
                    remote: {
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            n_legajo: function(){ return $("#n_legajo").val(); },
                            empresa: function(){ return ($("#empresa").val()!='')? "'"+$("#empresa").val()+"'": 'empresa'; },
                            id: function(){ return (globalOperacion=='insert')? 0: globalId; },
                            accion: "empleado",
                            operacion: "AvailableLegajo"
                        }
                    }

                },
                cuil: {
                    required: true,
                    digits: true
                },
                lugar_trabajo: {
                    //required: function(){return $('#lugar_trabajo').val()==''}
                    required: true
                },
                empresa: {
                    required: true
                },
                division: {
                    required: true
                },
                funcion: {
                    required: true
                },
                fecha:{
                    required: true
                },
                activo: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages:{
                apellido: "Ingrese el apellido",
                nombre: "Ingrese el nombre",
                /*n_legajo: {
                    required: "Ingrese el número de legajo",
                    digits:"Ingrese solo números"
                }, */
                n_legajo:{
                    required: "Ingrese el número de legajo",
                    digits: "El legajo debe ser numérico",
                    remote: "El legajo ya existe, intente con otro",
                    maxlength: "El legajo no debe superar los 5 dígitos"
                },
                cuil: "Ingrese el CUIL (sin guiones)",
                lugar_trabajo: "Seleccione el lugar de trabajo",
                empresa: "Seleccione la empresa",
                division: "Seleccione la división",
                funcion: "Seleccione la función",
                fecha: "Seleccione la fecha de ingreso",
                activo: "Seleccione el estado",
                email: {
                    required: "Ingrese el correo electrónico",
                    email: "Ingrese un correo electrónico válido"
                }
            }

        });


    };

    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla en el archivo reporteEmpleadoPorCursoGrid.php -->
    <?php require_once('reporteEmpleadoPorCursoGrid.php') ?>

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
                                    <label>Apellido: </label>
                                    <input type="text" name="apellido" id="apellido"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Nombre: </label>
                                    <input type="text" name="nombre" id="nombre"/>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Lugar de trabajo: </label>
                                    <select name="lugar_trabajo" id="lugar_trabajo">
                                        <option value="">Ingrese un lugar</option>
                                        <option value="BO">Bolivia</option>
                                        <option value="BUE">Buenos Aires</option>
                                        <option value="CH">Chubut</option>
                                        <option value="MZ">Mendoza</option>
                                        <option value="NQ">Neuquén</option>
                                        <option value="SC">Santa Cruz</option>
                                    </select>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Empresa: </label>
                                    <select name="empresa" id="empresa">
                                        <option value="">Ingrese una empresa</option>
                                        <option value="INNOVISION">INNOVISION</option>
                                        <option value="SEIP">SEIP</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>N legajo: </label>
                                    <input type="text" name="n_legajo" id="n_legajo"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>CUIL: </label>
                                    <input type="text" name="cuil" id="cuil"/>
                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">

                            <div class="eight column">
                                <div class="column_content">
                                    <label>División: </label>
                                    <select name="division" id="division" onchange="cargarFunciones();">
                                        <option value="">Seleccione una división</option>
                                        <?php foreach ($view->divisiones as $div){
                                            $estado=($div['ESTADO']=='ACTIVA')? '': 'disabled';
                                            ?>
                                            <option value="<?php echo $div['ID_DIVISION'];?>" <?php echo $estado ?> ><?php echo $div['NOMBRE'];?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Función: </label>
                                    <select name="funcion" id="funcion">
                                        <!-- select dependiente... se carga dinamicamente al seleccionar la division -->
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Fecha Ingreso: </label>
                                    <input type="text" name="fecha" id="fecha">
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <select name="activo" id="activo">
                                        <option value="">Ingrese el estado</option>
                                        <option value="0">Inactivo</option>
                                        <option value="1" selected>Activo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>E-mail: </label><br/>
                                    <textarea type="text" name="email" id="email" rows="1"/></textarea>
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