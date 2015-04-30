<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_planModel.php");
require_once("model/cap_solicModel.php");
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
        //Si tipo_cambio trae valor=> envia el valor, sino 1 o ('null')
        $view->u->setTipoCambio(($_POST['tipo_cambio']!='')? $_POST['tipo_cambio'] : 1);
        $view->u->setFormaPago($_POST['forma_pago']);
        $view->u->setFormaFinanciacion($_POST['forma_financiacion']);
        $view->u->setProfesor1($_POST['profesor_1']);
        $view->u->setProfesor2($_POST['profesor_2']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);
        $rta=$view->u->insertCapPlan();

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Plan ingresado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al ingresar el plan');
            sQueryOracle::hacerRollback();
        }
        print_r(json_encode($respuesta));
        exit;
        break;

    case 'update':

        $plan=$view->u->getCapPlanById($_POST['id']);
        $empleados=$view->u->getEmpleadosByPlan($_POST['id']);
        //print_r(json_encode($plan));
        print_r(json_encode(array('plan'=>$plan, 'empleados'=>$empleados)));
        exit;
        break;

    case 'save':
        $rta=1;
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
        //Si tipo_cambio trae valor=> envia el valor, sino 1 o ('null')
        $view->u->setTipoCambio(($_POST['tipo_cambio']!='')? $_POST['tipo_cambio'] : 1);
        $view->u->setFormaPago($_POST['forma_pago']);
        $view->u->setFormaFinanciacion($_POST['forma_financiacion']);
        $view->u->setProfesor1($_POST['profesor_1']);
        $view->u->setProfesor2($_POST['profesor_2']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);

        if(!$view->u->updateCapPlan()) $rta=0;

        //Actualizo las asignaciones del plan
        $vector=json_decode($_POST["datos"]);
        foreach ($vector as $v){
            $u=new Asignacion_plan();
            $u->setIdAsignacion($v->id_asignacion);
            $u->setIdSolicitud($v->id_solicitud);
            $u->setIdPlan($v->id_plan);
            $u->setComentarios($v->comentarios);
            $u->setViaticos($v->viaticos);
            $u->setEstado($v->estado);

            if($v->operacion=="insert") {if(!$u->insertAsignacionPlan($v->id_solicitud)) $rta=0;} //le paso parametro id_solicitud
            else if($v->operacion=="update") {if(!$u->updateAsignacionPlan()) $rta=0;}
            else if($v->operacion=="delete") {if(!$u->deleteAsignacionPlan()) $rta=0;}
            }

        if($rta>0){
            sQueryOracle::hacerCommit();
            $respuesta=array ('response'=>'success','comment'=>'Plan modificado correctamente');
        }
        else{
            sQueryOracle::hacerRollback();
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar el plan');
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'autocompletar_cursos':
        $target= (isset($_POST['target']) && $_POST['target']=='BYPERIODO')? 'BYPERIODO': 'ALL';
        $rta=$view->u->getCursos($_POST['term'], $target);
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