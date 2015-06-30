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

        $view->u->setEstado($_POST['estado']);
        $view->u->setAprSolicito($_POST['apr_solicito']);
        //Cuando insert solicitud devuelve el id, necesario para insert de planes asociados a la solicitud
        $rta=$id_solicitud=$view->u->insertCapSolic();

        //Insert asignacion plan
        $vector=json_decode($_POST["datos"]);
        foreach ($vector as $v){
            $u=new Asignacion_plan();
            $u->setIdPlan($v->id_plan);
            $u->setObjetivo($v->objetivo);
            $u->setComentarios($v->comentarios);
            $u->setViaticos($v->viaticos);
            $u->setReemplazo($v->reemplazo);
            $u->setEstado($v->estado);
            if(!$u->insertAsignacionPlan($id_solicitud)) $rta=0; //si algun insert falla, $rta se pone en 0.
        }

        //Insert cursos propuestos
        $vectorCursos=json_decode($_POST["datosCursos"]);
        foreach ($vectorCursos as $v){
            $c=new Propuesta();
            $c->setIdSolicitud($id_solicitud);
            $c->setIdCurso($v->id_curso);
            $c->setIdReemplazo($v->reemplazo);
            $c->setSituacion($v->situacion);
            $c->setObjetivo1($v->objetivo_1);
            $c->setObjetivo2($v->objetivo_2);
            $c->setObjetivo3($v->objetivo_3);
            $c->setIndicadoresExito($v->indicadores_exito);
            $c->setCompromiso($v->compromiso);
            $c->setIdTema($v->id_tema);
            if(!$c->insertPropuesta()) $rta=0; //si algun insert falla, $rta se pone en 0.
        }


        if($rta>0){
            sQueryOracle::hacerCommit();
            $respuesta=array ('response'=>'success','comment'=>'Solicitud ingresada correctamente');
        }
        else{
            sQueryOracle::hacerRollback();
            $respuesta=array ('response'=>'error','comment'=>'Error al ingresar solicitud');
        }

        //$rta=1; //estas 2 ultimas lineas estan para que devuelva algo en json y no arroje el error (igual sin ellas insert ok)
        print_r(json_encode($respuesta));
        exit;
        break;



    case 'update':

        $solicitud=$view->u->getCapSolicById($_POST['id']);
        $view->p=new Asignacion_plan();
        $planes=$view->p->getAsignacionPlanBySolicitud($_POST['id']);

        $view->pro=new Propuesta();
        $propuestas=$view->pro->getPropuestaBySolicitud($_POST['id']);

        print_r(json_encode(array('solicitud'=>$solicitud, 'planes'=>$planes, 'propuestas'=>$propuestas)));
        exit;
        break;

    case 'save':
        //Update solicitud de capacitacion
        $rta=1;
        $view->u->setIdSolicitud($_POST['id']);
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

        if(!$view->u->updateCapSolic()) $rta=0;

        //Update asignacion plan
        $vector=json_decode($_POST["datos"]);
        foreach ($vector as $v){
            $u=new Asignacion_plan();
            $u->setIdAsignacion($v->id_asignacion);
            $u->setIdPlan($v->id_plan);
            $u->setObjetivo($v->objetivo);
            $u->setComentarios($v->comentarios);
            $u->setViaticos($v->viaticos);
            $u->setReemplazo($v->reemplazo);
            $u->setEstado($v->estado);

            if($v->id_asignacion==""){ //si no tiene id_asignacion=> es un insert
                if(!$u->insertAsignacionPlan($_POST['id'])) $rta=0; //le paso parametro id_solicitud
            }
            else{
                if($v->operacion_asignacion=="update"){
                    if(!$u->updateAsignacionPlan()) $rta=0;
                }
                if($v->operacion_asignacion=="delete"){
                    if(!$u->deleteAsignacionPlan()) $rta=0;
                }
            }
        }


        //Update cursos propuestos
        $vectorCursos=json_decode($_POST["datosCursos"]);
        foreach ($vectorCursos as $v){
            $c=new Propuesta();
            $c->setIdPropuesta($v->id_propuesta);
            //$c->setIdSolicitud($v->id_solicitud);
            $c->setIdSolicitud($_POST['id']);
            $c->setIdCurso($v->id_curso);
            $c->setIdReemplazo($v->reemplazo);
            $c->setSituacion($v->situacion);
            $c->setObjetivo1($v->objetivo_1);
            $c->setObjetivo2($v->objetivo_2);
            $c->setObjetivo3($v->objetivo_3);
            $c->setIndicadoresExito($v->indicadores_exito);
            $c->setCompromiso($v->compromiso);
            $c->setIdTema($v->id_tema);


            if($v->id_propuesta==""){ //si no tiene id_propuesta=> es un insert
                if(!$c->insertPropuesta()) $rta=0;
            }
            else {
                if($v->operacion_curso=="update"){
                    if(!$c->updatePropuesta()) $rta=0;
                }
                if($v->operacion_curso=="delete"){
                    if(!$c->deletePropuesta()) $rta=0;
                }

            }
        }

        if($rta>0){
            sQueryOracle::hacerCommit();
            $respuesta=array ('response'=>'success','comment'=>'Solicitud modificada correctamente');
        }
        else{
            sQueryOracle::hacerRollback();
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar la solicitud');
        }

        //*****************************
        //$rta=1; //estas 2 ultimas lineas estan para que devuelva algo en json y no arroje el error (igual sin ellas insert ok)
        print_r(json_encode($respuesta));
        exit;
        break;

    /*
    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break; */


    case 'autocompletar_planes':
        $rta=$view->u->getPlanes($_POST['term'], $_POST['id_solicitud']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrid':
        $view->cs=$view->u->getCapSolic();
        include_once('view/abmCap_solicGrid.php');
        exit;
        break;

    default:
        $view->cs=$view->u->getCapSolic();
        break;

}


$view->content="view/abmCap_solic.php";


?>