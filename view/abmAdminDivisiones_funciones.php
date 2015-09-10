<!doctype html>

<html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;

        function editarDivision(id_division){

            $.ajax({
                url:"index.php",
                data:{"accion":"administracion","operacion":"divisionUpdate","id":id_division},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#division_nombre").val(datas['division'][0]['NOMBRE']);
                    $("#division_estado").val(datas['division'][0]['ESTADO']);


                    //Se construye la tabla de funciones
                    $.each(datas['funciones'], function(indice, val){

                        var idCheck=datas['funciones'][indice]['ID_FUNCION'];
                        var nombre=(typeof(datas['funciones'][indice]['NOMBRE'])!='undefined')? datas['funciones'][indice]['NOMBRE']: '';

                        $('#table_funciones tbody').append('<tr id_funcion='+datas['funciones'][indice]['ID_FUNCION']+' operacion="">' +
                        '<td><input type="text" class="tabla_funciones_nombre" value="'+nombre+'" ></td>' +
                        '<td><input type="checkbox" id="tabla_funciones_check_'+idCheck+'" name="check_'+idCheck+'"></td>' +
                        '</tr>');

                        $("#tabla_funciones_check_"+idCheck+"").prop('checked', ((datas['funciones'][indice]['ESTADO'])=="ACTIVA")? true:false);

                    });

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardarDivision(){

            //Codigo para recoger todas las filas de la tabla de funciones
            jsonObj = [];
            $('#table_funciones tbody tr').each(function () {
                item = {};
                item['id_funcion']=$(this).attr('id_funcion');
                item['id_division']=globalId; //id_division
                item['check']= ($(this).find('td').eq(1).find('[type=checkbox]').prop('checked'))? "ACTIVA": "INACTIVA";
                item['nombre']= $(this).find('td').eq(0).find('input').val();
                item['operacion']=$(this).attr('operacion'); //si es un update dice "update", sino esta vacio "".
                jsonObj.push(item);
                //alert(item['id_plan']);
            });

            if(globalOperacion=="division_insert"){ //se va a guardar una nueva division
                var url="index.php";
                var data={  "accion":"administracion",
                            "operacion":"divisionInsert",
                            "funciones":JSON.stringify(jsonObj),
                            "division_nombre":$("#division_nombre").val(),
                            "division_estado":$("#division_estado").val()

                        };
            }
            else if(globalOperacion=="division_edit"){ //se va a guardar una division editada
                var url="index.php";
                var data={  "accion":"administracion",
                    "operacion":"divisionSave",
                    "funciones":JSON.stringify(jsonObj),
                    "id":globalId,
                    "division_nombre":$("#division_nombre").val(),
                    "division_estado":$("#division_estado").val()
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
                    $("#message").html(datas['comment']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }




        $(document).ready(function(){


            //Si se producen cambios en las funciones
            $(document).on("change paste keyup", ".tabla_funciones_nombre, input[name^='check'] ", function() {
                //alert("se modifico");
                $(this).closest('tr').attr('operacion', 'update');
            });


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


            // Ventana modal de divisiones
            $('#division').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"División y funciones",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardarDivision();
                            $("#division").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"administracion", operacion: "refreshGridDivisiones"});
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
                    $('#table_funciones tbody tr').each(function(){ $(this).remove(); }); //para limpiar la tabla de funciones
                }

            });


            //Ventana modal para agregar funciones
            $('#funcion_new').dialog({
                autoOpen: false,
                width: 500,
                modal:true,
                title:"Función",
                buttons: {
                    "Guardar": function() {
                        if($("#form_funcion").valid()){

                            $('#table_funciones tbody').append('<tr operacion="insert">' +
                            '<td><input type="text" class="tabla_funciones_nombre" value="'+$('#funcion_nombre').val()+'" ></td>' +
                            '<td><input type="checkbox"'+(($('#funcion_estado').val()=="ACTIVA")? "checked": "")+'></td>' +
                            '</tr>');

                        }

                    },
                    "Cancelar": function() {
                        $("#form_funcion")[0].reset(); //para limpiar el formulario
                        $('#form_funcion').validate().resetForm(); //para limpiar los errores validate
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
                    $("#form_funcion")[0].reset(); //para limpiar el formulario cuando sale con x
                    $('#form_funcion').validate().resetForm(); //para limpiar los errores validate
                }

            });


            //Aca estaba el llamado al dialog link

            //Agregado para editar
            $(document).on("click", ".division_edit_link", function(){
                globalOperacion='division_edit';
                globalId=$(this).attr('id');
                editarDivision(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#division').dialog('open');

                return false;
            });

            $(document).on('click', '.funcion_new_link', function(){
                $('#funcion_new').dialog('open');
                return false;
            });



            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );

            //llamada a funcion validar
            $.validarDivision();
            $.validarFuncion();

        });


    //Declaracion de funciones para validar
    $.validarDivision=function(){
        $('#form').validate({
            rules: {
                division_nombre: {
                    required: true
                }
            },
            messages:{
                division_nombre: "Ingrese el nombre de la división"
            }

        });

    };

    $.validarFuncion=function(){
        $('#form_funcion').validate({
            rules: {
                funcion_nombre: {
                    required: true
                }
            },
            messages:{
                funcion_nombre: "Ingrese el nombre de la función"
            }

        });

    };

    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla en el archivo abmEmpleadoGrid.php -->
    <?php require_once('abmAdminDivisiones_funcionesGrid.php') ?>

</div>

<!-- ui-dialog mensaje -->
<div id="dialog-msn">
    <p id="message"></p>
</div>

<!-- ui-dialog -->
<div id="division">

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
                                    <label>Nombre de la division: </label>
                                    <input type="text" name="division_nombre" id="division_nombre"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <select name="division_estado" id="division_estado">
                                        <!--<option value="">Seleccione el estado</option>-->
                                        <option value="ACTIVA" selected>ACTIVA</option>
                                        <option value="INACTIVA">INACTIVA</option>
                                    </select>

                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Funciones de la división: </label><br/>
                                    <a class="funcion_new_link" href="#"><img src="public/img/add-icon.png" width="15px" height="15px"></a>
                                    <table id="table_funciones" class="tablaSolicitud">
                                        <thead>
                                        <tr>
                                            <td style="width: 90%">Función</td>
                                            <td style="width: 10%">Estado</td>
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


<div id="funcion_new" >

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="block" id="formus">
            <form id="form_funcion" name="form_funcion" action="">
                <fieldset>
                    <!--<legend>Datos Registro</legend>-->

                    <div class="sixteen_column section">
                        <div class="sixteen_column">
                            <div class="column_content">
                                <label>Nombre: </label><br/>
                                <input type="text" name="funcion_nombre" id="funcion_nombre"/>
                            </div>
                        </div>
                    </div>

                    <div class="sixteen_column section">
                        <div class="eight column">
                            <div class="column_content">
                                <label>Estado: </label>
                                <select name="funcion_estado" id="funcion_estado">
                                    <!--<option value="">Seleccione el estado</option>-->
                                    <option value="ACTIVA" selected>ACTIVA</option>
                                    <option value="INACTIVA">INACTIVA</option>
                                </select>
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