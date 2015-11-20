<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/versionModel.php");
$view->u=new Version();


switch($operacion){


    case 'generarVersion':
        $rta=1;

        $view->u->setSubTotalSinViaticos($_POST['sub_total_sin_viaticos']);
        $view->u->setTotalConViaticos($_POST['total_con_viaticos']);
        $view->u->setTotalReintegrable($_POST['total_reintegrable']);
        $view->u->setTotalAprobado($_POST['total_aprobado']);
        $view->u->setMoneda($_POST['moneda']);
        $view->u->setPeriodo($_POST['periodo']);
        $view->u->setIdUsuario($_SESSION["ses_id"]);
        //la fecha_version se hace desde el motor de BD

        $rta=$view->u->insertVersion($rta);


        //$rta=$id_plan_version = $view->u->insertPlanCapacitacionVersion($id_plan_maestro_version);

        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Versión creada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta = array ('response'=>'error','comment'=>'Error al crear la versión');
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