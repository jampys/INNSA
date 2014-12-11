<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="public/css/estilos.css">


    <script type="text/javascript" language="JavaScript">


        $(document).ready(function(){

            $('#dialog').dialog({
                autoOpen: true,
                width: 400,
                modal:true,
                title:"Blanqueo de password",
                buttons: {
                    "Guardar": function() {
                        $("#form").submit();

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar el formulario
                        $(this).dialog("close");
                    }
                },
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }

            });

            //validacion de formulario
            $('#form').validate({
                rules: {
                    password: {
                        required: true,
                        maxlength: 20,
                        minlength: 3
                    },
                    password_again: {
                        equalTo: "#password"
                    }
                },
                messages:{
                    password: "Ingrese un password (Máx 10 caracteres)",
                    password_again: "Reingrese el password"
                }

            });


        });



    </script>

</head>

<body>


<!-- ui-dialog -->
<div id="dialog" >

    <div class="grid_7">
        <div class="clear"></div>
        <div class="box">

            <div class="block" id="forms">
                <form id="form" action="index.php" method="post">
                    <fieldset>
                        <legend>Ingrese su nuevo password</legend>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Ingrese password: </label>
                                    <input type="password" name="password" id="password"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Reingrese password: </label>
                                    <input type="password" name="password_again" id="password_again"/>
                                    <input type="hidden" name="operacion" value='clear_pass' />
                                    <input type="hidden" name="id_usuario" value='<?php echo $view->id_usuario; ?>' />
                                </div>
                            </div>
                        </div>

                    </fieldset>

                </form>
            </div>
        </div>


    </div>

</div>



</body>
</html>