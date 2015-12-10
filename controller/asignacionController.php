<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
require_once("model/reportesModel.php"); //para obtener los periodos del filtro
$view->u=new Asignacion_plan();

$view->r=new Reportes();
$filtro_periodo=$view->r->getPeriodos();


switch($operacion){

    case 'insertComunicacion': //guarda una comunicacion nueva.
        $view->c=new Comunicacion();
        $view->c->setIdAsignacion($_POST['id']);
        $view->c->setSituacion($_POST['situacion']);
        $view->c->setObjetivo1($_POST['objetivo_1']);
        $view->c->setObjetivo2($_POST['objetivo_2']);
        $view->c->setObjetivo3($_POST['objetivo_3']);
        $view->c->setIndicadoresExito($_POST['indicadores_exito']);
        $view->c->setCompromiso($_POST['compromiso']);
        //$view->c->setComunico($_POST['comunico']);
        $rta=$view->c->insertComunicacion();

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Comunicación agregada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al agregar la comunicación');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'updateComunicacion': //carga en la ventana modal los datos de la comunicacion a editar
        $view->c=new Comunicacion();
        $rta=$view->c->getComunicacionByAsignacion($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'saveComunicacion':  //guarda la comunicacion despues de ser editada
        $view->c=new Comunicacion();
        //$view->c->setIdAsignacion($_POST['id']);
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setSituacion($_POST['situacion']);
        $view->c->setObjetivo1($_POST['objetivo_1']);
        $view->c->setObjetivo2($_POST['objetivo_2']);
        $view->c->setObjetivo3($_POST['objetivo_3']);
        $view->c->setIndicadoresExito($_POST['indicadores_exito']);
        $view->c->setCompromiso($_POST['compromiso']);
        //$view->c->setComunico($_POST['comunico']);
        $rta=$view->c->updateComunicacion();

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Comunicación modificada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar la comunicación');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;


    case 'updateComunicacionNotificacion':
        $rta=1;
        $view->c=new Comunicacion();
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setNotificado($_POST['notificado']);
        //cambio esta asignacion a NOTIFICADO
        $view->u->setIdAsignacion($_POST['id']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setEstadoCambio($_POST['estado_cambio']);
        if(!$view->u->updateEstadoAsignacionPlan()) $rta=0;
        if(!$view->c->updateComunicacionNotificacion()) $rta=0;

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Notificación enviada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al enviar la notificación');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;



    case 'sendComunicacion': //Al presionar el boton "Enviar comunicacion".
        $rta=1;
        //Obtener datos para enviar el mail
        $view->c=new Comunicacion();
        $view->c->setIdAsignacion($_POST['id']);
        $com=$view->c->getDatosForSendComunicationMail();

        if(!$com){ $rta=0; } //Si la consulta SQL no devuelve ningun registro
        else{ //si la consulta SQL devuelve 1 registro

            //codigo para el envio de e-mail
            $para=$com[0]['EMAIL'];
            $asunto = 'INNSA - Plan de capacitación '.$com[0]['PERIODO'].' '.$com[0]['CURSO'];

            //codigo para incluir en la variable $mensaje el template de correo de la comunicacion, que se encuentra en email/comunicacion.php
            ob_start();
            include ('email/comunicacion.php');
            $mensaje= ob_get_contents();
            ob_get_clean();

            //Cabecera que especifica que es un HMTL
            $headers = 'From: INNSA Capacitacion <no-reply@innsa.com>' . "\r\n";
            $headers.= 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            if(@mail($para, utf8_decode($asunto), $mensaje, $headers)){ //Si envia email (por mas que la direccion sea incorrecta y lo rebote)

                //Poner en la comunicacion el id de quien comunico
                //$view->c->setIdComunicacion($_POST['id_comunicacion']);
                //$view->c->setComunico($_SESSION['USER_ID_EMPLEADO']);
                //$rtax=$view->c->updateComunicacionComunicacion();
                //if(!$view->c->updateComunicacionComunicacion()) $rta=0;

                //cambio la asignacion a COMUNICADA
                //$view->u->setIdAsignacion($_POST['id']);
                //$view->u->setEstado($_POST['estado']);
                //$view->u->setEstadoCambio($_POST['estado_cambio']);
                //$rta=$view->u->updateEstadoAsignacionPlan();
                //if(!$view->u->updateEstadoAsignacionPlan()) $rta=0;

                //Inserto la transicion del estado en tabla estado asignacion
                $lala = new Asignacion_plan();
                $lala->generarEstadoAsignacion($_POST['id'], $_SESSION["ses_id"], 3, 'comunicado', $rta); //3: estado comunicado


            }
            else{ $rta=-1;}


        }

        if($rta > 0){
            $respuesta = array ('response'=>'success','comment'=>'Comunicación enviada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            if($rta=0) $respuesta = array ('response'=>'error','comment'=>'Error al enviar la comunicación');
            if($rta=-1) $respuesta = array ('response'=>'error','comment'=>'Error al enviar la comunicación. Servidor de e-mail inactivo');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;


    case 'update': //carga en la ventana modal los datos del estado de una asignacion para editar
        $estado_actual=$view->u->getAsignacionPlanById($_POST['id']);
        //$estado_cambiar=$view->u->estadosCambio($_POST['id']);
        $estados_asignacion=$view->u->getEstadosByAsignacion($_POST['id']);
        $datos_version= $view->u->getVersionByAsignacion($_POST['id']);
        print_r(json_encode(array('estados_asignacion'=>$estados_asignacion, 'estado_actual'=>$estado_actual, 'datos_version'=>$datos_version)));
        exit;
        break;

    case 'save': //Guarda la edicion del estado de la asignacion
        $rta=1;

        //$view->u->setIdAsignacion($_POST['id']);
        //$view->u->setEstado($_POST['estado']);
        //$view->u->setEstadoCambio($_POST['estado_cambio']);

        //$rta=$view->u->updateEstadoAsignacionPlan();
        $view->c=new Asignacion_plan();
        $view->c->generarEstadoAsignacion($_POST['id'], $_SESSION["ses_id"], $_POST['estado'], $_POST['estado_cambio'], $rta);


        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Estado modificado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar el estado');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'refreshGrid':
        $periodo= (!$_POST['periodo'])? date('Y') : $_POST['periodo'];
        $view->asignacion=$view->u->getAsignacionPlan($periodo);
        include_once('view/abmAsignacionGrid.php');
        exit;
        break;


    default:
        $view->asignacion=$view->u->getAsignacionPlan(date('Y'));
        break;

}


$view->content="view/abmAsignacion.php";


?>