<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/comunicacionModel.php");
$view->u=new Asignacion_plan();


switch($operacion){

    case 'insertComunicacion': //guarda una comunicacion nueva
        $view->c=new Comunicacion();
        $view->c->setIdAsignacion($_POST['id']);
        $view->c->setSituacion($_POST['situacion']);
        $view->c->setObjetivo1($_POST['objetivo_1']);
        $view->c->setObjetivo2($_POST['objetivo_2']);
        $view->c->setObjetivo3($_POST['objetivo_3']);
        $view->c->setIndicadoresExito($_POST['indicadores_exito']);
        $view->c->setCompromiso($_POST['compromiso']);
        $view->c->setComunico($_POST['comunico']);

        $rta=$view->c->insertComunicacion();
        print_r(json_encode($rta));
        exit;
        break;

    case 'updateComunicacion': //carga en la ventana modal los datos de la comunicacion a editar
        $view->c=new Comunicacion();
        $rta=$view->c->getComunicacionByAsignacion($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'updateComunicacionNotificacion':
        $view->c=new Comunicacion();
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setNotificado($_POST['notificado']);

        //cambio esta asignacion a NOTIFICADO
        $view->u->setIdAsignacion($_POST['id']);
        $view->u->setEstado($_POST['estado']);
        $view->u->setEstadoCambio($_POST['estado_cambio']);
        $view->u->updateEstadoAsignacionPlan();

        $rta=$view->c->updateComunicacionNotificacion();
        print_r(json_encode($rta));
        exit;
        break;


    case 'saveComunicacion':
        $view->c=new Comunicacion();

        //$view->c->setIdAsignacion($_POST['id']);
        $view->c->setIdComunicacion($_POST['id_comunicacion']);
        $view->c->setSituacion($_POST['situacion']);
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


    case 'sendComunicacion':

        //Obtener datos para enviar el mail
        $view->c=new Comunicacion();
        $view->c->setIdAsignacion($_POST['id']);
        $com=$view->c->getDatosForSendComunicationMail();

        if(!$com){ //Si la consulta SQL no devuelve ningun registro
            $respuesta = array ('response'=>'error','comment'=>'Problemas con la consulta SQL');
        }
        else{ //si la consulta SQL devuelve 1 registro

            //codigo para el envio de e-mail
            $para=$com[0]['LOGIN'];
            $asunto = 'Plan de capacitación '.$com[0]['PERIODO'].' '.$com[0]['CURSO'];
            $mensaje="
                <html>
                    <head></head>
                    <body>
                        <img src='public/img/logo.gif' alt='INNSA Comunicaciones'>
                        <p style='font-weight: bold'>".$com[0]['APELLIDO']." ".$com[0]['NOMBRE'].":</p>
                        <p>Por la presente le informamos que esta inscripto en el curso".$com[0]['CURSO']." a realizarse desde el
                        ".$com[0]['FECHA_DESDE']." hasta el ".$com[0]['FECHA_HASTA'].".</p>
                        <p>Le solicitamos ingresar al sistema para confirmar sus disposicion para participar del curso.</p>
                        <br/>
                        <p>Mensaje enviado desde Sistema de Capacitación INNSA</p>
                    </body>
                </html>
            ";

            //Cabecera que especifica que es un HMTL
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            if(mail($para, utf8_decode($asunto), $mensaje, $headers)){ //Si envia email (por mas que la direccion sea incorrecta y lo rebote)

                //Poner en la comunicacion el id de quien comunico
                $view->c->setIdComunicacion($_POST['id_comunicacion']);
                $view->c->setComunico($_SESSION['USER_ID_EMPLEADO']);
                $rtax=$view->c->updateComunicacionComunicacion();

                //cambio la asignacion a COMUNICADA
                $view->u->setIdAsignacion($_POST['id']);
                $view->u->setEstado($_POST['estado']);
                $view->u->setEstadoCambio($_POST['estado_cambio']);
                $rta=$view->u->updateEstadoAsignacionPlan();
                $respuesta = array ('response'=>'success','comment'=>'Comunicación enviada correctamente');

            }
            else{ //No pudo enviar el e-mail
                $respuesta = array ('response'=>'error','comment'=>'Error al enviar la comunicación');
            }


        }

        print_r(json_encode($respuesta));

        exit;
        break;


    case 'update': //carga en la ventana modal los datos del estado de una asignacion para editar
    $estado_actual=$view->u->getAsignacionPlanById($_POST['id']);
        $estado_cambiar=$view->u->estadosCambio($_POST['id']);

        print_r(json_encode(array('estado_actual'=>$estado_actual, 'estado_cambiar'=>$estado_cambiar)));
    //print_r(json_encode($estado));
    exit;
    break;

    case 'save': //Guarda la edicion del estado de la asignacion
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