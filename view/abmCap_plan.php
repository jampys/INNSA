<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en" class="no-js" xmlns="http://www.w3.org/1999/html"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Curso Jquery Video 30</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="stylesheet" href="public/html5Admin/css/style.css?v=2">

    <!-- fluid 960 -->
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/grid.css" media="screen" />
    <!-- superfish menu -->
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/superfish.css" media="screen" />
    <!-- tags css -->
    <link rel="stylesheet" href="public/html5Admin/css/jquery.tagsinput.css">
    <!-- treeview css -->
    <link rel="stylesheet" href="public/html5Admin/css/jquery.treeview.css">
    <!-- dataTable css -->
    <link rel="stylesheet" href="public/html5Admin/css/demo_table_jui.css">


    <!-- fluid GS -->
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/fluid.gs.css" media="screen" />
    <!--[if lt IE 8 ]>
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/fluid.gs.lt_ie8.css" media="screen" />
    <![endif]-->

    <!-- //jqueryUI css -->
    <link type="text/css" href="public/html5Admin/css/custom-theme/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />

    <!-- //jquery -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> -->
    <script src="public/html5Admin/js/jquery-1.9.1.min.js"></script>
    <script>!window.jQuery && document.write(unescape('%3Cscript src="public/html5Admin/js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
    <!-- //jqueryUI -->
    <script type="text/javascript" src="public/html5Admin/js/jquery-ui-1.9.2.custom.min.js"></script>

    <script type="text/javascript" src="public/html5Admin/js/jquery-fluid16.js"></script>
    <script src="public/html5Admin/js/plugins.js"></script>
    <script src="public/html5Admin/js/script.js"></script>

    <!-- //xoxco tags plugin https://github.com/xoxco/jQuery-Tags-Input -->
    <script src="public/html5Admin/js/jquery.tagsinput.min.js"></script>
    <link rel="stylesheet" href="public/html5Admin/css/jquery.tagsinput.css">

    <!--[if lt IE 7 ]>
    <script src="public/html5Admin/js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg');</script>
    <![endif]-->
    <!-- modernizr -->
    <script src="public/html5Admin/js/libs/modernizr-1.7.min.js"></script>

    <!-- superfish menu and needed js for menu -->
    <script src="public/html5Admin/js/superfish.js"></script>
    <script src="public/html5Admin/js/supersubs.js"></script>
    <script src="public/html5Admin/js/hoverIntent.js"></script>

    <!-- treeview -->
    <script src="public/html5Admin/js/jquery.treeview.js"></script>

    <!-- dataTable -->
    <script src="public/html5Admin/js/jquery.dataTables.min.js"></script>


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

                    $("#tema").html('<option value="0">Ingrese un tema</option>');
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
                    $("#importe").val(datas[0]['IMPORTE']);
                    $("#moneda").val(datas[0]['MONEDA']);
                    //cargarTemas(datas[5]);


                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            if($("#nombre").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un nombre");
                return false;
            }

            if($("#entidad").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar una entidad");
                return false;
            }

            if($("#categoria").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar una categoria");
                return false;
            }

            if($("#tema").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar un tema");
                return false;
            }

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

                    $("#dialog").dialog("close");
                    //Agregado por dario para recargar grilla al modificar o insertar
                    self.parent.location.reload();

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
                        guardar();

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar el formulario
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

                //Agregado dario
                /*
               , close:function(){

                }

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
                //alert("funciona el link edit");

                return false;
            });
            //Fin agregado

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

            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );

        });
    </script>

</head>


<body>

<div id="principal">

    <div class="container_8">

        <header>

            <div class="clear"></div>

            <div class="grid_8">

            </div>

        </header>

        <div class="grid_8">
            <div class="box">
                <h2>
                    <a href="#" id="toggle-list">Lista de Planes de Capacitación</a>
                </h2>


                <div class="block" id="list">
                    <a href="javascript:void(0);" id="dialog_link" media="insert">Agregar plan capacitación</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Periodo</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th>Duracion</th>
                            <th>Unidad</th>
                            <th>Estado</th>
                            <th>Importe</th>
                            <th>Moneda</th>
                            <th>Cantidad</th>

                            <!--<th width="12%">Editar</th>
                            <th width="12%">Eliminar</th> -->
                            <th>Editar</th>
                            <th>Eliminar</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Curso</th>
                            <th>Periodo</th>
                            <th>Fecha desde</th>
                            <th>Fecha hasta</th>
                            <th>Duracion</th>
                            <th>Unidad</th>
                            <th>Estado</th>
                            <th>Importe</th>
                            <th>Moneda</th>
                            <th>Cantidad</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($view->cp as $plan) {?>
                            <tr class="odd gradeA">
                                <td><?php  echo Conexion::corta_palabra($plan["NOMBRE"], 30);  ?></td>
                                <td><?php  echo $plan["PERIODO"] ?></td>
                                <td><?php  echo $plan["FECHA_DESDE"]; ?></td>
                                <td><?php  echo $plan["FECHA_HASTA"]; ?></td>
                                <td><?php  echo $plan["DURACION"]; ?></td>
                                <td><?php  echo $plan["UNIDAD"]; ?></td>
                                <td><?php  echo $plan["ESTADO"]; ?></td>
                                <td><?php  echo $plan["IMPORTE"]; ?></td>
                                <td><?php  echo $plan["MONEDA"]; ?></td>
                                <td><?php  echo $plan["CANTIDAD"]; ?></td>
                                <td class="center"><a href="javascript: void(0);" media="edit" class="edit_link" id="<?php  echo $plan["ID_PLAN"];  ?>">Editar</a></td>
                                <td class="cen  ter"><a href="">Eliminar</a></td>
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
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Curso: </label><br/>
                                    <input type="text" name="curso" id="curso"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Periodo: </label>
                                    <select name="periodo" id="periodo">
                                        <option value="0">Ingrese el periodo</option>
                                        <option value="2010">2010</option>
                                        <option value="2011">2011</option>
                                        <option value="2012">2012</option>
                                        <option value="2013">2013</option>
                                        <option value="2014">2014</option>
                                        <option value="2015">2015</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Objetivo: </label><br/>
                                    <textarea name="objetivo" id="objetivo" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Modalidad: </label>
                                    <select name="modalidad" id="modalidad">
                                        <option value="0">Ingrese la modalidad</option>
                                        <option value="presencial">Presencial</option>
                                        <option value="a_distancia">A distancia</option>
                                        <option value="e_learning">E Learning</option>

                                    </select>
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
                                        <option value="0">Ingrese la unidad</option>
                                        <option value="Horas">Horas</option>
                                        <option value="Dias">Dias</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Prioridad: </label><br/>
                                    <select name="prioridad" id="prioridad">
                                        <option value="0">Ingrese la prioridad</option>
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
                                        <option value="0">Ingrese el estado</option>
                                        <option value="Propuesto">Propuesto</option>
                                        <option value="Cancelado">Cancelado</option>
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
                                        <option value="0">Ingrese la moneda</option>
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
                                    <input type="text" name="tipo_cambio" id="tipo_cambio"/>
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
                                        <option value="0">Ingrese la forma pago</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="transferencia">Transferencia</option>
                                        <option value="rapipago">Rapipago</option>
                                    </select>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Forma financiación: </label>
                                    <select name="forma_financiacion" id="forma_financiacion">
                                        <option value="0">Ingrese la financiación</option>
                                        <option value="1">1 pago</option>
                                        <option value="1">3 pagos</option>
                                        <option value="1">6 pagos</option>
                                        <option value="1">9 pagos</option>
                                        <option value="1">12 pagos</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Profesor 1: </label><br/>
                                    <input type="text" name="profesor1" id="profesor1"/>
                                </div>
                            </div>
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Profesor 2: </label>
                                    <input type="text" name="profesor2" id="profesor2"/>
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