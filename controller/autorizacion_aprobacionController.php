<!-- ESTA FUNCIONALIDAD NO SE USA -->


<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
$view->u=new Cap_Solic();


switch($operacion){

    /*
    case 'insert':
        $view->u->setAprSolicito($_POST['apr_solicito']);
        //Cuando insert solicitud devuelve el id, necesario para insert de planes asociados a la solicitud
        $id_solicitud=$view->u->insertCapSolic();


        $rta=1; //estas 2 ultimas lineas estan para que devuelva algo en json y no arroje el error (igual sin ellas insert ok)
        print_r(json_encode($rta));
        exit;
        break;
        */

    case 'update':

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
        break;

    case 'save':
        $rta=1;
        //Aprobar/autorizar solicitud de capacitacion
        $view->u->setIdSolicitud($_POST['id']);
        $view->u->setAprAutorizo($_POST['apr_autorizo']);
        $view->u->setAprAprobo(($_POST['apr_aprobo']=='')? 'null': $_POST['apr_aprobo']);
        $view->u->setEstado($_POST['estado']);

        if(!$view->u->autorizar_aprobarCapSolic()) $rta=0;
        //*********Agregado para copiar propuesta en comunicacion
        if($_POST['estado']=='APROBADA'){
            $view->c=new Comunicacion();
            if(!$view->c->copyPropuestaIntoComunicacion($_POST['id'])) $rta=0;
        }
        //--------fin
        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Solicitud '.(($_POST['estado']=='APROBADA')? "aprobada":"autorizada").' correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta = array ('response'=>'error','comment'=>'Error al '.(($_POST['estado']=='APROBADA')? "aprobar":"autorizar").' la solicitud');
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