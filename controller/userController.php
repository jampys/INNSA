<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/userModel.php");
$view->u=new User();


switch($operacion){
    case 'insert':
        $view->u->setLogin($_POST['login']);
        //$view->u->setPassword($_POST['password']);
        $view->u->setPassword('1234'); //al insertar un nuevo usuario se asigna por defecto el password 1234, el usuario debe cambiarlo
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->setIdEmpleado($_POST['empleado']);
        $view->u->setHabilitado($_POST['estado']);
        $rta=$view->u->insertUsuario();
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

    case 'AvailableUser':
        $rta=$view->u->availableUser($_POST['login']);
        print_r(json_encode($rta));
        exit;
        break;

    default:
        $view->usuarios=$view->u->getUsuarios();
        break;

}


$view->content="view/abmUser.php";


?>