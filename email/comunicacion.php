<!-- Este archivo es un template con el formato de e-mail para la comunicacion -->

<!-- Tener cuidado que los email client no soportan CSS => hay que escribirlos inline
     http://stackoverflow.com/questions/12751147/how-to-send-an-email-that-has-html-and-css-in-php   -->

<html>
<head>

</head>
<body>

    <div style="background-color: #000000">
        <img style="padding-left: 10px" src='http://innsa.com/images/logo.gif' alt='INNSA Comunicaciones'>
    </div>

    <div id="contenido" style="background-color: lavender; padding: 10px">

        <p style='font-weight: bold'><?php echo $com[0]['APELLIDO'] ?> <?php echo $com[0]['NOMBRE'] ?>:</p>
        <p>Por la presente le informamos que esta inscripto en el curso <b><?php echo $com[0]['CURSO'] ?></b> a realizarse desde el
            <?php echo $com[0]['FECHA_DESDE'] ?> hasta el  <?php echo $com[0]['FECHA_HASTA'] ?></p>
        <p>Le solicitamos ingresar al sistema para confirmar sus disposicion para participar del curso.</p>
        <br/>
        <p>Mensaje enviado desde Sistema de Capacitación INNSA</p>

    </div>

</body>
</html>

