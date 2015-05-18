

<script type="text/javascript" language="JavaScript">

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "columnDefs": [
                { "width": "100px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "150px", "targets": 2 },
                { "width": "600px", "targets": 9 }
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );




        //filtros
        //$(document).on('change', '#periodo, #lugar_trabajo', function(){
        $('#periodo, #lugar_trabajo').on('change', function(){
            //alert($('#periodo').val());
            $('#reporte').load(
                'index.php',
                {   accion:"reportes",
                    operacion: "reportes3",
                    periodo:$('#periodo').val(),
                    lugar_trabajo: $('#lugar_trabajo').val(),
                    filtro: 'filtro'
                }
            );

        });


        //***************************************** TODA LA FUNCIONALIDAD NUEVA ************************************

        var globalOperacion;
        var globalId;

        function aprobarPlan(id_plan){

            $.ajax({
                url:"index.php",
                data:{  "accion":"aprobacion",
                        "operacion":"update",
                        "id":id_plan,
                        "lugar_trabajo": $('#lugar_trabajo').val() }, //lo traigo del combo
                contentType:"application/x-www-form-urlencoded",
                dataType:"json",//xml,html,script,json
                error:function(error){

                    $("#dialog-msn").dialog("open");
                    //$("#message").html("ha ocurrido un error");
                    $("#message").html(error.responseText);

                },
                ifModified:false,
                processData:true,
                success:function(datas){

                    $.each(datas, function(indice, val){

                        var idCheck=datas[indice]['ID_ASIGNACION'];

                        $('#table_aprobar tbody').append('<tr id_asignacion='+idCheck+' operacion="">' +
                        '<td>'+datas[indice]['APELLIDO']+' '+datas[indice]['NOMBRE']+'</td>' +
                        '<td><input type="checkbox" id="table_aprobar_check_'+idCheck+'" name="table_aprobar_check_'+idCheck+'"></td>' +
                        '</tr>');

                        $("#table_aprobar_check_"+idCheck+"").prop('checked', ((datas[indice]['APROBADA'])==1)? true:false);
                    });

                },
                type:"POST",
                timeout:3000000,
                crossdomain:true

            });

        }


        function guardarCategoria(){

            //Codigo para recoger todas las filas de la table_aprobar
            jsonObj = [];
            $('#table_aprobar tbody tr').each(function () {
                item = {};
                item['id_asignacion']=$(this).attr('id_asignacion');
                //item['id_plan']=globalId; //id_plan
                item['check']= ($(this).find('td').eq(1).find('[type=checkbox]').prop('checked'))? 1: 0;
                item['operacion']=$(this).attr('operacion'); //si es una aprobacion dice "aprobar", sino esta vacio "".
                jsonObj.push(item);
                //alert(item['id_plan']);
            });

            if(globalOperacion=="aprobar_plan"){ //se va a guardar una nueva categoria
                var url="index.php";
                var data={  "accion":"aprobacion",
                            "operacion":"save",
                            "asignaciones_aprobar":JSON.stringify(jsonObj),
                            "id_plan": globalId

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


            //Si se chequea un checkbox
            $(document).on("change", "input[name^='table_aprobar_check']", function() { //si hago check en un input que comience con table_aprobar_check
                //alert("se modifico");
                $(this).closest('tr').attr('operacion', 'aprobar');
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
                title:"Aprobar plan capacitación",
                buttons: {
                    "Guardar": function() {
                        if($("#form").valid()){ //OJO valid() devuelve un booleano
                            guardarCategoria();
                            $("#categoria").dialog("close");
                            //Llamada ajax para refrescar la grilla
                            $('#principal').load('index.php',{accion:"administracion", operacion: "refreshGridCategorias"});
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
                    $('#table_aprobar tbody tr').each(function(){ $(this).remove(); }); //para limpiar la table_aprobar al salir
                }

            });



            //Aca estaba el llamado al dialog link

            //Agregado para editar
            $(document).on("click", ".aprobar_link", function(){
                globalOperacion='aprobar_plan';
                globalId=$(this).attr('id');
                aprobarPlan(globalId); //le mando el id del plan
                $('#categoria').dialog('open');

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









    });

</script>

<h5>
    <a href="#" id="toggle-list">REPORTE: Costos de capacitación</a>
</h5>


<div class="sixteen_column section">
    <div class="four column">
        <div class="column_content">
            <label>Período: </label><br/>
            <select name="periodo" id="periodo">
                <option value="">Todos los períodos</option>
                <<?php
                foreach ($periodos as $per){
                    ?>
                    <option value="<?php echo $per["PERIODO"]; ?>"><?php echo $per["PERIODO"]; ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="four column">
        <div class="column_content">
            <label>Lugar de trabajo: </label>
            <select name="lugar_trabajo" id="lugar_trabajo">
                <option value="">Todos los lugares de trabajo</option>
                <option value="BO">Bolivia</option>
                <option value="BUE">Buenos Aires</option>
                <option value="CH">Chubut</option>
                <option value="MZ">Mendoza</option>
                <option value="NQ">Neuquén</option>
                <option value="SC">Santa Cruz</option>
            </select>

        </div>
    </div>

    <div class="four column">
        <div class="column_content">

        </div>
    </div>
    <div class="four column">
        <div class="column_content">

        </div>
    </div>

</div>





<div id="reporte">

    <?php include('view/reportesGrid3.php');  ?>

</div>



<!-- AGREGADO NUEVO A BODY -->

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
                            <div class="sixteen_column">
                                <div class="column_content">
                                    <label>Empleados: </label><br/>
                                    <table id="table_aprobar" class="tablaSolicitud">
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



