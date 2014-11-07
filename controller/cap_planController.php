<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_planModel.php");
$view->u=new Cap_Plan();


switch($operacion){
    case 'insert':
        $view->u->setIdCurso($_POST['curso']);
        $view->u->setPeriodo($_POST['periodo']);
        $view->u->setObjetivo($_POST['objetivo']);
        $view->u->setModalidad($_POST['modalidad']);
        $view->u->setFechaDesde($_POST['fecha_desde']);
        $view->u->setFechaHasta($_POST['fecha_hasta']);
        $view->u->setDuracion($_POST['duracion']);
        $view->u->setUnidad($_POST['unidad']);
        $view->u->setPrioridad($_POST['prioridad']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setImporte($_POST['importe']);
        $view->u->setMoneda($_POST['moneda']);
        $view->u->setTipoCambio($_POST['tipo_cambio']);
        $view->u->setFormaPago($_POST['forma_pago']);
        $view->u->setFormaFinanciacion($_POST['forma_financiacion']);
        $view->u->setProfesor1($_POST['profesor_1']);
        $view->u->setProfesor2($_POST['profesor_2']);
        $view->u->setComentarios($_POST['comentarios']);

        $rta=$view->u->insertCapPlan();
        print_r(json_encode($rta));
        exit;
        break;

    case 'update':

        $contenido=$view->u->getCapPlanById($_POST['id']);
        print_r(json_encode($contenido));
        exit;
        break;

    case 'save':
        $view->u->setIdPlan($_POST['id']);
        //$view->u->setIdCurso($_POST['curso']);
        $view->u->setPeriodo($_POST['periodo']);
        $view->u->setObjetivo($_POST['objetivo']);
        $view->u->setModalidad($_POST['modalidad']);
        $view->u->setFechaDesde($_POST['fecha_desde']);
        $view->u->setFechaHasta($_POST['fecha_hasta']);
        $view->u->setDuracion($_POST['duracion']);
        $view->u->setUnidad($_POST['unidad']);
        $view->u->setPrioridad($_POST['prioridad']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setImporte($_POST['importe']);
        $view->u->setMoneda($_POST['moneda']);
        $view->u->setTipoCambio($_POST['tipo_cambio']);
        $view->u->setFormaPago($_POST['forma_pago']);
        $view->u->setFormaFinanciacion($_POST['forma_financiacion']);
        $view->u->setProfesor1($_POST['profesor_1']);
        $view->u->setProfesor2($_POST['profesor_2']);
        $view->u->setComentarios($_POST['comentarios']);

        $rta=$view->u->updateCapPlan();
        print_r(json_encode($rta));
        exit;
        break;

    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'autocompletar_cursos':
        $rta=$view->u->getCursos($_POST['term']);
        print_r(json_encode($rta));
        //echo json_encode($rta);
        exit;
        break;

    case 'refreshGrid':
        $view->cp=$view->u->getCapPlan();
        include_once('view/abmCap_planGrid.php');
        exit;
        break;

    default:
        $view->cp=$view->u->getCapPlan();
        break;

}


$view->content="view/abmCap_plan.php";


?>