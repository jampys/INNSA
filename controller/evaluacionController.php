<?php
//copia de asignacionController
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/evaluacionModel.php");
$view->u=new Evaluacion();


switch($operacion){

    case 'insertEvaluacion':
        $rta=1;
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
        if(!$view->u->insertEvaluacion()) $rta=0;

        //cambio la asignacion a EVALUADO
        $view->a=new Asignacion_plan();
        //$view->a->setIdAsignacion($_POST['id_asignacion']);
        //$view->a->setEstado($_POST['estado']);
        //$view->a->setEstadoCambio($_POST['estado_cambio']);
        //if(!$view->a->updateEstadoAsignacionPlan()) $rta=0;
        $view->a->generarEstadoAsignacion($_POST['id_asignacion'], $_SESSION["ses_id"], 5, 'evaluado', $rta); //5 evaluado

        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Evaluación ingresada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta = array ('response'=>'error','comment'=>'Error al ingresar la evaluación');
            sQueryOracle::hacerRollback();
        }


        print_r(json_encode($respuesta));
        exit;
        break;

    case 'updateEvaluacion':
        $evaluacion=$view->u->getEvaluacionByAsignacion($_POST['id_asignacion']);
        $objetivos=$view->u->getObjetivosEvaluacionByAsignacion($_POST['id_asignacion']);
        print_r(json_encode(array('evaluacion'=>$evaluacion, 'objetivos'=>$objetivos)));
        exit;
        break;


    case 'saveEvaluacion':

        $view->u->setIdEvaluacion($_POST['id_evaluacion']);
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

        //si existe objetivo ....., sino null
        $view->u->setObj1(isset($_POST['obj_1'])? $_POST['obj_1'] : 'null');
        $view->u->setObj2(isset($_POST['obj_2'])? $_POST['obj_2'] : 'null');
        $view->u->setObj3(isset($_POST['obj_3'])? $_POST['obj_3'] : 'null');

        $view->u->setComentarios($_POST['comentarios']);
        $rta=$view->u->updateEvaluacion();

        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Evaluación modificada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta = array ('response'=>'error','comment'=>'Error al modificar la evaluación');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

/*
    case 'refreshGrid':
        $view->asignacion=$view->u->getAsignacionPlan();
        include_once('view/abmAsignacionGrid.php');
        exit;
        break;


    default:
        $view->asignacion=$view->u->getAsignacionPlan();
        break;

*/

}


//$view->content="view/abmAsignacion.php";


?>