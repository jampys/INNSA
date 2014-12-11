<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ERROR | Sistema INNSA</title>


    <script type="text/javascript" language="javascript">

        $(document).ready(function(){


            // Dialog mensaje
            $('#dialog-msn').dialog({
                autoOpen: true,
                width: 300,
                modal:true,
                title:"Alerta",
                buttons: {
                    "Aceptar": function() {
                        $(this).dialog("close");
                        window.location = 'index.php';
                    }

                },
                show: {
                    effect: "blind",
                    duration: 500
                },
                hide: {
                    effect: "explode",
                    duration: 500
                }
            });


            //$("#dialog-msn").dialog("open");
            //$("#message").html("<?php echo (isset($_SESSION['error']))? $_SESSION['error'] : 'OTRO ERROR' ; ?>");
            $("#message").append("<div style='float: left; margin-top: 7px'><img src='public/img/warning-icon.png' width='30px' height='30px'></div>&nbsp;&nbsp;&nbsp;");
            $("#message").append("<div style='float: left; margin-left: 10px; margin-top: 14px'><?php echo (isset($_SESSION['error']))? $_SESSION['error'] : 'OTRO ERROR' ; ?></div>");


        });


    </script>



</head>

<body>

<div id="dialog-msn">
    <div id="message"></div>
</div>





<!--
<table>

                <tr>
                    <td><div align="center">
                            <p>
                                <?php
                                if(isset($_SESSION['error']))

                                    echo $_SESSION['error'];
                                else
                                    echo "OTRO ERROR";

                                ?>
                            </p>
                            <p><a href="index.php">volver</a> </p>
                        </div>
                    </td>
                </tr>
</table>
-->



</body>
</html>
