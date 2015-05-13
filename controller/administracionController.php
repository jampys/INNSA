<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/administracionModel.php");
$view->c=new Categoria();
$view->ec=new EntidadCapacitadora();

switch($operacion){

    //******************************************CATEGORIAS Y TEMAS ************************************************

    case 'categoriaInsert':
        $rta=1;
        //$view->c->setIdCategoria($_POST['id']);
        $view->c->setNombre($_POST['categoria_nombre']);
        $view->c->setDescripcion($_POST['categoria_descripcion']);
        $view->c->setEstado($_POST['categoria_estado']);
        //Cuando insert categoria devuelve el id, necesario para insert de temas asociados a la categoria
        $rta=$id_categoria=$view->c->insertCategoria();

        $vector=json_decode($_POST["temas"]);
        foreach ($vector as $v){
            $t=new Tema();
            $t->setIdCategoria($id_categoria);
            $t->setNombre($v->nombre);
            $t->setEstado($v->check);
            if($v->operacion=="insert") {if(!$t->insertTema()) $rta=0;}
        }

        if($rta>0){
            sQueryOracle::hacerCommit();
            $respuesta=array ('response'=>'success','comment'=>'Categoría ingresada correctamente');
        }
        else{
            sQueryOracle::hacerRollback();
            $respuesta=array ('response'=>'error','comment'=>'Error al ingresar la categoría');
        }

        print_r(json_encode($respuesta));
        exit;
        break;



    case 'categoriaUpdate':

        $categoria=$view->c->getCategoriaById($_POST['id']);
        $temas=$view->c->getTemasByCategoria($_POST['id']);
        $respuesta=array('categoria'=>$categoria,'temas'=>$temas);
        print_r(json_encode($respuesta));
        exit;
        break;

    case 'categoriaSave':
        $rta=1;
        $view->c->setIdCategoria($_POST['id']);
        $view->c->setNombre($_POST['categoria_nombre']);
        $view->c->setDescripcion($_POST['categoria_descripcion']);
        $view->c->setEstado($_POST['categoria_estado']);
        if(!$rta=$view->c->updateCategoria()) $rta=0;

        //Actualizo los temas de la categoria
        $vector=json_decode($_POST["temas"]);
        foreach ($vector as $v){
            $t=new Tema();
            $t->setIdTema($v->id_tema);
            $t->setIdCategoria($v->id_categoria);
            $t->setNombre($v->nombre);
            $t->setEstado($v->check);

            if($v->operacion=="update") {if(!$t->updateTema($v->id_tema)) $rta=0;}
            else if($v->operacion=="insert") {if(!$t->insertTema()) $rta=0;}

        }

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Categoría modificada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar la categoría');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;


    case 'refreshGridCategorias':
        $view->categorias=$view->c->getCategorias();
        include_once('view/abmAdministracionGrid.php');
        exit;
        break;

    //*********************************************** ENTIDADES ***************************************************************

    case 'entidadUpdate':
        $respuesta=$view->ec->getEntidadById($_POST['id']);
        print_r(json_encode($respuesta));
        exit;
        break;

    case 'entidadInsert':
        $view->ec->setNombre($_POST['entidad_nombre']);
        $view->ec->setEstado($_POST['entidad_estado']);
        $rta=$view->ec->insertEntidad();

        if($rta>0){
            sQueryOracle::hacerCommit();
            $respuesta=array ('response'=>'success','comment'=>'Entidad ingresada correctamente');
        }
        else{
            sQueryOracle::hacerRollback();
            $respuesta=array ('response'=>'error','comment'=>'Error al ingresar la entidad');
        }

        print_r(json_encode($respuesta));
        exit;
        break;


    case 'entidadSave':
        $view->ec->setIdEntidadCapacitadora($_POST['id']);
        $view->ec->setNombre($_POST['entidad_nombre']);
        $view->ec->setEstado($_POST['entidad_estado']);
        $rta=$view->ec->updateEntidad();

        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Entidad modificada correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar la entidad');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;


    case 'entidades': //muestra la grilla de entidades
        $view->entidadesCapacitadoras=$view->ec->getEntidadesCapacitadoras();
        $view->content="view/abmAdminEntidades_capacitadoras.php";
        break;

    case 'refreshGridEntidades': //para refrescar la grilla de entidades
        $view->entidadesCapacitadoras=$view->ec->getEntidadesCapacitadoras();
        include_once('view/abmAdminEntidades_capacitadorasGrid.php');
        exit;
        break;

    //**************************************** DIVISIONES Y FUNCIONES ***************************************************************

    case 'getFunciones':
        $view->fun=new Funcion();
        $rta=$view->fun->getFunciones($_POST['id']);
        print_r(json_encode($rta));
        exit;
        break;

    default: //muestra la grilla de categorias y temas por defecto
        $view->categorias=$view->c->getCategorias();
        $view->content="view/abmAdministracion.php";
        break;


}


//$view->content="view/abmAdministracion.php";


?>