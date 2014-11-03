<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
$view->u=new Cap_Solic();


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

        $view->u->insertCapPlan();
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

        $view->u->updateCapPlan();
        break;

    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'autocompletar_planes':
        $rta=$view->u->getPlanes($_POST['term']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'insert_planes':
        $vector=json_decode($_POST["datos"]);
        foreach ($vector as $v){
            $u=new Cap_Solic();
            $u->setIdPlan($v->id_plan);
            $u->setObjetivo($v->objetivo);
            $u->setComentarios($v->comentarios);
            $u->setViaticos($v->viaticos);

            $u->insertPlanes();
        }
        $rta=1; //estas 2 ultimas lineas estan para que devuelva algo en json y no arroje el error (igual sin ellas insert ok)
        print_r(json_encode($rta));
        exit;
        break;

    default:
        $view->cp=$view->u->getCapPlan();
        break;

}


$view->content="view/abmCap_solic.php";


?>