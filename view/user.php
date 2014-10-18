<html>

<head>

</head>
<body>
<!-- muestra los resultados de la consulta en una tabla --->

<table>
    <tr>
        <td colspan="3" align="center"><h3>Titulo de la tabla</h3></td>
    </tr>
    <tr>
        <td><h4>LOGIN</h4></td>
        <td><h4>PASSWORD</h4></td>
        <td><h4>ID_PERFIL</h4></td>
    </tr>
    <?php

    foreach($view->usuarios as $reg){
        ?>
        <tr>
            <td><?php echo $reg["LOGIN"]; ?> </td>
            <td><?php echo $reg["PASSWORD"]; ?> </td>
            <td><?php echo $reg["ID_PERFIL"]; ?> </td>

        </tr>
        <?php

    }
    ?>

</table>
</body>

</html>