<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
require_once("model/aprobacionModel.php");
$view->u=new Cap_Solic();


switch($operacion){


    case 'generarVersion':
        $rta=1;

        $t=new Aprobacion();
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'lugar_trabajo';
        if(!$t->copyPropuestaIntoComunicacionMasivamente($_POST['id_plan'], $lugar_trabajo)) $rta=0;
        if(!$t->aprobarPlanMasivamente(1, $_POST['id_plan'], $lugar_trabajo)) $rta=0;

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

    case 'aprobacionIndividual':
        $rta=1;

        $vector=json_decode($_POST["asignaciones_aprobar"]);
        foreach ($vector as $v){
            $t=new Aprobacion();
            if($v->operacion=="aprobar") {
                if(!$t->aprobarPlanIndividualmente($v->check, $v->id_asignacion, 'ASIGNADO')) $rta=0; // el check tiene un 1
                if(!$t->copyPropuestaIntoComunicacion($v->id_asignacion)) $rta=0;
            }
            else if($v->operacion=="desaprobar") {
                if(!$t->aprobarPlanIndividualmente($v->check, $v->id_asignacion, 'ASIGNADO')) $rta=0; // el check tiene un 0
                if(!$t->deletePropuestaFromComunicacion($v->id_asignacion)) $rta=0;
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
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'lugar_trabajo';
        if(!$t->copyPropuestaIntoComunicacionMasivamente($_POST['id_plan'], $lugar_trabajo)) $rta=0;
        if(!$t->aprobarPlanMasivamente(1, $_POST['id_plan'], $lugar_trabajo)) $rta=0;

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