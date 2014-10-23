<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>

            Ingresa tus datos para acceder al sistema

            <form id="FormularioAcceso" name="FormularioAcceso" method="post" action="">

                <table>
                    <tr>
                        <td>
                            USUARIO:
                        </td>
                        <td>
                            <input name="usuario" type="text" id="usuario" size="25" maxlength="20"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            PASSWORD:
                        </td>
                        <td>
                                <input name="password" type="password" id="password" size="25" maxlength="20"/>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="Submit" value="Ingresar"/>
                            <input type="hidden" name="operacion" value='login' />
                        </td>
                    </tr>
                </table>
            </form>










</body>
</html>