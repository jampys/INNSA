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
    
    case 'filtrosReportes': //reportes de solicitudes de capacitacion (filtros)
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'periodo';
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';

        $view->solicitud=$view->u->getCapSolicByFiltro($periodo, $lugar_trabajo);
        include_once('view/reportesGrid.php');
        exit;
        break;

    case 'reportes1': //reporte grilla cursos vs. empleados

        require_once("model/reportesModel.php");
        $a=new Reportes();
        $ejeCursos=$a->getCursos();
        $ejeEmpleados=$a->getEmpleadosActivos();
        $cuerpo=$a->getEstadoAsignacion1();
        $view->content="view/reportes1.php";
        break;


    case 'reportes2': //reporte cursos propuestos con asignacion pendiente
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'periodo';
        //$lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';

        $view->cursos=$view->u->getCursosPropuestosByFiltro($periodo);
        $view->content="view/reportes2.php";

        if($_POST['filtro']=='filtro'){
            include_once('view/reportesGrid2.php');
            exit;
        }

        break;


    case 'reportes3': //reporte para gerencia
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'pc.periodo';
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';

        $view->planes=$view->u->getPlanesCapacitacion($periodo, $lugar_trabajo);
        $view->content="view/reportes3.php";

        if($_POST['filtro']=='filtro'){
            include_once('view/reportesGrid3.php');
            exit;
        }

        break;

    default: //reportes de solicitudes de capacitacion
        $view->solicitud=$view->u->getCapSolic();
        $view->content="view/reportes.php";
        break;

}





?>