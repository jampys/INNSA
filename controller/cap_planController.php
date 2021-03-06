<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_planModel.php");
require_once("model/cap_solicModel.php");
require_once("model/administracionModel.php");
require_once("model/cursoModel.php");
require_once("model/reportesModel.php"); //para obtener los periodos del filtro
$view->u=new Cap_Plan();
$view->a=new EntidadCapacitadora();

$view->r=new Reportes();
$filtro_periodo=$view->r->getPeriodos();


switch($operacion){
    case 'insert':
        //nuevo
        $rta=1;
        if($_POST['id_curso']==""){ //si el id_curso viene vacio => hay que insertarlo
            $cu=new Curso();
            $cu->setNombre($_POST['nc_nombre']);
            //$cu->setIdTipoCurso($_POST['nc_tipo_curso']);
            $cu->setIdTema($_POST['nc_id_tema']);
            (!$id_curso=$cu->insertCursoAndGetId())? $rta=0 : $view->u->setIdCurso($id_curso);;
        }
        else{
            $view->u->setIdCurso($_POST['id_curso']);
        }
        //fin nuevo

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
        //$view->u->setImporte($_POST['importe']);
        $view->u->setImporte(($_POST['importe']!='')? $_POST['importe'] : 0);
        $view->u->setMoneda($_POST['moneda']);
        //Si tipo_cambio trae valor=> envia el valor, sino 1 o ('null')
        $view->u->setTipoCambio(($_POST['tipo_cambio']!='')? $_POST['tipo_cambio'] : 1);
        $view->u->setFormaPago($_POST['forma_pago']);
        $view->u->setFormaFinanciacion($_POST['forma_financiacion']);
        $view->u->setProfesor1($_POST['profesor_1']);
        $view->u->setProfesor2($_POST['profesor_2']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);

        $view->u->setCaracterActividad($_POST['caracter_actividad']);
        $view->u->setCantidadParticipantes($_POST['cantidad_participantes']);
        $view->u->setImporteTotal($_POST['importe_total']);
        $view->u->setIdTipoCurso($_POST['tipo_curso']);

        $view->u->setPrograma($_POST['programa']);
        $view->u->setPorcentajeReintegrable($_POST['porcentaje_reintegrable']);
        $view->u->setNroActividad($_POST['nro_actividad']);

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
        $view->u->setIdCurso($_POST['id_curso']);
        $view->u->setPeriodo($_POST['periodo']);
        $view->u->setObjetivo($_POST['objetivo']);
        $view->u->setModalidad($_POST['modalidad']);
        $view->u->setFechaDesde($_POST['fecha_desde']);
        $view->u->setFechaHasta($_POST['fecha_hasta']);
        $view->u->setDuracion($_POST['duracion']);
        $view->u->setUnidad($_POST['unidad']);
        $view->u->setPrioridad($_POST['prioridad']);
        $view->u->setEstado($_POST['estado']);
        //$view->u->setImporte($_POST['importe']);
        $view->u->setImporte(($_POST['importe']!='')? $_POST['importe'] : 0);
        $view->u->setMoneda($_POST['moneda']);
        //Si tipo_cambio trae valor=> envia el valor, sino 1 o ('null')
        $view->u->setTipoCambio(($_POST['tipo_cambio']!='')? $_POST['tipo_cambio'] : 1);
        $view->u->setFormaPago($_POST['forma_pago']);
        $view->u->setFormaFinanciacion($_POST['forma_financiacion']);
        $view->u->setProfesor1($_POST['profesor_1']);
        $view->u->setProfesor2($_POST['profesor_2']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);

        $view->u->setCaracterActividad($_POST['caracter_actividad']);
        $view->u->setCantidadParticipantes($_POST['cantidad_participantes']);
        $view->u->setImporteTotal($_POST['importe_total']);
        $view->u->setIdTipoCurso($_POST['tipo_curso']);

        $view->u->setPrograma($_POST['programa']);
        $view->u->setPorcentajeReintegrable($_POST['porcentaje_reintegrable']);
        $view->u->setNroActividad($_POST['nro_actividad']);

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
            //$u->setViaticos($v->viaticos);
            $u->setPrograma($v->prog);
            //$u->setEstado(1); //1: estado asignado

            if($v->operacion=="insert") {
                    $id_asignacion = $rta = $u->insertAsignacionPlan($v->id_solicitud); //le paso parametro id_solicitud y me devuelve el id_asignacion
                    $u->generarEstadoAsignacion($id_asignacion, $_SESSION["ses_id"], 1, 'asignado', $rta); //1: estado asignado
            }
            else if($v->operacion=="update") {if(!$u->updateAsignacionPlan()) $rta=0;}
            else if($v->operacion=="delete") {if(!$u->deleteAsignacionPlan()) $rta=0;} //se hace en la BD por CASCADE
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

    case 'autocompletar_cursos_temas':
        $target= (isset($_POST['target']) && $_POST['target']=='BYPERIODO')? 'BYPERIODO': 'ALL';
        //$rta=$view->u->getCursosTemas($_POST['term'], $target);
        $rta=$view->u->getCursosTemas($_POST['term'], $target, $_POST['id_solicitud'], $_POST['periodo']);
        print_r(json_encode($rta));
        //echo json_encode($rta);
        exit;
        break;

    case 'refreshGrid':
        $view->cp=$view->u->getCapPlan($_POST['periodo']);
        include_once('view/abmCap_planGrid.php');
        exit;
        break;

    default:
        $view->cp=$view->u->getCapPlan(date('Y'));
        $entidadesCapacitadoras=$view->a->getEntidadesCapacitadoras();
        //$cursosTemasSinAsignacion=$view->u->getCursosTemasSinAsignacion();
        //$view->cu=new Curso();
        $tipo_curso=$view->u->getTipoCurso();
        break;

}


$view->content="view/abmCap_plan.php";


?>