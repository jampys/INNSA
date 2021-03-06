<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>INNSA Sistema de Capacitación</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="stylesheet" href="public/html5Admin/css/style.css?v=2">

    <!-- fluid 960 -->
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/text.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/layout.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/grid.css" media="screen" />
    <!-- superfish menu -->
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/superfish.css" media="screen" />
    <!-- tags css -->
    <link rel="stylesheet" href="public/html5Admin/css/jquery.tagsinput.css">
    <!-- treeview css -->
    <link rel="stylesheet" href="public/html5Admin/css/jquery.treeview.css">
    <!-- dataTable css -->
    <link rel="stylesheet" href="public/html5Admin/css/demo_table_jui.css">


    <!-- fluid GS -->
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/fluid.gs.css" media="screen" />
    <!--[if lt IE 8 ]>
    <link rel="stylesheet" type="text/css" href="public/html5Admin/css/fluid.gs.lt_ie8.css" media="screen" />
    <![endif]-->

    <!-- //jqueryUI css -->
    <link type="text/css" href="public/html5Admin/css/custom-theme/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />

    <!-- //jquery -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> -->
    <script src="public/html5Admin/js/jquery-1.9.1.min.js"></script>
    <script>!window.jQuery && document.write(unescape('%3Cscript src="public/html5Admin/js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
    <!-- //jqueryUI -->
    <script type="text/javascript" src="public/html5Admin/js/jquery-ui-1.9.2.custom.min.js"></script>

    <script type="text/javascript" src="public/html5Admin/js/jquery-fluid16.js"></script>
    <script src="public/html5Admin/js/plugins.js"></script>
    <script src="public/html5Admin/js/script.js"></script>

    <!-- //xoxco tags plugin https://github.com/xoxco/jQuery-Tags-Input -->
    <script src="public/html5Admin/js/jquery.tagsinput.min.js"></script>
    <link rel="stylesheet" href="public/html5Admin/css/jquery.tagsinput.css">

    <!--[if lt IE 7 ]>
    <script src="public/html5Admin/js/libs/dd_belatedpng.js"></script>
    <script> DD_belatedPNG.fix('img, .png_bg');</script>
    <![endif]-->
    <!-- modernizr -->
    <script src="public/html5Admin/js/libs/modernizr-1.7.min.js"></script>

    <!-- superfish menu and needed js for menu -->
    <script src="public/html5Admin/js/superfish.js"></script>
    <script src="public/html5Admin/js/supersubs.js"></script>
    <script src="public/html5Admin/js/hoverIntent.js"></script>

    <!-- treeview -->
    <script src="public/html5Admin/js/jquery.treeview.js"></script>

    <!-- dataTable -->
    <script src="public/html5Admin/js/jquery.dataTables.min.js"></script>

    <link href="public/css/estilos.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript" language="JavaScript" src="public/js/jquery.validate.js"></script>

    <script type="text/javascript" language="JavaScript" src="public/js/js_dario.js"></script>

    <!-- datetimepicker -->
    <script language="javascript" src="public/js/jquery-ui-timepicker-addon.js"></script>
    <link rel="stylesheet" href="public/css/jquery-ui-timepicker-addon.css" />


    <script type="text/javascript" language="javascript">

        $(window).scroll(function(){
            $('#header').css({
                'left': $(this).scrollLeft()  //Why this 15, because in the CSS, we have set left 15, so as we scroll, we would want this to remain at 15px left
            });

        });


        $(window).scroll(function(){
            $('#footer').css({
                'left': $(this).scrollLeft()  //Why this 15, because in the CSS, we have set left 15, so as we scroll, we would want this to remain at 15px left
            });

        });


    </script>

    <style type="text/css">

        #header p{
            text-align: left;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 17.5px;
            color: ivory;
            padding: 0px 0px 0px 5px;
            text-shadow: none;
            font-weight: bold;

        }
    </style>

</head>


<body>


        <!--<div id="principalLayout">-->
        <div id="header">
            <a style="padding-left: 5px" href="index.php"><img src="public/img/logo.gif"></a>
            <p>Sistema de capacitación</p>
        </div>



            <div id="content">

                <div id="menuIzq">
                    <?php
                    if(isset($_SESSION["ses_id"])){

                        require_once("menu.php");

                    }
                    ?>

                </div>

                <div id="contenedor">

                 <!-- **** ACA VAN LOS CONTENIDOS************* -->
                <?php
                if(isset($view->content)){
                    //include_once("$view->content");
                    include("$view->content");
                }
                ?>

                </div>

                <div id="sidebar">
                    <?php
                    if(isset($_SESSION["ses_id"])){
                        //include("menu.php");
                        include_once('view/sidebarUser.php');
                    }

                    ?>
                </div>



            </div>

            <div id="footer">
                &copy; Desarrollado por Innovisión 2015 - <?php echo date("Y");?>
            </div>


    <!--</div>-->





</body>


</html>
</html>