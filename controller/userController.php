<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/userModel.php");
require_once("model/empleadoModel.php");
$view->u=new User();


switch($operacion){
    case 'insert':
        $view->u->setLogin($_POST['login']);
        $pass = substr( md5(microtime()), 1, 8); //genero un password aleatorio de 8 caracteres
        $view->u->setPassword($pass);
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->setIdEmpleado($_POST['empleado']);
        $view->u->setHabilitado($_POST['estado']);
        $view->u->setClearPass(1);
        $rta=$view->u->insertUsuario();

        //***********************EMAIL**********************************

        //Obtener datos para enviar el mail
        $view->e=new Empleado();
        $emp=$view->e->getEmpleadoById($_POST['empleado']); //id_empleado

        if(!$emp){ //Si la consulta SQL no devuelve ningun registro
            //$respuesta = array ('response'=>'error','comment'=>'Problemas con la consulta SQL');
        }
        else{ //si la consulta SQL devuelve 1 registro

            //codigo para el envio de e-mail
            $para=$emp[0]['EMAIL'];
            $asunto = 'Usuario y password Sistema de Capacitación INNSA';

            //codigo para incluir en la variable $mensaje el template de correo de la comunicacion, que se encuentra en email/comunicacion.php
            ob_start();
            include ('email/password.php');
            $mensaje= ob_get_contents();
            ob_get_clean();

            //Cabecera que especifica que es un HMTL
            $headers = 'From: INNSA Capacitacion <no-reply@innsa.com>' . "\r\n";
            $headers.= 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            if(mail($para, utf8_decode($asunto), $mensaje, $headers)){ //Si envia email (por mas que la direccion sea incorrecta y lo rebote)

                //$respuesta = array ('response'=>'success','comment'=>'Comunicación enviada correctamente');

            }
            else{ //No pudo enviar el e-mail
                //$respuesta = array ('response'=>'error','comment'=>'Error al enviar la comunicación');
            }

        }

        //------------------FIN EMAIL----------------------------------------

        print_r(json_encode($rta));
        exit;
        break;

    case 'update':

        $rta=$view->u->getUsuarioById($_POST['id']);
        print_r(json_encode($rta));
        exit;

        break;

    case 'save':
        $view->u->setIdUsuario($_POST['id']);
        $view->u->setLogin($_POST['login']);
        //$view->u->setPassword($_POST['password']);
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->setIdEmpleado($_POST['empleado']);
        $view->u->setHabilitado($_POST['estado']);
        $rta=$view->u->updateUsuario();
        print_r(json_encode($rta));
        exit;
        break;

    case 'autocompletar_empleados_sin_user':
        $user=(isset($_POST['user']))? $_POST['user'] : 0;
        $rta=$view->u->autocompletarEmpleadosSinUser($_POST['term'],$user);
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrid':
        $view->usuarios=$view->u->getUsuarios();
        include_once('view/abmUserGrid.php');
        exit;
        break;

    /*case 'AvailableUser':
        $rta=$view->u->availableUser($_POST['login']);
        print_r(json_encode($rta));
        exit;
        break;*/

    default:
        $view->usuarios=$view->u->getUsuarios();
        break;

}


$view->content="view/abmUser.php";


?>