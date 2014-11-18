<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
$view->u=new Asignacion_plan();


switch($operacion){
    case 'insert':
        /*
        $view->u->setApellido($_POST['apellido']);
        $view->u->setNombre($_POST['nombre']);
        $view->u->setLugarTrabajo($_POST['lugar_trabajo']);
        $view->u->setNLegajo($_POST['n_legajo']);
        $view->u->setEmpresa($_POST['empresa']);
        $view->u->setFuncion($_POST['funcion']);
        $view->u->setCategoria($_POST['categoria']);
        $view->u->setDivision($_POST['division']);
        $view->u->setFechaIngreso($_POST['fecha_ingreso']);
        $view->u->setActivo($_POST['activo']);
        $view->u->setEmail($_POST['email']);
        $view->u->setCuil($_POST['cuil']);
        $rta=$view->u->insertEmpleado();
        print_r(json_encode($rta));
        exit;
        break; */

    case 'update':

        $rta=$view->u->getAsignacionPlanById($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'save':
        $view->u->setIdAsignacion($_POST['id']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setEstadoCambio($_POST['estado_cambio']);

        $rta=$view->u->updateEstadoAsignacionPlan();
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrid':
        $view->asignacion=$view->u->getAsignacionPlan();
        include_once('view/abmAsignacionGrid.php');
        exit;
        break;

    default:
        $view->asignacion=$view->u->getAsignacionPlan();
        break;

}


$view->content="view/abmAsignacion.php";


?>