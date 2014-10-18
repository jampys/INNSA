<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>




            <br/>
            <div class="texto">Ingresa tus datos para acceder al sistema</div>
            <br/>

            <form id="FormularioAcceso" name="FormularioAcceso" method="post" action="">

                <table width="432" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="f7f6f3">

                    <tr>
                        <td width="203"><div align="left" class="texto">
                                <div align="right"><strong>USUARIO:</strong></div>
                            </div></td>
                        <td width="6">&nbsp;</td>
                        <td width="223"><label>
                                <input name="usuario" type="text" id="usuario" size="25" maxlength="20"/>
                            </label></td>
                    </tr>
                    <tr>
                        <td><div align="left" class="texto">
                                <div align="right"><strong>PASSWORD:</strong></div>
                            </div></td>
                        <td>&nbsp;</td>
                        <td><label>
                                <input name="password" type="password" id="password" size="25" maxlength="20"   />
                                <input type="hidden" name="operacion" value='login' />
                            </label></td>
                    </tr>
                    <tr>
                        <td colspan="3"><label>
                                <div align="center">
                                    <input type="submit" name="Submit" value="Ingresar"  class="texto"/>
                                </div>
                            </label></td>
                    </tr>
                </table>
            </form>









</body>
</html>