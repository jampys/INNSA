<!doctype html>

<html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;

        function editarEntidad(id_entidad){

            $.ajax({
                url:"index.php",
                data:{"accion":"administracion","operacion":"entidadUpdate","id":id_entidad},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#entidad_nombre").val(datas[0]['NOMBRE']);
                    $("#entidad_estado").val(datas[0]['ESTADO']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardarEntidad(){

            if(globalOperacion=="entidad_insert"){ //se va a guardar una nueva entidad
                var url="index.php";
                var data={  "accion":"administracion",
                            "operacion":"entidadInsert",
                            "entidad_nombre":$("#entidad_nombre").val(),
                            "entidad_estado":$("#entidad_estado").val()
                        };
            }
            else if(globalOperacion=="entidad_edit"){ //se va a guardar una entidad editada
                var url="index.php";
                var data={  "accion":"administracion",
                            "operacion":"entidadSave",
                            "id":globalId,
                            "entidad_nombre":$("#entidad_nombre").val(),
                            "entidad_estado":$("#entidad_estado").val()
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


            // Ventana modal de entidades capacitadoras
            $('#entidad').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"Entidad capacitadora",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardarEntidad();
                            $("#entidad").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"administracion", operacion: "refreshGridEntidades"});
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
                    $('#table_temas tbody tr').each(function(){ $(this).remove(); }); //para limpiar la tabla de temas
                }

            });


            //Aca estaba el llamado al dialog link

            //Agregado para editar
            $(document).on("click", ".entidad_edit_link", function(){
                globalOperacion='entidad_edit';
                globalId=$(this).attr('id');
                editarEntidad(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#entidad').dialog('open');
                return false;
            });


            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );

            //llamada a funcion validar
            $.validarEntidad();

        });


    //Declaracion de funciones para validar
    $.validarEntidad=function(){
        $('#form').validate({
            rules: {
                entidad_nombre: {
                    required: true
                }
            },
            messages:{
                entidad_nombre: "Ingrese el nombre de la entidad"
            }

        });

    };


    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla en el archivo abmEmpleadoGrid.php -->
    <?php require_once('abmAdminEntidades_capacitadorasGrid.php') ?>

</div>

<!-- ui-dialog mensaje -->
<div id="dialog-msn">
    <p id="message"></p>
</div>

<!-- ui-dialog -->
<div id="entidad">

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
                                    <label>Nombre de la Entidad: </label>
                                    <input type="text" name="entidad_nombre" id="entidad_nombre"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <select name="entidad_estado" id="entidad_estado">
                                        <!--<option value="">Seleccione el estado</option>-->
                                        <option value="ACTIVA" selected>ACTIVA</option>
                                        <option value="INACTIVA">INACTIVA</option>
                                    </select>

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