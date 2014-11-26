<?php
//copia de asignacionController
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/evaluacionModel.php");
$view->u=new Evaluacion();


switch($operacion){

    case 'insertEvaluacion':

        $view->u->setIdAsignacion($_POST['id_asignacion']);
        $view->u->setConceptosImportantes($_POST['conceptos_importantes']);
        $view->u->setAspectosFaltaron($_POST['aspectos_faltaron']);
        $view->u->setMejorarDesempenio($_POST['mejorar_desempenio']);
        $view->u->setEvIDominio($_POST['ev_i_dominio']);
        $view->u->setEvILenguaje($_POST['ev_i_lenguaje']);
        $view->u->setEvIClaridad($_POST['ev_i_claridad']);
        $view->u->setEvIMaterial($_POST['ev_i_material']);
        $view->u->setEvIConsultas($_POST['ev_i_consultas']);
        $view->u->setEvIDidactico($_POST['ev_i_didactico']);
        $view->u->setEvIParticipacion($_POST['ev_i_participacion']);

        $view->u->setEvLDuracion($_POST['ev_l_duracion']);
        $view->u->setEvLComunicacion($_POST['ev_l_comunicacion']);
        $view->u->setEvLMaterial($_POST['ev_l_material']);
        $view->u->setEvLBreak($_POST['ev_l_break']);
        $view->u->setEvLHotel($_POST['ev_l_hotel']);

        $view->u->setObj1($_POST['obj_1']);
        $view->u->setObj2($_POST['obj_2']);
        $view->u->setObj3($_POST['obj_3']);

        $view->u->setComentarios($_POST['comentarios']);

        $rta=$view->u->insertEvaluacion();
        print_r(json_encode($rta));
        exit;
        break;

    case 'updateEvaluacion':
        //$view->e=new Evaluacion();

        $rta=$view->u->getObjetivosEvaluacionByAsignacion($_POST['id_asignacion']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'updateComunicacionNotificacion':
        $view->c=new Comunicacion();

        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setNotificado($_POST['notificado']);

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