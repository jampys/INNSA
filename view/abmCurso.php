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
                        var estado=(datas[indice]["ESTADO"]=="ACTIVO")? "":"disabled";
                        $("#tema").append('<option value="'+datas[indice]["ID_TEMA"]+'"'+estado+'>'+datas[indice]["NOMBRE"]+'</option>');
                        //$("#tema").append(new Option(datas[indice]["NOMBRE"],datas[indice]["ID_TEMA"] ));


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

                    $("#nombre").val(datas[0]['NOMBRE']);
                    $("#descripcion").val(datas[0]['DESCRIPCION']);
                    $("#comentarios").val(datas[0]['COMENTARIOS']);
                    $("#entidad").val(datas[0]['ENTIDAD']);
                    $("#categoria").val(datas[0]['ID_CATEGORIA']);
                    $("#tipo_curso").val(datas[0]['ID_TIPO_CURSO']);
                    cargarTemas(datas[0]['ID_TEMA']);
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
                var data={"accion":"curso","operacion":"insert","nombre":$("#nombre").val(),"descripcion":$("#descripcion").val(),"comentarios":$("#comentarios").val(), "entidad":$("#entidad").val(), "tema":$("#tema").val(), "tipo_curso":$("#tipo_curso").val()};
            }
            else if(globalOperacion=="edit"){ //se va a guardar un curso editado
                var url="index.php";
                var data={"accion":"curso","operacion":"save", "id":globalId, "nombre":$("#nombre").val(),"descripcion":$("#descripcion").val(),"comentarios":$("#comentarios").val(), "entidad":$("#entidad").val(), "tema":$("#tema").val(), "tipo_curso":$("#tipo_curso").val()};
            }
            else if(globalOperacion=="delete"){
                var url="index.php";
                var data={"accion":"curso","operacion":"delete", "id":globalId};
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
                            $('#principal').load('index.php',{accion:"curso", operacion: "refreshGrid"});
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

            //Dialog de confirmacion de eliminacion
            $("#delete_dialog").dialog({
                    modal: true,
                    title: 'Mensaje',
                    autoOpen: false,
                    width: '250',
                    resizable: false,
                    buttons: {
                        Aceptar: function () {
                            guardar();
                            $(this).dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"curso", operacion: "refreshGrid"});
                        },
                        Cancelar: function () {
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
                    }

                });



            //Agregado para editar un curso
            $(document).on("click", ".edit_link", function(){
                //globalOperacion=$(this).attr("media");
                globalOperacion='edit';
                globalId=$(this).attr('id');
                editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#dialog').dialog('open');
                return false;
            });

            //Para eliminar cursos
            $(document).on("click", ".delete_link", function(){
                globalOperacion='delete';
                globalId=$(this).attr('id');
                //editar(globalId); //le mando el id del usuario a editar que esta en el atributo id
                $('#delete_dialog').dialog('open');
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
                    maxlength: 100
                    //minlength: 5
                },
                descripcion: {
                    maxlength: 150
                },
                comentarios: {
                    maxlength: 150
                },
                /*entidad: {
                    required: true
                }, */
                categoria: {
                    required: true
                },
                tema: {
                    required: true
                },
                tipo_curso: {
                    required: true
                }
            },
            messages:{
                nombre: "Ingrese su nombre",
                descripcion: "Máximo 150 caracteres",
                comentarios: "Máximo 150 caracteres",
                //entidad: "Ingrese su entidad",
                categoria: "Seleccione una categoria",
                tema: "Seleccione un tema",
                tipo_curso: "Seleccione un tipo de actividad"
            }

        });


    };




    </script>

</head>


<body>

<div id="principal">

<!-- Aca se llama a la grilla ubicada en abmCursoGrid.php -->
    <?php require_once('abmCursoGrid.php')?>

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
                                    <label>Tipo de actividad: </label><br/>
                                    <select name="tipo_curso" id="tipo_curso">
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

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Objetivo: </label><br/>
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

                        <!-- Se quita la entidad y se coloca en el plan de capacitacion -->

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Categoria: </label>
                                    <select name="categoria" id="categoria" onchange="cargarTemas();">
                                        <option value="">Seleccione una categoria</option>
                                        <?php foreach($categorias as $cat){
                                            $estado=($cat['ESTADO']=='ACTIVA')? "": "disabled";
                                            ?>
                                            <option value="<?php echo $cat['ID_CATEGORIA']?>" <?php echo $estado ?> ><?php echo $cat['NOMBRE']?> </option>
                                        <?php }?>
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


<!-- dialog para blanqueo de password -->
<div id="delete_dialog">

    <div style='float: left; margin-top: 10px'><img src='public/img/warning-icon-yellow.png' width='30px' height='30px'></div>&nbsp;&nbsp;&nbsp;
    <div style='float: left; margin-left: 10px; margin-top: 18px'>
        ¿Desea eliminar el curso?
    </div>

</div>





</body>
</html>