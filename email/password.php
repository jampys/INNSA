<!-- Este archivo es un template con el formato de e-mail para la comunicacion -->

<!-- Tener cuidado que los email client no soportan CSS => hay que escribirlos inline
     http://stackoverflow.com/questions/12751147/how-to-send-an-email-that-has-html-and-css-in-php   -->

<html xmlns="http://www.w3.org/1999/html">
<head>

</head>
<body>

    <div style="background-color: #000000">
        <img style="padding-left: 10px" src='http://innsa.com/images/logo.gif' alt='INNSA Comunicaciones'>
    </div>

    <div id="contenido" style="background-color: lavender; padding: 10px">

        <p style='font-weight: bold'><?php echo $emp[0]['APELLIDO'] ?> <?php echo $emp[0]['NOMBRE'] ?>:</p>
        <p>Por la presente le informamos su usuario y clave de acceso al sistema de capacitación de Innovisión SA.</p>

        <p><span style="font-weight: bold">Usuario: </span><?php echo $_POST['login'] ?></p>
        <p><span style="font-weight: bold">Password: </span><?php echo $pass ?></p>
        <p>El sistema al acceder por primera vez le exigira cambiar el password para su seguridad.</p>
        <br/>
        <p>Mensaje enviado desde Sistema de Capacitación INNSA</p>

    </div>

</body>
</html>

