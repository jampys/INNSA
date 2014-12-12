

<!-----STYLESHEETS----->
<style type="text/css">

    /*****FONTS*****/

    @import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600,600italic,700italic,700,300italic,300|Acme); /* Acme font is required for .arrow */

    /*****END FONTS*****/

    /*****DEMO ONLY*****/

    ::selection {
        color: #fff;
        background: #ec6912;
    }

    ::-moz-selection {
        color: #fff;
        background: #ec6912;
    }

    * {
        margin: 0;
        padding: 0;
        border: none;
    }




    h1 {
        font: normal 600 48px/56px 'Source Sans Pro', Helvetica, Arial, sans-serif;
        text-shadow: 1px 1px 0 rgba(255,255,255,0.75);
        margin-bottom: 30px;
    }

    p {
        text-shadow: 1px 1px 0 rgba(255,255,255,0.75);
        text-align: center;
    }

    strong {
        font-weight: 700;
    }








    /*****END DEMO ONLY*****/


    /*****ANIMATONS (optional)*****/

    #menu, #menu .arrow, #menu nav a {
        transition: all 0.4s;
        -moz-transition: all 0.4s;
        -webkit-transition: all 0.4s;
    }

    /*****END ANIMATONS*****/


    /*****PANEL*****/

    #menu {
        background: #f9f9f9;
        border-right: 3px solid #fff;
        /*width: 100px; */
        padding: 30px;
        position: fixed;
        z-index: 100000;

        box-shadow: 1px 0 3px rgba(0,0,0,0.25);
        -moz-box-shadow: 1px 0 3px rgba(0,0,0,0.25);
        -webkit-box-shadow: 1px 0 3px rgba(0,0,0,0.25);
    }

    #menu {
        right: -130px; /* Change to right: 0; if you want the panel to display on the right side. */
    }

    #menu:hover, #menu:focus {
        right: 0 !important; /* Change to right: 0 !important; if you want the panel to display on the right side. */
    }

    #menu .arrow {
        left: 2px; /* Change to left: 2px; if you want the panel to display on the right side. */
    }

    #menu .arrow {
        font: normal 400 25px/25px 'Acme', Helvetica, Arial, sans-serif; /* Acme font is required for .arrow */
        color: rgba(0,0,0,0.75); /* Arrow color */
        width: 16px;
        height: 25px;
        display: block;
        position: absolute;
        top: 20px;
        cursor: default;
    }

    #menu:hover .arrow {
        transform: rotate(-180deg) translate(6px,-3px);
        -moz-transform: rotate(-180deg) translate(6px,-3px);
        -webkit-transform: rotate(-180deg) translate(6px,-3px);
    }

    #menu nav {
        position: relative;
        top: 5px;
    }

    #menu nav a {
        padding: 20px 5px;
        border-bottom: 1px dotted #c0c0c0;
        display: block;
        clear: both;
        font: normal 400 12px/18px 'Open Sans', Helvetica, Arial, sans-serif;
        color: #656565;
        text-decoration: none;
    }

    #menu nav a:hover {
        color: #ec6912;
    }

    /*****END PANEL*****/

</style>

<!-----SCRIPTS----->


<!-----SLIDING PANEL HEIGHT ADJUST TO DOCUMENT HEIGHT----->
<script type="text/javascript">
    $(document).ready(function() {
        //$("#menu").height($(document).height());
        $("#menu").height($("#content").height());
    });
</script>

<!-----SLIDING PANEL DELAY AND HIDE----->
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout( function(){$('#menu').css('right','-130px');},3000); <!-- Change 'left' to 'right' for panel to appear to the right -->
    });
</script>

</head>

<body>

<!-----SLIDING MENU PANEL----->
<div id="menu" style="text-align: center">
    <div class="arrow"><</div>
    <nav class="nav">
        <img src="public/img/user.png" width="75" height="75">
        <p><?php
                $firstName=explode(" ", $_SESSION["USER_NOMBRE"]);
                echo $firstName[0];

            ?></p>

        <a href="index.php?accion=login&operacion=salir">Cerrar Sesion</a>

    </nav>
</div>
<!-----END SLIDING MENU PANEL----->



</body>
</html>
