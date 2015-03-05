<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

//require_once("model/cap_solicModel.php");
require_once("model/reportesModel.php");
//$view->u=new Cap_Solic();
$view->u=new Reportes();

//traigo los periordos de la BD
$periodos=$view->u->getPeriodos();

switch($operacion){

    /*
    case 'insert':
        $view->u->setApellido($_POST['apellido']);
        $view->u->setNombre($_POST['nombre']);
        $view->u->setLugarTrabajo($_POST['lugar_trabajo']);
        $view->u->setNLegajo($_POST['n_legajo']);
        $view->u->setEmpresa($_POST['empresa']);
        $view->u->setFuncion($_POST['funcion']);
        $view->u->setCategoria($_POST['categoria']);
        $view->u->setDivision($_POST['division']);
        $view->u->setFechaIngreso($_POST['fecha_ingreso']);
        $view->u->setActivo($_POST['activo']);
        $view->u->setEmail($_POST['email']);
        $view->u->setCuil($_POST['cuil']);
        $rta=$view->u->insertEmpleado();
        print_r(json_encode($rta));
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
        $view->u->setCategoria($_POST['categoria']);
        $view->u->setDivision($_POST['division']);
        $view->u->setFechaIngreso($_POST['fecha_ingreso']);
        $view->u->setActivo($_POST['activo']);
        $view->u->setEmail($_POST['email']);
        $view->u->setCuil($_POST['cuil']);
        $rta=$view->u->updateEmpleado();
        print_r(json_encode($rta));
        exit;
        break;

    case 'autocompletar_empleados':
        $rta=$view->u->autocompletarEmpleados($_POST['term']);
        print_r(json_encode($rta));
        exit;
        break;

    case 'refreshGrid':
        $view->empleados=$view->u->getEmpleados();
        include_once('view/abmEmpleadoGrid.php');
        exit;
        break;

    */

    case 'filtrosReportes':
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'periodo';
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';

        $view->solicitud=$view->u->getCapSolicByFiltro($periodo, $lugar_trabajo);
        include_once('view/reportesGrid.php');
        exit;
        break;

    case 'reportes1':

        require_once("model/reportesModel.php");
        $a=new Reportes();
        $ejeCursos=$a->getCursos();
        $ejeEmpleados=$a->getEmpleadosActivos();
        $cuerpo=$a->getEstadoAsignacion1();
        $view->content="view/reportes1.php";
        break;


    case 'reportes2':
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'periodo';
        //$lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';

        $view->cursos=$view->u->getCursosPropuestosByFiltro($periodo);
        $view->content="view/reportes2.php";

        if($_POST['filtro']=='filtro'){
            include_once('view/reportesGrid2.php');
            exit;
        }

        break;

    default:
        $view->solicitud=$view->u->getCapSolic();
        $view->content="view/reportes.php";
        break;

}





?>