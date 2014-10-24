<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cursoModel.php");
$view->u=new Curso();


switch($operacion){
    case 'insert':
        $view->u->setLogin($_POST['login']);
        $view->u->setPassword($_POST['password']);
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->insertUsuario();
        break;

    case 'update':

        $contenido=$view->u->getCursoById($_POST['id']);

        //$respuesta[0]=$contenido[0]['NOMBRE'];
        $respuesta[0]=$contenido[0]['NOMBRE_CURSO'];
        $respuesta[1]=$contenido[0]['DESCRIPCION_CURSO'];
        $respuesta[2]=$contenido[0]['COMENTARIOS_CURSO'];
        $respuesta[3]=$contenido[0]['ENTIDAD_CURSO'];
        $respuesta[4]=$contenido[0]['ID_CATEGORIA'];
        $respuesta[5]=$contenido[0]['ID_TEMA'];
        print_r(json_encode($respuesta));
        exit;
        break;

    case 'save':
        $view->u->setIdUsuario($_POST['id']);
        $view->u->setLogin($_POST['login']);
        $view->u->setPassword($_POST['password']);
        $view->u->setFechaAlta($_POST['fecha']);
        $view->u->setIdPerfil($_POST['perfil']);
        $view->u->updateUsuario();
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
        $view->cursos=$view->u->getCursos();
        break;

}


$view->content="view/abmCurso.php";


?>