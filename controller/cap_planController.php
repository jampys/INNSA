<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_planModel.php");
$view->u=new Cap_Plan();


switch($operacion){
    case 'insert':
        $view->u->setNombre($_POST['nombre']);
        $view->u->setDescripcion($_POST['descripcion']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);
        $view->u->setIdTema($_POST['tema']);
        $view->u->insertCurso();
        break;

    case 'update':

        $contenido=$view->u->getCapPlanById($_POST['id']);
        print_r(json_encode($contenido));
        exit;
        break;

    case 'save':
        $view->u->setIdCurso($_POST['id']);
        $view->u->setNombre($_POST['nombre']);
        $view->u->setDescripcion($_POST['descripcion']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);
        $view->u->setIdTema($_POST['tema']);
        $view->u->updateCurso();
        break;

    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrilla': //Por ehora no lo voy a usar
        $rta=$view->u->getCursos();
        print_r(json_encode($rta));
        exit;
        break;

    default:
        $view->cp=$view->u->getCapPlan();
        break;

}


$view->content="view/abmCap_plan.php";


?>