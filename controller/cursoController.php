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
        //$view->u->setEntidad($_POST['entidad']);
        $view->u->setIdTema($_POST['tema']);
        //$view->u->setIdTipoCurso($_POST['tipo_curso']);
        $rta=$view->u->insertCurso();

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Curso agregado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al agregar curso');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
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
        //$view->u->setEntidad($_POST['entidad']);
        $view->u->setIdTema($_POST['tema']);
        //$view->u->setIdTipoCurso($_POST['tipo_curso']);
        $rta=$view->u->updateCurso();
        //$respuesta= ($rta > 0)? array ('response'=>'success','comment'=>'Curso modificado correctamente'):array ('response'=>'error','comment'=>'Error al modificar curso');
        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Curso modificado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar el curso');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'delete':
        $view->u->setIdCurso($_POST['id']);
        $rta=$view->u->deleteCurso();
        //$respuesta= ($rta > 0)? array ('response'=>'success','comment'=>'Curso eliminado correctamente'):array ('response'=>'error','comment'=>'Error al eliminar el curso');
        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Curso eliminado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al eliminar el curso');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'getTemas':
        $rta=$view->u->getTemas($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;


    case 'getCursosByTema':
        $rta=$view->u->getCursosByTema($_POST['id_tema']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'autocompletarCursosByTema':
        $id_tema= ($_POST['id_tema']!='')? "'".$_POST['id_tema']."'" : 'id_tema';
        $rta=$view->u->autocompletarCursosByTema($_POST['term'], $id_tema);
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
        //$tipo_curso=$view->u->getTipoCurso();
        break;

}


$view->content="view/abmCurso.php";


?>