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
                title:"Acceso al sistema",
                buttons: {
                    "Ingresar": function() {
                        $("#form").submit();

                    },
                    "Cancelar": function() {
                        $("#form")[0].reset(); //para limpiar el formulario
                        //$(this).dialog("close");
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
                    usuario: {
                        required: true,
                        maxlength: 20,
                        minlength: 3
                    },
                    password: {
                        required: true,
                        minlength: 3
                    }
                },
                messages:{
                    usuario: "Ingrese su usuario",
                    password: "Ingrese su contraseña"
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
                        <legend>Ingrese sus datos</legend>

                        <div class="sixteen_column section">
                            <div class="eight column">
                                <div class="column_content">
                                    <label>Login: </label>
                                    <input type="text" name="usuario" id="usuario"/>
                                </div>
                            </div>

                            <div class="eight column">
                                <div class="column_content">
                                    <label>Password: </label>
                                    <input type="password" name="password" id="password"/>
                                    <input type="hidden" name="operacion" value='login' />
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