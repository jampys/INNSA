<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
require_once("model/aprobacionModel.php");
$view->u=new Cap_Solic();


switch($operacion){


    case 'update':

        require_once("model/ReportesModel.php");
        $a=new Reportes();
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';
        $respuesta=$a->getEmpleadosByPlan($lugar_trabajo, $_POST['id']); //lugar de trabajo, id_plan
        print_r(json_encode($respuesta));
        exit;
        break;

    /*case 'update':

        $solicitud=$view->u->getCapSolicById($_POST['id']);
        $view->p=new Asignacion_plan();
        $planes=$view->p->getAsignacionPlanBySolicitud($_POST['id']);

        //$solicito=$view->u->getCapSolicSolicito($_POST['id']);
        //$autorizo=$view->u->getCapSolicAutorizo($_POST['id']);
        //$aprobo=$view->u->getCapSolicAprobo($_POST['id']);
        $totales=$view->u->getCapSolicTotalesById($_POST['id']);

        //print_r(json_encode(array('solicitud'=>$solicitud, 'planes'=>$planes, 'solicito'=>$solicito, 'autorizo'=>$autorizo, 'aprobo'=>$aprobo)));
        print_r(json_encode(array('solicitud'=>$solicitud, 'planes'=>$planes, 'totales'=>$totales)));
        exit;
        break;*/

    case 'aprobacionIndividual':
        $rta=1;

        $vector=json_decode($_POST["asignaciones_aprobar"]);
        foreach ($vector as $v){
            $t=new Aprobacion();
            if($v->operacion=="aprobar") {
                if(!$t->aprobarPlanIndividualmente($v->check, $v->id_asignacion)) $rta=0;
                if(!$t->copyPropuestaIntoComunicacion($v->id_asignacion)) $rta=0;
            }

        }

        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Plan aprobado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta = array ('response'=>'error','comment'=>'Error al aprobar el plan');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;


    case 'aprobacionMasiva':
        $rta=1;

        $t=new Aprobacion();
        if(!$t->copyPropuestaIntoComunicacionMasivamente($_POST['id_plan'])) $rta=0;
        if(!$t->aprobarPlanMasivamente(1, $_POST['id_plan'])) $rta=0;

        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Plan aprobado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta = array ('response'=>'error','comment'=>'Error al aprobar el plan');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'refreshGrid':
        $view->cs=$view->u->getCapSolic();
        include_once('view/abmAutorizacion_aprobacionGrid.php');
        exit;
        break;

    default:
        $view->cs=$view->u->getCapSolic();
        break;

}


$view->content="view/abmAutorizacion_aprobacion.php";


?>