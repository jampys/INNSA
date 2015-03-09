<table cellpadding="0" cellspacing="0" width="100%" class="display" id="reportes">
    <thead>
    <tr>
        <th>Período</th>
        <th>Plan capacitación</th>
        <th>Cant. recursos</th>
        <th>Duración</th>
        <th>Unidad</th>
        <th>Total s/viáticos</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Período</th>
        <th>Plan capacitación</th>
        <th>Cant. recursos</th>
        <th>Duración</th>
        <th>Unidad</th>
        <th>Total s/viáticos</th>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach ($view->planes as $plan) {?>
        <tr class="odd gradeA">
            <td style="background-color: #FFD699"><?php  echo $plan["PERIODO"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["NOMBRE"];  ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["CANTIDAD"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["DURACION"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo $plan["UNIDAD"]; ?></td>
            <td style="background-color: #FFD699"><?php  echo "calcular"; ?></td>

        </tr>
        <tr>
            <td colspan="6">



                <?php
                require_once("model/cap_solicModel.php");
                $a=new Reportes();
                $repox=$a->getEmpleadosByPlan($lugar_trabajo, $plan["ID_PLAN"]);
                if(isset($repox)){

                ?>

                <table border="1">
                    <tr>
                        <th>Apellido</th>
                        <th>Nombre</th>
                        <th>Viaticos</th>
                    </tr>

                    <?php

                    foreach ($repox as $repo) {?>
                        <tr class="odd gradeA">
                            <td style="width: 300px"><?php  echo $repo["APELLIDO"]; ?></td>
                            <td style="width: 70px"><?php  echo $repo["NOMBRE"]; ?></td>
                            <td style="width: 50px"><?php  echo $repo["VIATICOS"];  ?></td>
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