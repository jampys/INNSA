<script type="text/javascript" language="JavaScript">


    function cargarTemas(){
        var categoria=$("#categoria option:selected").val();

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

    $(document).ready(function(){

        // dataTable
        var uTable = $('#example').dataTable( {
            "scrollY": "auto",
            "scrollX": true,
            "autoWidth": true,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "columnDefs": [
                { "width": "150px", "targets": 0 },
                { "width": "150px", "targets": 1 },
                { "width": "100px", "targets": 5 },
                { "width": "200px", "targets": 6 }
            ]
        } );
        $(window).bind('resize', function () {
            uTable.fnAdjustColumnSizing();
        } );


        // Dialog Link
        $('#dialog_link').click(function(){
            //globalOperacion=$(this).attr("media");
            globalOperacion='insert';
            $('#dialog').dialog('open');
            return false;
        });


    });

</script>




<div class="container_10">

    <header>

        <div class="clear"></div>


    </header>

    <div class="box">
        <h2>
            <a href="#" id="toggle-list">Reporte de colaboradores por curso/tema</a>
        </h2>


        <div class="block" id="list">

            <!--<a href="javascript:void(0);" id="dialog_link">Agregar colaborador</a>-->

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
                        <input type="text" name="n_legajo" id="n_legajo"/>
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



            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                <tr>
                    <th>Apellido</th>
                    <th>Nombre</th>
                    <th>Lugar</th>
                    <th>Legajo</th>
                    <th>Empresa</th>
                    <th>División</th>
                    <th>Función</th>
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
                    <th>División</th>
                    <th>Función</th>
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
                        <td><?php  echo $emp["DIVISION"]; ?></td>
                        <td><?php  echo $emp["FUNCION"]; ?></td>
                        <td class="center"><a href="" class="edit_link" id="<?php  echo $emp["ID_EMPLEADO"];  ?>"><img title="Editar" src="public/img/Pencil-icon.png" width="15px" height="15px"></a></td>
                    </tr>
                <?php }  ?>

                </tbody>
            </table>
        </div>


    </div>


</div>