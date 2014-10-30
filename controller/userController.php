<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/userModel.php");
$view->u=new User();


switch($operacion){
    case 'insert':
        $view->u->setLogin($_POST['login']);
        $view->u->setPassword($_POST['password']);
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->setIdEmpleado($_POST['empleado']);
        $view->u->setHabilitado($_POST['estado']);
        $view->u->insertUsuario();
        break;

    case 'update':

        $contenido=$view->u->getUsuarioById($_POST['id']);
        print_r(json_encode($contenido));
        exit;

        break;

    case 'save':
        $view->u->setIdUsuario($_POST['id']);
        $view->u->setLogin($_POST['login']);
        $view->u->setPassword($_POST['password']);
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->setIdEmpleado($_POST['empleado']);
        $view->u->setHabilitado($_POST['estado']);
        $view->u->updateUsuario();
        break;

    case 'autocompletar_empleados':
        $rta=$view->u->getEmpleados($_POST['term']);
        print_r(json_encode($rta));
        exit;
        break;

    default:
        $view->usuarios=$view->u->getUsuarios();
        break;

}


$view->content="view/abmUser.php";


?>