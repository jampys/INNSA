

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



    });

</script>





<div class="sixteen_column section">
    <div class="four column">
        <div class="column_content">
            <label>Periodo: </label><br/>
            <select>
                <option value="">Ingrese el periodo</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
            </select>
        </div>
    </div>
    <div class="four column">
        <div class="column_content">
            <label>Capacitaciones propuestas: </label><br/>
            <input type="text" name="curso" id="curso"/>
        </div>
    </div>
    <div class="four column">
        <div class="column_content">
            <label>Capacitaciones propuestas: </label><br/>
            <input type="text" name="curso" id="curso"/>
        </div>
    </div>
    <div class="four column">
        <div class="column_content">
            <label>Periodo: </label><br/>
            <select>
                <option value="">Ingrese el periodo</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
            </select>

        </div>
    </div>
</div>


<!--

            <table cellpadding="0" cellspacing="0" width="100%" class="display" id="example">
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
                    <th>División</th>
                    <th>División</th>
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
                    <th>División</th>
                    <th>División</th>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($view->solicitud as $sol) {?>
                    <tr class="odd gradeA">
                        <td><?php  echo $sol["APELLIDO"]; ?></td>
                        <td><?php  echo $sol["NOMBRE"];  ?></td>
                        <td><?php  echo $sol["LUGAR_TRABAJO"]; ?></td>
                        <td><?php  echo $sol["N_LEGAJO"]; ?></td>
                        <td><?php  echo $sol["EMPRESA"]; ?></td>
                        <td><?php  echo $sol["FUNCION"]; ?></td>
                        <td><?php  echo $sol["CATEGORIA"]; ?></td>
                        <td><?php  echo $sol["DIVISION"]; ?></td>
                        <td><?php  echo $sol["DIVISION"]; ?></td>
                        <td>
                            <table>
                                <tr>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Lugar</th>
                                    <th>Legajo</th>
                                    <th>Empresa</th>
                                    <th>Función</th>
                                    <th>Categoria</th>
                                    <th>División</th>
                                    <th>División</th>
                                </tr>
                                <tr>
                                    <td><?php  echo $sol["APELLIDO"]; ?></td>
                                    <td><?php  echo $sol["NOMBRE"];  ?></td>
                                    <td><?php  echo $sol["LUGAR_TRABAJO"]; ?></td>
                                    <td><?php  echo $sol["N_LEGAJO"]; ?></td>
                                    <td><?php  echo $sol["EMPRESA"]; ?></td>
                                    <td><?php  echo $sol["FUNCION"]; ?></td>
                                    <td><?php  echo $sol["CATEGORIA"]; ?></td>
                                    <td><?php  echo $sol["DIVISION"]; ?></td>
                                    <td><?php  echo $sol["DIVISION"]; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>



                <?php }  ?>

                </tbody>
            </table>


-->









<table cellpadding="0" cellspacing="0" width="100%" class="display" id="nada">
    <thead>
    <tr>
        <th>Periodo</th>
        <th>Fecha_solicitud</th>
        <th>Empleado</th>

    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Periodo</th>
        <th>Fecha_solicitud</th>
        <th>Empleado</th>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($view->solicitud as $sol) {?>
        <tr class="odd gradeA">
            <td style="background-color: #E6FF99"><?php  echo $sol["PERIODO"]; ?></td>
            <td style="background-color: #E6FF99"><?php  echo $sol["FECHA_SOLICITUD"];  ?></td>
            <td style="background-color: #E6FF99"><?php  echo $sol["EMPLEADO_APELLIDO"].' '.$sol['EMPLEADO_NOMBRE']; ?></td>

        </tr>
        <tr>
            <td colspan="3">



                <?php
                require_once("model/cap_solicModel.php");
                $a=new Asignacion_plan();
                $asignacion=$a->getAsignacionPlanBySolicitud($sol["ID_SOLICITUD"]);
                if(isset($asignacion)){

                ?>

                <table border="1">
                    <tr>
                        <th>Curso</th>
                        <th>Modalidad</th>
                        <th>Fecha inicio</th>
                        <th>Estado</th>
                        <th>Comunic</th>
                        <th>Nofif</th>
                        <th>Eval</th>
                    </tr>

                    <?php

                    foreach ($asignacion as $sol) {?>
                        <tr class="odd gradeA">
                            <td style="width: 300px"><?php  echo $sol["NOMBRE"]; ?></td>
                            <td style="width: 70px"><?php  echo $sol["MODALIDAD"]; ?></td>
                            <td style="width: 50px"><?php  echo $sol["FECHA_DESDE"];  ?></td>
                            <td style="width: 100px"><?php  echo $sol["ESTADO"]; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["ESTADO"]=='COMUNICADO' || $sol["ESTADO"]=='NOTIFICADO' || $sol["ESTADO"]=='EVALUADO')? '<img src="public/img/Ok-icon.png" width="15px" height="15px">': ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["ESTADO"]=='NOTIFICADO' || $sol["ESTADO"]=='EVALUADO')? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>
                            <td style="width: 40px; text-align: center"><?php  echo ($sol["ESTADO"]=='EVALUADO')? '<img src="public/img/Ok-icon.png" width="15px" height="15px">' : ''; ?></td>



                        </tr>


                    <?php
                    }

                    }
                    ?>

                </table>




            </td>
        </tr>



    <?php }  ?>

    </tbody>
</table>



