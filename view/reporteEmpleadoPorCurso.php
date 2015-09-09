<!doctype html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;


    function cargarTemas(){
        var categoria=$("#categoria option:selected").val();

        if(categoria>=1){ //Si eligio alguna categoria

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

                    $("#tema").html('<option value="">Todos</option>');
                    $.each(datas, function(indice, val){
                        var estado=(datas[indice]["ESTADO"]=="ACTIVO")? "":"disabled";
                        $("#tema").append('<option value="'+datas[indice]["ID_TEMA"]+'"'+estado+'>'+datas[indice]["NOMBRE"]+'</option>');
                        //$("#tema").append(new Option(datas[indice]["NOMBRE"],datas[indice]["ID_TEMA"] ));

                    });


                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }

    }





        $(document).ready(function(){

            $(document).tooltip();

            // menu superfish
            $('#navigationTop').superfish();


            //Aca estaba el dataTable


            //autocompletar curos segun la categoria y temas ingresados
            $("#curso").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term,
                            "accion":"curso",
                            "operacion":"autocompletarCursosByTema",
                            "id_tema": $("#tema option:selected").val() //60 //id_tema
                        },
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
                delay: 0,
                minLength: 2,
                change: function(event, ui) {
                    $('#curso_id').val(ui.item? ui.item.id : '');
                    $('#curso').val(ui.item.label);
                }
            });


            //Autocompletar empleados
            $("#empleado").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "index.php",
                        type: "POST",
                        dataType: "json",
                        data: { "term": request.term, "accion":"empleado", "operacion":"autocompletar_empleados", "target":"ALL_ACTIVE_INACTIVE"},
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.APELLIDO+" "+item.NOMBRE,
                                    id: item.ID_EMPLEADO

                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                change: function(event, ui) {
                    $('#empleado_id').val(ui.item? ui.item.id : '');
                    $('#empleado').val(ui.item.label);
                }
            });





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




            $('#buscar').click(function(){

                if($("#form").valid()){ //OJO valid() devuelve un booleano


                    $('#principal').load('index.php',{  accion:"reportes",
                        operacion: "empleadoPorCurso",
                        buscar: "",
                        id_categoria: $("#categoria option:selected").val(),
                        id_tema: $("#tema option:selected").val(),
                        id_curso: $("#curso_id").val(),
                        id_empleado: $("#empleado_id").val(),
                        activos: $('#check_activos').prop('checked')? 1:0
                    });


                }


            });


            $('#categoria').change(function(){

                if($('#categoria option:selected').val()==''){
                    //alert('selecciono el cero');
                    $('#tema')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Todos</option>')
                        //.val('whatever')
                    ;

                }

                $("#curso").val('');
                $("#curso_id").val('');
                $("#empleado").val('');
                $("#empleado_id").val('');
                $('#check_activos').prop('checked', true);
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
            ignore:"",
            rules: {
                curso_id: {
                    required: function(item){return $('#curso').val().length>0;}
                },
                empleado_id: {
                    required: function(item){return $('#empleado').val().length>0;}
                }

            },
            messages:{
                curso_id: "Seleccione un curso sugerido",
                empleado_id: "Seleccione un colaborador sugerido"
            }

        });


    };

    </script>

</head>


<body>

<!--<div id="principal">-->
    <div class="container_10">

        <header>
            <div class="clear"></div>
        </header>

        <div class="box">

            <h2>
                <a href="#" id="toggle-list">Consulta de asignación de actividades</a>
            </h2>

            <div class="block" id="list">

                <form id="form" name="form" action="">
                <div class="sixteen_column section">

                    <div class="two column">
                        <div class="column_content">
                            <label>Categoria: </label>
                            <select name="categoria" id="categoria" onchange="cargarTemas();">
                                <option value="">Todas</option>
                                <?php foreach($categorias as $cat){
                                    $estado=($cat['ESTADO']=='ACTIVA')? "": "disabled";
                                    ?>
                                    <option value="<?php echo $cat['ID_CATEGORIA']?>" <?php echo $estado ?> ><?php echo $cat['NOMBRE']?> </option>
                                <?php }?>
                            </select>
                        </div>
                    </div>

                    <div class="two column">
                        <div class="column_content">
                            <label>Tema: </label>
                            <select name="tema" id="tema">
                                <!-- select dependiente... se carga dinamicamente al seleccionar la categoria -->
                            </select>
                        </div>
                    </div>

                    <div class="four column">
                        <div class="column_content">
                            <label>Curso: </label>
                            <input type="text" name="curso" id="curso"/>
                            <input type="hidden" name="curso_id" id="curso_id"/>
                        </div>
                    </div>

                    <div class="four column">
                        <div class="column_content">
                            <label>Colaborador: </label>
                            <input type="text" name="empleado" id="empleado"/>
                            <input type="hidden" name="empleado_id" id="empleado_id"/>
                        </div>
                    </div>

                    <div class="two column">
                        <div class="column_content">
                            <label>.</label>
                            <div class="checkbox_individual" style="margin-left: 15px">
                                <!--<div class="cbtitulo">Conformidad comunicación:</div>-->

                                <div class="cbcheck">
                                    <div class="check" style="margin-top: 6px"><input type="checkbox" id="check_activos" name="check_activos" checked /></div>
                                    <div class="lab" style="margin-top: 6px">Solo activos</div>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="two column">
                        <div class="column_content">
                            <label>.</label>
                            <input type="button" name="buscar" id="buscar" value="Buscar"/>
                        </div>
                    </div>

                    <div class="six column">

                    </div>
                </div>
                </form>


                <div id="principal">

                    <!-- Aca se llama a la grilla en el archivo reporteEmpleadoPorCursoGrid.php -->
                    <?php require_once('reporteEmpleadoPorCursoGrid.php') ?>

                </div>

            </div>

         </div>

        </div>

<!--</div> -->

<!-- ui-dialog mensaje -->
<div id="dialog-msn">
    <p id="message"></p>
</div>





</body>
</html>