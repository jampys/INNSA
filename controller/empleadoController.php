<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/empleadoModel.php");
require_once("model/userModel.php");
$view->u=new Empleado();


switch($operacion){
    case 'insert':
        $view->u->setApellido($_POST['apellido']);
        $view->u->setNombre($_POST['nombre']);
        $view->u->setLugarTrabajo($_POST['lugar_trabajo']);
        $view->u->setNLegajo($_POST['n_legajo']);
        $view->u->setEmpresa($_POST['empresa']);
        $view->u->setFuncion($_POST['funcion']);
        //$view->u->setCategoria($_POST['categoria']);
        $view->u->setDivision($_POST['division']);
        $view->u->setFechaIngreso($_POST['fecha_ingreso']);
        $view->u->setActivo($_POST['activo']);
        $view->u->setEmail($_POST['email']);
        $view->u->setCuil($_POST['cuil']);
        $rta=$view->u->insertEmpleado();
        //$respuesta= ($rta > 0)? array ('response'=>'success','comment'=>'Empleado agregado correctamente'):array ('response'=>'error','comment'=>'Error al agregar el empleado');
        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Colaborador agregado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al agregar el colaborador');
            sQueryOracle::hacerRollback();
        }

        print_r(json_encode($respuesta));
        exit;
        break;

    case 'update':

        $contenido=$view->u->getEmpleadoById($_POST['id']);
        print_r(json_encode($contenido));
        exit;
        break;

    case 'save':
        $view->u->setIdEmpleado($_POST['id']);
        $view->u->setApellido($_POST['apellido']);
        $view->u->setNombre($_POST['nombre']);
        $view->u->setLugarTrabajo($_POST['lugar_trabajo']);
        $view->u->setNLegajo($_POST['n_legajo']);
        $view->u->setEmpresa($_POST['empresa']);
        $view->u->setFuncion($_POST['funcion']);
        //$view->u->setCategoria($_POST['categoria']);
        $view->u->setDivision($_POST['division']);
        $view->u->setFechaIngreso($_POST['fecha_ingreso']);
        $view->u->setActivo($_POST['activo']);
        $view->u->setEmail($_POST['email']);
        $view->u->setCuil($_POST['cuil']);
        $rta=$view->u->updateEmpleado();
        //$respuesta= ($rta > 0)? array ('response'=>'success','comment'=>'Empleado actualizado correctamente'):array ('response'=>'error','comment'=>'Error al modificar el empleado ');
        if($rta > 0){
            $respuesta= array ('response'=>'success','comment'=>'Colaborador modificado correctamente');
            sQueryOracle::hacerCommit();
        }
        else{
            $respuesta=array ('response'=>'error','comment'=>'Error al modificar el colaborador');
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
        $view->empleados=$view->u->getEmpleados();
        include_once('view/abmEmpleadoGrid.php');
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
        $view->empleados=$view->u->getEmpleados();
        $view->divisiones=$view->u->getDivisiones(); //para cargar dinamicamente el combo 'divsion' al agregar o editar empleado
        break;

}


$view->content="view/abmEmpleado.php";


?>