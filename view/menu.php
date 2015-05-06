
<html>
    <head>

        <script type="text/javascript">

            $(document).ready(function(){
            //$(window).load(function(){
                $("#menux").menu();
            });


        </script>

        <style type="text/css">

            /* En vez de un div uso una etiqueta propia llamada nav*/
            #menuIzq nav {
                position: relative;
                /*top: 5px; */
            }

            #menuIzq nav a {
                padding: 5px 5px;
                border-bottom: 1px dotted #c0c0c0;
                display: block;
                clear: both;
                font: normal 400 12px/18px 'Open Sans', Helvetica, Arial, sans-serif;
                color: #656565;
                text-decoration: none;
            }

            #menuIzq nav a:hover {
                color: #ec6912;
            }

        </style>


    </head>
    <body>

    <ul id="menux">
        <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
            <li><a href="index.php?accion=empleado">Empleados</a></li>
        <?php   } ?>


        <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2 || $_SESSION['ACCESSLEVEL']==3){  ?>
            <li><a href="index.php?accion=curso">Cursos</a></li>
        <?php   } ?>


        <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
                <li><a href="index.php?accion=cap_plan">Plan capacitación</a></li>
        <?php   } ?>


        <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2 || $_SESSION['ACCESSLEVEL']==3){  ?>
                <li><a href="index.php?accion=cap_solic">Solicitud capacitación</a></li>
        <?php   } ?>


        <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
                <li><a href="index.php?accion=autorizacion_aprobacion">Autorización/Aprobación</a></li>
                <li><a href="index.php?accion=asignacion">Asignacion plan</a></li>
        <?php   } ?>


        <!-- Opciones de menu solo para usuario administrador -->
        <?php if($_SESSION['ACCESSLEVEL']==2){ ?>
                <li><a href="index.php?accion=user">Usuarios</a></li>
        <?   } ?>


        <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
            <li><a href="#">Reportes</a>
                <ul style="z-index: 9999">
                    <li><a href="index.php?accion=reportes">Reporte Solicitudes</a></li>
                    <li><a href="index.php?accion=reportes&operacion=reportes1">Reporte Asignaciones</a></li>
                    <li><a href="index.php?accion=reportes&operacion=reportes2">Reporte cursos propuestos</a></li>
                    <li> <a href="index.php?accion=reportes&operacion=reportes3">Reporte gerencia</a></li>
                </ul>
            </li>
        <?   } ?>



            <li><a href="index.php?accion=vista_empleado">Cursos <?php
                $firstName=explode(" ", $_SESSION["USER_NOMBRE"]);
                echo $firstName[0]; ?>
            </a></li>



    </ul>


    </body>


</html>





