<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
$view->u=new Cap_Solic();


switch($operacion){
    case 'insert':
        //Insert solicitud de capacitacion
        $view->u->setPeriodo($_POST['periodo']);
        $view->u->setIdEmpleado($_POST['empleado']);

        $view->u->setDpIngreso($_POST['dp_ingreso']);
        $view->u->setDpCrecimiento($_POST['dp_crecimiento']);
        $view->u->setDpPromocion($_POST['dp_promocion']);
        $view->u->setDpFuturaTransfer($_POST['dp_futura_transfer']);
        $view->u->setDpSustitucionTemp($_POST['dp_sustitucion_temp']);
        $view->u->setDiNuevasTecnicas($_POST['di_nuevas_tecnicas']);
        $view->u->setDiCrecimiento($_POST['di_crecimiento']);
        $view->u->setDiCompetenciasEmp($_POST['di_competencias_emp']);
        $view->u->setRpFaltaComp($_POST['rp_falta_comp']);
        $view->u->setRpNoConformidad($_POST['rp_no_conformidad']);
        $view->u->setRpReqExterno($_POST['rp_req_externo']);

        $view->u->setSituacionActual($_POST['situacion_actual']);
        $view->u->setSituacionDeseada($_POST['situacion_deseada']);
        $view->u->setObjetivoMedible1($_POST['objetivo_medible_1']);
        $view->u->setObjetivoMedible2($_POST['objetivo_medible_2']);
        $view->u->setObjetivoMedible3($_POST['objetivo_medible_3']);

        $view->u->setAprSolicito($_POST['apr_solicito']);
        //Cuando insert solicitud devuelve el id, necesario para insert de planes asociados a la solicitud
        $id_solicitud=$view->u->insertCapSolic();

        //Insert asignacion plan
        $vector=json_decode($_POST["datos"]);
        foreach ($vector as $v){
            $u=new Asignacion_plan();
            $u->setIdPlan($v->id_plan);
            $u->setObjetivo($v->objetivo);
            $u->setComentarios($v->comentarios);
            $u->setViaticos($v->viaticos);

            $u->insertAsignacionPlan($id_solicitud);
        }
        $rta=1; //estas 2 ultimas lineas estan para que devuelva algo en json y no arroje el error (igual sin ellas insert ok)
        print_r(json_encode($rta));
        exit;
        break;



    case 'update':

        $solicitud=$view->u->getCapSolicById($_POST['id']);
        $view->p=new Asignacion_plan();
        $planes=$view->p->getAsignacionPlanBySolicitud($_POST['id']);

        print_r(json_encode(array('solicitud'=>$solicitud, 'planes'=>$planes)));
        //print_r(json_encode($rta));
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

    default:
        $view->cs=$view->u->getCapSolic();
        break;

}


$view->content="view/abmCap_solic.php";


?>