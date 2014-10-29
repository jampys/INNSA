<!doctype html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    var globalOperacion;
    var globalId;

        function editar(id_empleado){
            //alert(id_usuario);

            $.ajax({
                url:"index.php",
                data:{"accion":"empleado","operacion":"update","id":id_empleado},
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(){

                $("#dialog-msn").dialog("open");
                $("#message").html("ha ocurrido un error");

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $("#apellido").val(datas[0]['APELLIDO']);
                    $("#nombre").val(datas[0]['NOMBRE']);
                    $("#n_legajo").val(datas[0]['N_LEGAJO']);
                    $("#cuil").val(datas[0]['CUIL']);
                    $("#lugar_trabajo").val(datas[0]['LUGAR_TRABAJO']);
                    $("#empresa").val(datas[0]['EMPRESA']);
                    $("#funcion").val(datas[0]['FUNCION']);
                    $("#categoria").val(datas[0]['CATEGORIA']);
                    $("#division").val(datas[0]['DIVISION']);
                    $("#fecha").val(datas[0]['FECHA_INGRESO']);
                    $("#activo").val(datas[0]['ACTIVO']);
                    $("#email").val(datas[0]['EMAIL']);

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardar(){

            if($("#apellido").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el apellido ");
                return false;
            }

            if($("#nombre").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el nombre");
                return false;
            }

            if($("#cuil").val()==""){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el CUIL");
                return false;
            }

            if($("#lugar_trabajo").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar el lugar de trabajo");
                return false;
            }

            if($("#empresa").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la empresa");
                return false;
            }

            if($("#division").val()==0){
                $("#dialog-msn").dialog("open");
                $("#message").html("Ingresar la división");
                return false;
            }

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
                            "categoria":$("#categoria").val(),
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
                    "categoria":$("#categoria").val(),
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
                },
                close:function(){
                    $("#form")[0].reset(); //para limpiar el formulario cuando sale con x
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
            $('#fecha').datepicker('setDate', 'today');


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

    <div class="container_10">

        <header>

            <div class="clear"></div>

            <div class="grid_10">

            </div>

        </header>

        <div class="grid_10">
            <div class="box">
                <h2>
                    <a href="#" id="toggle-list">Lista de Empleados</a>
                </h2>


                <div class="block" id="list">
                    <a href="javascript:void(0);" id="dialog_link" media="insert">Agregar Empleado</a>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                        <tr>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>Lugar</th>
                            <th>Legajo</th>
                            <th>Empresa</th>
                            <th>Función</th>
                            <th>Categoria</th>
                            <th>División</th>
                            <!--<th width="12%">Editar</th> -->
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Apellido</th>
                            <th>Nombre</th>
                            <th>Lugar</th>
                            <th>Legajo</th>
                            <th>Empresa</th>
                            <th>Función</th>
                            <th>Categoria</th>
                            <th>División</th>
                            <th>Editar</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php foreach ($view->empleados as $emp) {?>
                            <tr class="odd gradeA">
                                <td><?php  echo $emp["APELLIDO"]; ?></td>
                                <td><?php  echo $emp["NOMBRE"];  ?></td>
                                <td><?php  echo $emp["LUGAR_TRABAJO"]; ?></td>
                                <td><?php  echo $emp["N_LEGAJO"]; ?></td>
                                <td><?php  echo $emp["EMPRESA"]; ?></td>
                                <td><?php  echo $emp["FUNCION"]; ?></td>
                                <td><?php  echo $emp["CATEGORIA"]; ?></td>
                                <td><?php  echo $emp["DIVISION"]; ?></td>
                                <td class="center"><a href="" media="edit" class="edit_link" id="<?php  echo $emp["ID_EMPLEADO"];  ?>">Editar</a></td>
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
                                    <label>Lugar de trabajo: </label>
                                    <select name="lugar_trabajo" id="lugar_trabajo">
                                        <option value="0">Ingrese un lugar</option>
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
                                        <option value="0">Ingrese una empresa</option>
                                        <option value="INNOVISION">Innovision</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Función: </label>
                                    <input type="text" name="funcion" id="funcion"/>
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
                                    <label>Categoría: </label>
                                    <input type="text" name="categoria" id="categoria"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>División: </label>
                                    <select name="division" id="division">
                                        <option value="0">Ingrese una división</option>
                                        <option value="SISTEMAS">Sistemas</option>
                                        <option value="ADMINISTRACION">Administración</option>
                                        <option value="RRHH">RRHH</option>
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
                                        <option value="0">Inactivo</option>
                                        <option value="1">Activo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="sixteen_column section">
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>E-mail: </label><br/>
                                    <textarea type="text" name="email" id="email" rows="2"/></textarea>
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