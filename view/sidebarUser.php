<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    <img src="public/img/user.png" width="75" height="75">
    <br/>
    <?php echo $_SESSION["user"]?>
    <br/>
    <p><a href="index.php?accion=login&operacion=salir">Cerrar Sesion</a></p>
</body>


</html>