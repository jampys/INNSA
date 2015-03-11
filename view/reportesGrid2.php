
<script type="text/javascript" language="JavaScript">
    $(document).ready(function(){
        //oculta el detalle de cada fila del reporte
        $('.oculta').hide();

    });

</script>

<table cellpadding="0" cellspacing="0" width="100%" class="display" id="reportes">
    <thead>
    <tr>
        <th>Cursos</th>
        <th style="text-align: center">Cantidad</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Cursos</th>
        <th style="text-align: center">Cantidad</th>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($view->cursos as $cur) {?>
        <tr class="odd gradeA">
            <td style="background-color: #FFD699"><?php  echo $cur["NOMBRE"]; ?></td>
            <td style="background-color: #FFD699; font-weight:bold; text-align: center"><?php  echo $cur["CANTIDAD"];  ?></td>
        </tr>
        <tr class="oculta">
            <td colspan="2">



                <?php
                require_once("model/reportesModel.php");
                $a=new Reportes();
                $empleados=$a->getEmpleadosByCurso($cur["ID_CURSO"]);
                if(isset($empleados)){

                ?>

                <table border="1">
                    <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>

                    </tr>

                    <?php

                    foreach ($empleados as $emp) {?>
                        <tr class="odd gradeA">
                            <td><?php  echo $emp["APELLIDO"]; ?></td>
                            <td><?php  echo $emp["NOMBRE"]; ?></td>


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