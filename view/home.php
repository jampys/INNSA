<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>INNSA Sistema de Capacitación</title>
    <link href="../public/css/estilos.css" type="text/css" rel="stylesheet" />
</head>



<body>

<center>
    <div id="principal">
        <div id="header">INNSA Sistema de Capacitación</div>
        <div id="main">



            <div id="content">

                <div id="menu">
                    <?php include("menu.php");?>

                </div>

                <div id="contenedor">

                    <?php
				for ($i=0;$i<7; $i++)
				{
				?>

                        <div id="titulo_post">
                            <div id="titulo">VideoTutorial 10 de PHP POO</div>
                            <div id="fecha">Jueves 01 de Septiembre de 2010</div>
                        </div>
                        <div id="texto_post">

                            Este es el VideoTutorial 8 del Curso de PHP POO.
                            Continuamos trabajando con nuestra clase Conectar.. En esta ocasión, la usaremos para insertar registros en la tabla libro_de_visitas. Usaremos la sentencia mysql insert into.
                            Nos basaremos en las clases que construimos en el video anterior. Crearemos un nuevo método para poder insertar los registros, y a este método le aplicaremos javascript, básicamente la función alert y window.location para indicarle al usuario que el registro ha sido ingresado correctamente....
                        </div>



                    <div id="div_entre_post"></div>
                    <?php
				}
				?>



                </div>
                <div id="sidebar">

                    este el el sidebar

                </div>



                <div id="footer">

                    &copy; Desarrollado por Web DP 2014 - <?php echo date("Y");?>
                </div>
            </div>
        </div>

    </div>
</center>

</body>


</html>
</html>