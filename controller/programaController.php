<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/ProgramaModel.php");
//require_once("model/userModel.php");
$view->p=new Programa();


switch($operacion){
    case 'insert':
        //$view->p->setNroPrograma(isset($_POST['nro_programa'])? $_POST['nro_programa']: '');
        $view->p->setTipoPrograma($_POST['tipo_programa']);
        $view->p->setPeriodo($_POST['periodo']);
        $view->p->setNroPrograma($_POST['nro_programa']);
        $view->p->setEstado($_POST['estado']);
        $view->p->setFechaIngreso($_POST['fecha_ingreso']);
        $view->p->setFechaEvaluacion($_POST['fecha_evaluacion']);
        $view->p->setFechaPreaprobacion($_POST['fecha_preaprobacion']);
        $view->p->setFechaAprobacion($_POST['fecha_aprobacion']);
        $view->p->setEstado($_POST['estado']);
        $view->p->setContacto($_POST['contacto']);
        $view->p->setEmail($_POST['email']);

        $rta=$view->p->insertPrograma();
        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Programa agregado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al agregar el programa');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'update':

        $contenido=$view->p->getProgramaById($_POST['id']);
        print_r(json_encode($contenido));
        exit;
        break;

    case 'save':
        $view->p->setIdPrograma($_POST['id']);
        $view->p->setTipoPrograma($_POST['tipo_programa']);
        $view->p->setPeriodo($_POST['periodo']);
        $view->p->setNroPrograma($_POST['nro_programa']);
        $view->p->setEstado($_POST['estado']);
        $view->p->setFechaIngreso($_POST['fecha_ingreso']);
        $view->p->setFechaEvaluacion($_POST['fecha_evaluacion']);
        $view->p->setFechaPreaprobacion($_POST['fecha_preaprobacion']);
        $view->p->setFechaAprobacion($_POST['fecha_aprobacion']);
        $view->p->setEstado($_POST['estado']);
        $view->p->setContacto($_POST['contacto']);
        $view->p->setEmail($_POST['email']);
        $rta=$view->p->updatePrograma();

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Programa modificado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar el programa');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'autocompletar_empleados':
        //$target= (isset($_POST['target']) && $_POST['target']=='BYUSER')? 'BYUSER': 'ALL';
        if(isset($_POST['target'])){ $target=$_POST['target']; }
        $rta=$view->u->autocompletarEmpleados($_POST['term'], $_SESSION['USER_ID_EMPLEADO'], $target);
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrid':
        $view->programas=$view->p->getProgramas();
        include_once('view/abmProgramaGrid.php');
        exit;
        break;

    /*
    case 'getEmpleadoBySession':
        $view->e=new User();
        $rta=$view->e->getUsuarioById($_SESSION["ses_id"]);
        print_r(json_encode($rta));
        exit;
        break; */

    case 'AvailableLegajo':
        $rta=$view->u->availableLegajo($_POST['n_legajo'], $_POST['empresa'], $_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    default:
        $view->programas=$view->p->getProgramas();
        //$view->divisiones=$view->u->getDivisiones(); //para cargar dinamicamente el combo 'divsion' al agregar o editar empleado
        break;

}


$view->content="view/abmPrograma.php";


?>