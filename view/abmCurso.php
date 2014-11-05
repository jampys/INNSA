<!doctype html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <script type="text/javascript">
    var globalOperacion="";
    var globalId;


        function cargarTemas(opcion){
            var categoria=$("#categoria option:selected").val();
            //alert(categoria);

            $.ajax({
                url:"index.php",
                data:{"accion":"curso","operacion":"getTemas","id":categoria},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                    $("#dialog-msn").dialog("open");
                    $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#tema").html('<option value="">Ingrese un tema</option>');
                    $.each(datas, function(indice, val){
                        //$("#tema").append("<option value='"+datas[indice]['ID_TEMA']+"'>"+datas[indice]['NOMBRE']+"</option>");
                        $("#tema").append(new Option(datas[indice]["NOMBRE"],datas[indice]["ID_TEMA"] ));


                    });
                    if(opcion!=0){ //si recibe un id (al ser una edicion => selecciona la opcion)
                        $("#tema").val(opcion);
                    }


                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });
        }

        function editar(id_curso){
                //alert(id_curso);

            $.ajax({
                url:"index.php",
                data:{"accion":"curso","operacion":"update","id":id_curso},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#nombre").val(datas[0]);
                    $("#descripcion").val(datas[1]);
                    $("#comentarios").val(datas[2]);
                    $("#entidad").val(datas[3]);
                    $("#categoria").val(datas[4]);
                    cargarTemas(datas[5]);
                    //$("#tema option[value='datas[5]']").attr("selected", true);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            if(globalOperacion=="insert"){ //se va a guardar un curso nuevo
                var url="index.php";
                var data={"accion":"curso","operacion":"insert","nombre":$("#nombre").val(),"descripcion":$("#descripcion").val(),"comentarios":$("#comentarios").val(), "entidad":$("#entidad").val(), "tema":$("#tema").val()};
            }
            else{ //se va a guardar un curso editado
                var url="index.php";
                var data={"accion":"curso","operacion":"save", "id":globalId, "nombre":$("#nombre").val(),"descripcion":$("#descripcion").val(),"comentarios":$("#comentarios").val(), "entidad":$("#entidad").val(), "tema":$("#tema").val()};
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
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardar();
                            $("#dialog").dialog("close");
                            //Agregado por dario para recargar grilla al modificar o insertar
                            self.parent.location.reload();
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

                //Agregado dario
                /*
                ,open: function(){
                    alert(globalOperacion);
                    alert(globalId);
                }*/
                //fin agregado dario

            });

            // Dialog Link
            $('#dialog_link').click(function(){
                globalOperacion=$(this).attr("media");
                $('#dialog').dialog('open');
                return false;
            });

            //Agregado por dario para editar
            $(document).on("click", ".edit_link", function(){
                globalOperacion=$(this).attr("media");
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                return false;
            });
            //Fin agregado

            // Datepicker
            $('#fecha').datepicker({
                inline: true
                ,dateFormat:"dd/mm/yy"
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
                nombre: {
                    required: true,
                    maxlength: 100,
                    minlength: 5
                },
                entidad: {
                    required: true
                },
                categoria: {
                    required: true
                },
                tema: {
                    required: true
                }
            },
            messages:{
                nombre: "Ingrese su nombre",
                entidad: "Ingrese su entidad",
                categoria: "Seleccione una categoria",
                tema: "Seleccione un tema"
            }

        });


    };




    </script>

</head>


<body>

<div id="principal">

    <div class="container_16">

        <header>

            <div class="clear"></div>

            <div class="grid_16">

            </div>

        </header>

        <div class="grid_16">
            <div class="box">
                <h2>
                    <a href="#" id="toggle-list">Lista de Cursos</a>
                </h2>


                <div class="block" id="list">
                    <a href="javascript:void(0);" id="dialog_link" media="insert">Agregar Curso</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Entidad</th>
                            <th width="12%">Editar</th>
                            <th width="12%">Eliminar</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Entidad</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($view->cursos as $curso) {?>
                            <tr class="odd gradeA">
                                <td><?php  echo Conexion::corta_palabra($curso["NOMBRE"], 35);  ?></td>
                                <td><?php  echo Conexion::corta_palabra($curso["DESCRIPCION"], 35); ?></td>
                                <td><?php  echo $curso["ENTIDAD"]; ?></td>
                                <td class="center"><a href="javascript: void(0);" media="edit" class="edit_link" id="<?php  echo $curso["ID_CURSO"];  ?>">Editar</a></td>
                                <td class="center"><a href="">Eliminar</a></td>
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

                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Nombre: </label>
                                    <input type="text" name="nombre" id="nombre"/>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Descripcion: </label><br/>
                                    <textarea name="descripcion" id="descripcion" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Comentarios: </label>
                                    <textarea name="comentarios" id="comentarios" rows="5"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Entidad: </label>
                                    <input type="text" name="entidad" id="entidad"/>
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
                                    <label>Categoria: </label>
                                    <select name="categoria" id="categoria" onchange="cargarTemas();">
                                        <option value="">Ingrese una categoria</option>
                                        <option value="1">Habilidades soft</option>
                                        <option value="2">Gestión</option>
                                        <option value="3">Industria Oil</option>
                                        <option value="4">Técnico</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Tema: </label>
                                    <select name="tema" id="tema">
                                        <!-- select dependiente... se carga dinamicamente al seleccionar la categoria -->
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