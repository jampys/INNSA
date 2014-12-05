
<html>
    <head>
        <style type="text/css">

            /* En vez de un div uso una etiqueta propia llamada nav*/
            #menuIzq nav {
                position: relative;
                top: 5px;
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




    <nav class="nav">
        <a href="index.php?accion=empleado" title="Recursos">Recursos</a>
    </nav>
    <nav class="nav">
        <a href="index.php?accion=curso" title="Cursos">Cursos</a>
    </nav>
    <nav class="nav">
        <a href="index.php?accion=cap_plan" title="Cursos">Plan capacitación</a>
    </nav>
    <nav class="nav">
        <a href="index.php?accion=cap_solic" title="Cursos">Solicitud capacitación</a>
    </nav>

    <nav class="nav">
        <a href="index.php?accion=autorizacion_aprobacion" title="Cursos">Autorización/Aprobación</a>
    </nav>

    <nav class="nav">
        <a href="index.php?accion=asignacion" title="Asignacion plan">Asignacion plan</a>
    </nav>
    <!--<nav class="nav">
        <a href="#" title="Evaluacion plan">Evaluacion plan</a>
    </nav>
    <nav class="nav">
        <a href="#" title="Post evaluacion plan">Post evaluacion plan</a>
    </nav>-->

    <!-- Opciones de menu solo para usuario administrador -->
    <?php
    if($_SESSION['ACCESSLEVEL']==1){
        ?>
        <nav class="nav">
            <a href="index.php?accion=user" title="Usuarios">Usuarios</a>
        </nav>
        <!--<nav class="nav">
            <a href="#" title="Alarmas">Alarmas</a>
        </nav>-->
        <nav class="nav">
            <a href="index.php?accion=reportes" title="Reportes">Reportes</a>
        </nav>
        <nav class="nav">
            <a href="index.php?accion=reportes&operacion=reportes1" title="Reportes">Reportes1</a>
        </nav>

    <?php
    }
    ?>

    <nav class="nav">
        <a href="index.php?accion=vista_empleado" title="Vista empleado">Vista empleado</a>
    </nav>




    </body>


</html>





