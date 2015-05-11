<!doctype html>

<html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;

        function editarCategoria(id_categoria){
            //alert(id_usuario);

            $.ajax({
                url:"index.php",
                data:{"accion":"administracion","operacion":"categoriaUpdate","id":id_categoria},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#categoria_nombre").val(datas['categoria'][0]['NOMBRE']);
                    $("#categoria_descripcion").val(datas['categoria'][0]['DESCRIPCION']);
                    $("#categoria_estado").val(datas['categoria'][0]['ESTADO']);


                    //Se construye la tabla de cursos propuestos
                    $.each(datas['temas'], function(indice, val){

                        /*$('#table_temas tbody').append('<tr id_tema='+datas['temas'][indice]['ID_TEMA']+' '+'id_categoria='+datas['temas'][indice]['ID_CATEGORIA']+'>' +
                        '<td>'+datas['temas'][indice]['NOMBRE']+'</td>' +
                        '<td>'+datas['temas'][indice]['ESTADO']+'</td>' +
                        '<td style="text-align: center"><a class="editar_curso" href="#"><img src="public/img/pencil-icon.png" width="15px" height="15px"></a></td>' +
                        '</tr>'); */

                        var idCheck=datas['temas'][indice]['ID_TEMA'];
                        var nombre=(typeof(datas['temas'][indice]['NOMBRE'])!='undefined')? datas['temas'][indice]['NOMBRE']: '';

                        $('#table_temas tbody').append('<tr id_tema='+datas['temas'][indice]['ID_TEMA']+' operacion="">' +
                        '<td><input type="text" class="tabla_temas_nombre" value="'+nombre+'" ></td>' +
                        '<td><input type="checkbox" id="tabla_temas_check_'+idCheck+'" name="check_'+idCheck+'"></td>' +
                        '</tr>');

                        $("#tabla_temas_check_"+idCheck+"").prop('checked', ((datas['temas'][indice]['ESTADO'])=="ACTIVO")? true:false);

                    });


                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardarCategoria(){

            //Codigo para recoger todas las filas de la tabla de temas
            jsonObj = [];
            $('#table_temas tbody tr').each(function () {
                item = {};
                item['id_tema']=$(this).attr('id_tema');
                item['id_categoria']=globalId; //id_categoria
                item['check']= ($(this).find('td').eq(1).find('[type=checkbox]').prop('checked'))? "ACTIVO": "INACTIVO";
                item['nombre']= $(this).find('td').eq(0).find('input').val();
                item['operacion']=$(this).attr('operacion'); //si es un update dice "update", sino esta vacio "".
                jsonObj.push(item);
                //alert(item['id_plan']);
            });

            if(globalOperacion=="categoria_insert"){ //se va a guardar una nueva categoria
                var url="index.php";
                var data={  "accion":"administracion",
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
            else if(globalOperacion=="categoria_edit"){ //se va a guardar una categoria editada
                var url="index.php";
                var data={  "accion":"administracion",
                    "operacion":"CategoriaSave",
                    "temas":JSON.stringify(jsonObj),
                    "id":globalId,
                    "categoria_nombre":$("#categoria_nombre").val(),
                    "categoria_estado":$("#categoria_estado").val(),
                    "categoria_descripcion":$("#categoria_descripcion").val()
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


            //Si se producen cambios en los temas
            $(document).on("change paste keyup", ".tabla_temas_nombre, input[name^='check'] ", function() {
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


            // Ventana modal de categorias
            $('#categoria').dialog({
                autoOpen: false,
                width: 600,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardarCategoria();
                            $("#categoria").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"administracion", operacion: "refreshGrid"});
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


            //Ventana modal para agregar temas
            $('#tema_new').dialog({
                autoOpen: false,
                width: 500,
                modal:true,
                title:"Agregar Registro",
                buttons: {
                    "Guardar": function() {
                        if($("#form_tema").valid()){

                            $('#table_temas tbody').append('<tr operacion="insert">' +
                            '<td><input type="text" class="tabla_temas_nombre" value="'+$('#tema_nombre').val()+'" ></td>' +
                            '<td><input type="checkbox" id="tabla_temas_check_'+idCheck+'" name="check_'+idCheck+'"></td>' +
                            '</tr>');

                            $("#tabla_temas_check_"+idCheck+"").prop('checked', ((datas['temas'][indice]['ESTADO'])=="ACTIVO")? true:false);

                        }

                    },
                    "Cancelar": function() {
                        $("#form_tema")[0].reset(); //para limpiar el formulario
                        $('#form_tema').validate().resetForm(); //para limpiar los errores validate
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
                    $("#form_tema")[0].reset(); //para limpiar el formulario cuando sale con x
                    $('#form_tema').validate().resetForm(); //para limpiar los errores validate
                }

            });


            //Aca estaba el llamado al dialog link

            //Agregado para editar
            $(document).on("click", ".categoria_edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='categoria_edit';
                globalId=$(this).attr('id');
                editarCategoria(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#categoria').dialog('open');

                return false;
            });

            $(document).on('click', '.tema_new_link', function(){
                $('#tema_new').dialog('open');
                //$('#proponer_curso').data('operacion', 'insert').dialog('open');
                return false;
            });



            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );

            //llamada a funcion validar
            $.validarCategoria();
            $.validarTema();

        });


    //Declaracion de funciones para validar
    $.validarCategoria=function(){
        $('#form').validate({
            rules: {
                categoria_nombre: {
                    required: true
                }
            },
            messages:{
                categoria_nombre: "Ingrese el nombre de la categoría"
            }

        });

    };

    $.validarTema=function(){
        $('#form_tema').validate({
            rules: {
                tema_nombre: {
                    required: true
                }
            },
            messages:{
                tema_nombre: "Ingrese el nombre del tema"
            }

        });

    };

    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla en el archivo abmEmpleadoGrid.php -->
    <?php require_once('abmAdministracionGrid.php') ?>

</div>

<!-- ui-dialog mensaje -->
<div id="dialog-msn">
    <p id="message"></p>
</div>

<!-- ui-dialog -->
<div id="categoria">

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
                                    <label>Nombre de la categoría: </label>
                                    <input type="text" name="categoria_nombre" id="categoria_nombre"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Estado: </label>
                                    <select name="categoria_estado" id="categoria_estado">
                                        <option value="">Seleccione el estado</option>
                                        <option value="ACTIVA">ACTIVA</option>
                                        <option value="INACTIVA">INACTIVA</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Descripción: </label><br/>
                                    <textarea type="text" name="categoria_descripcion" id="categoria_descripcion" rows="1"/></textarea>
                                </div>
                            </div>

                        </div>


                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Temas de la categoría: </label><br/>
                                    <a class="tema_new_link" href="#"><img src="public/img/add-icon.png" width="15px" height="15px"></a>
                                    <table id="table_temas" class="tablaSolicitud">
                                        <thead>
                                        <tr>
                                            <td style="width: 90%">Nombre</td>
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


<div id="tema_new" >

    <!-- <div class="grid_7">  se tuvo que modificar porque se achicaba solo el panel-->
    <div class="grid_7" style="width: 98%">

        <div class="block" id="formus">
            <form id="form_tema" name="form_tema" action="">
                <fieldset>
                    <!--<legend>Datos Registro</legend>-->

                    <div class="sixteen_column section">
                        <div class="sixteen_column">
                            <div class="column_content">
                                <label>Nombre: </label><br/>
                                <input type="text" name="tema_nombre" id="tema_nombre"/>
                            </div>
                        </div>
                    </div>

                    <div class="sixteen_column section">
                        <div class="eight column">
                            <div class="column_content">
                                <label>Estado: </label>
                                <select name="categoria_estado" id="categoria_estado">
                                    <!--<option value="">Seleccione el estado</option>-->
                                    <option value="ACTIVO" selected>ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
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