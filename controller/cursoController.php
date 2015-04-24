<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cursoModel.php");
$view->u=new Curso();


switch($operacion){
    case 'insert':
        $view->u->setNombre($_POST['nombre']);
        $view->u->setDescripcion($_POST['descripcion']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);
        $view->u->setIdTema($_POST['tema']);
        $view->u->setIdTipoCurso($_POST['tipo_curso']);
        $rta=$view->u->insertCurso();
        print_r(json_encode($rta));
        exit;
        break;

    case 'update':
        $rta=$contenido=$view->u->getCursoById($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'save':
        $view->u->setIdCurso($_POST['id']);
        $view->u->setNombre($_POST['nombre']);
        $view->u->setDescripcion($_POST['descripcion']);
        $view->u->setComentarios($_POST['comentarios']);
        $view->u->setEntidad($_POST['entidad']);
        $view->u->setIdTema($_POST['tema']);
        $view->u->setIdTipoCurso($_POST['tipo_curso']);
        $rta=$view->u->updateCurso();
        print_r(json_encode($rta));
        exit;
        break;

    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrid':
        $view->cursos=$view->u->getCursos();
        include_once('view/abmCursoGrid.php');
        exit;
        break;

    default:
        $view->cursos=$view->u->getCursos();
        $categorias=$view->u->getCategorias();
        $tipo_curso=$view->u->getTipoCurso();
        break;

}


$view->content="view/abmCurso.php";


?>