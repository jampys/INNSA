<?php
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/cap_solicModel.php");
require_once("model/reportesModel.php");
$view->s=new Cap_Solic();
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

        //$periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'periodo';
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : date('Y');

        $view->cursos=$view->u->getCursosPropuestosByFiltro($periodo);
        $view->content="view/reportes2.php";

        if($_POST['filtro']=='filtro'){
            include_once('view/reportesGrid2.php');
            exit;
        }

        break;


    case 'reportes3': //Aprobacion
        //$periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'pc.periodo';
        $periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : date('Y');
        //$lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';
        $lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'null';

        $view->planes=$view->u->getPlanesCapacitacion($periodo, $lugar_trabajo);
        $view->content="view/reportes3.php";

        if($_POST['filtro']=='filtro'){
            include_once('view/reportesGrid3.php');
            exit;
        }

        break;

    case 'empleadoPorCurso':

        if(isset($_POST['buscar'])){
            //Refresh grid

            $id_categoria= ($_POST['id_categoria']!='')? "'".$_POST['id_categoria']."'" : 'te.id_categoria';
            $id_tema= ($_POST['id_tema']!='')? "'".$_POST['id_tema']."'" : 'te.id_tema';
            $id_curso= ($_POST['id_curso']!='')? "'".$_POST['id_curso']."'" : 'cu.id_curso';
            $id_empleado= ($_POST['id_empleado']!='')? "'".$_POST['id_empleado']."'" : 'em.id_empleado';
            $activos= ($_POST['activos']==1)? 1 : 'em.activo';
            $view->busqueda=$view->u->getEmpleadosByCursoReporte($id_categoria, $id_tema, $id_curso, $id_empleado, $activos);
            include_once('view/reporteEmpleadoPorCursoGrid.php');
            exit;
            break;
        }
        else{

            require_once("model/cursoModel.php");
            $view->u=new Curso();
            $categorias=$view->u->getCategorias();
            //$periodo= ($_POST['periodo']!='')? "'".$_POST['periodo']."'" : 'pc.periodo';
            //$lugar_trabajo= ($_POST['lugar_trabajo']!='')? "'".$_POST['lugar_trabajo']."'" : 'em.lugar_trabajo';
            //$view->planes=$view->u->getPlanesCapacitacion($periodo, $lugar_trabajo);
            $view->content="view/reporteEmpleadoPorCurso.php";

        }



        break;


    default: //reportes de solicitudes de capacitacion
        $view->solicitud=$view->s->getCapSolic(date('Y'));
        $view->content="view/reportes.php";
        break;

}





?>