<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ERROR | Sistema INNSA</title>



</head>

<body>








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



</table>
</body>
</html>