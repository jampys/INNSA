<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
require_once("model/reportesModel.php"); //para obtener los periodos del filtro
$view->u=new Asignacion_plan();

$view->r=new Reportes();
$filtro_periodo=$view->r->getPeriodos();


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

    case 'insertComunicacion': //creo que no lo uso
        $view->c=new Comunicacion();

        $view->c->setIdAsignacion($_POST['id']);
        $view->c->setSituacion($_POST['situacion']);
        $view->c->setObjetivos($_POST['objetivos']);
        $view->c->setIndicadoresExito($_POST['indicadores_exito']);
        $view->c->setCompromiso($_POST['compromiso']);
        $view->c->setComunico($_POST['comunico']);

        $rta=$view->c->insertComunicacion();
        print_r(json_encode($rta));
        exit;
        break;

    case 'updateComunicacion': //creo que no lo uso
        $view->c=new Comunicacion();

        $rta=$view->c->getComunicacionByAsignacion($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'saveComunicacion': //creo que no lo uso
        $view->c=new Comunicacion();

        //$view->c->setIdAsignacion($_POST['id']);
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setSituacion($_POST['situacion']);
        $view->c->setObjetivos($_POST['objetivos']);
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
        $view->asignacion=$view->u->getAsignacionPlanByUser($_SESSION["ses_id"], $_POST['periodo']);
        include_once('view/abmVistaEmpleadoGrid.php');
        exit;
        break;


    default:
        $view->asignacion=$view->u->getAsignacionPlanByUser($_SESSION["ses_id"], date('Y'));
        break;

}


$view->content="view/abmVistaEmpleado.php";


?>