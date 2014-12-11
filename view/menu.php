
<html>
    <head>
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



    <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
    <nav class="nav">
        <a href="index.php?accion=empleado">Recursos</a>
    </nav>
    <?   } ?>

    <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2 || $_SESSION['ACCESSLEVEL']==3){  ?>
    <nav class="nav">
        <a href="index.php?accion=curso">Cursos</a>
    </nav>
    <?   } ?>

    <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
    <nav class="nav">
        <a href="index.php?accion=cap_plan">Plan capacitación</a>
    </nav>
    <?   } ?>

    <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2 || $_SESSION['ACCESSLEVEL']==3){  ?>
    <nav class="nav">
        <a href="index.php?accion=cap_solic">Solicitud capacitación</a>
    </nav>
    <?   } ?>

    <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
    <nav class="nav">
        <a href="index.php?accion=autorizacion_aprobacion">Autorización/Aprobación</a>
    </nav>

        <nav class="nav">
            <a href="index.php?accion=asignacion">Asignacion plan</a>
        </nav>
    <?   } ?>



    <!--<nav class="nav">
        <a href="#">Evaluacion plan</a>
    </nav>
    <nav class="nav">
        <a href="#">Post evaluacion plan</a>
    </nav>-->

    <!-- Opciones de menu solo para usuario administrador -->
    <?php if($_SESSION['ACCESSLEVEL']==2){ ?>
        <nav class="nav">
            <a href="index.php?accion=user">Usuarios</a>
        </nav>
    <?   } ?>

        <!--<nav class="nav">
            <a href="#">Alarmas</a>
        </nav>-->

    <?php if($_SESSION['ACCESSLEVEL']==1 || $_SESSION['ACCESSLEVEL']==2){  ?>
        <nav class="nav">
            <a href="index.php?accion=reportes">Reporte Solicitudes</a>
        </nav>
        <nav class="nav">
            <a href="index.php?accion=reportes&operacion=reportes1">Reporte Asignaciones</a>
        </nav>
    <?   } ?>


    <nav class="nav">
        <a href="index.php?accion=vista_empleado">Vista empleado</a>
    </nav>




    </body>


</html>





