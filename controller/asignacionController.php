<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
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

    case 'insertComunicacion':
        $view->c=new Comunicacion();
        $view->c->setIdAsignacion($_POST['id']);
        $view->c->setSituacion($_POST['situacion']);
        //$view->c->setObjetivos($_POST['objetivos']);
        $view->c->setObjetivo1($_POST['objetivo_1']);
        $view->c->setObjetivo2($_POST['objetivo_2']);
        $view->c->setObjetivo3($_POST['objetivo_3']);
        $view->c->setIndicadoresExito($_POST['indicadores_exito']);
        $view->c->setCompromiso($_POST['compromiso']);
        $view->c->setComunico($_POST['comunico']);

        //cambio la asignacion a COMUNICADA
        $view->u->setIdAsignacion($_POST['id']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setEstadoCambio($_POST['estado_cambio']);
        $view->u->updateEstadoAsignacionPlan();

        $rta=$view->c->insertComunicacion();
        print_r(json_encode($rta));
        exit;
        break;

    case 'updateComunicacion':
        $view->c=new Comunicacion();

        $rta=$view->c->getComunicacionByAsignacion($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'updateComunicacionNotificacion':
        $view->c=new Comunicacion();
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setNotificado($_POST['notificado']);

        //cambio esta asignacion a NOTIFICADO
        $view->u->setIdAsignacion($_POST['id']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setEstadoCambio($_POST['estado_cambio']);
        $view->u->updateEstadoAsignacionPlan();

        $rta=$view->c->updateComunicacionNotificacion();
        print_r(json_encode($rta));
        exit;
        break;


    case 'saveComunicacion':
        $view->c=new Comunicacion();

        //$view->c->setIdAsignacion($_POST['id']);
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setSituacion($_POST['situacion']);
        //$view->c->setObjetivos($_POST['objetivos']);
        $view->c->setObjetivo1($_POST['objetivo_1']);
        $view->c->setObjetivo2($_POST['objetivo_2']);
        $view->c->setObjetivo3($_POST['objetivo_3']);
        $view->c->setIndicadoresExito($_POST['indicadores_exito']);
        $view->c->setCompromiso($_POST['compromiso']);
        $view->c->setComunico($_POST['comunico']);

        $rta=$view->c->updateComunicacion();
        print_r(json_encode($rta));
        exit;
        break;


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