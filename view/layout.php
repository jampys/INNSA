<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>INNSA Sistema de Capacitación</title>
    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />
    <script language="javascript" type="text/javascript" src="../public/js/efectos.js"></script>
</head>


<body>

<center>
    <div id="principal">
        <div id="header">INNSA Sistema de Capacitación</div>
        <div id="main">



            <div id="content">

                <div id="menu">
                    <?php
                    if(isset($_SESSION["ses_id"])){

                        switch($_SESSION['ACCESSLEVEL']){
                            case 1:
                                include_once("menuAdm.php");
                                break;
                            case 2:
                                include("menuOp.php");
                                break;
                        }

                    }
                    ?>

                </div>

                <div id="contenedor">

                 <!-- **** ACA VAN LOS CONTENIDOS************* -->
                <?php


                if(isset($view->content)){
                    include_once("$view->content");
                }else{
                    echo "NO HAY CONTENIDOS PARA MOSTRAR";
                }


                ?>

                </div>
                <div id="sidebar">
                    <?php
                    if(isset($_SESSION["ses_id"])){
                        //include("menuOp.php");
                        include_once('view/sidebarUser.php');
                    }

                    ?>


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