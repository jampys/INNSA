<?php

class Reportes
{


    public static function getCursos(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="select ca.nombre CATEGORIA, ca.id_categoria, cu.id_curso, cu.nombre,".
                " (select count(cursos.id_curso) from cursos, temas, categorias where cursos.id_tema = temas.id_tema and temas.id_categoria = categorias.id_categoria and temas.id_categoria = ca.id_categoria) TOTAL".
                " from categorias ca, cursos cu, temas te".
                " where te.id_categoria = ca.id_categoria".
                //" and cu.id_tema = te.id_tema";
                " and cu.id_tema = te.id_tema order by CATEGORIA, cu.nombre";
        $obj_user->executeQuery($query);
        return $obj_user->fetchAll(); // retorna todos los cursos
    }


    public static function getEmpleadosActivos(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$obj_user->executeQuery("select * from empleados where activo=1 order by lugar_trabajo asc");
        $obj_user->executeQuery("select * from empleados where activo=1 order by lugar_trabajo asc, apellido asc");
        return $obj_user->fetchAll(); // retorna todos los empleados
    }



    public static function getCapSolic(){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select sc.*, em.apellido EMPLEADO_APELLIDO, em.nombre EMPLEADO_NOMBRE, em.lugar_trabajo, emx.apellido SOLICITO_APELLIDO, emx.nombre SOLICITO_NOMBRE from solicitud_capacitacion sc, empleados em, empleados emx where sc.id_empleado=em.id_empleado and sc.apr_solicito=emx.id_empleado");
        return $obj_sp->fetchAll(); // retorna todas las solicitudes de capacitacion
    }



    public function getEstadoAsignacion($id_empleado, $id_curso){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="select ap.estado ESTADO".
                " from asignacion_plan ap, plan_capacitacion pc, cursos cu, solicitud_capacitacion sc".
                " where ap.id_plan = pc.id_plan".
                " and pc.id_curso = cu.id_curso".
                " and ap.id_solicitud = sc.id_solicitud".
                " and sc.id_empleado = $id_empleado".
                " and cu.id_curso = $id_curso";
        $obj_user->executeQuery($query);
        if($obj_user->getAffect()>0){
            return $obj_user->fetchAll();
        }
        else{
            return 0;
        }

    }



    public function getEstadoAsignacion1(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="select sc.id_empleado, pc.id_curso, ap.estado".
                " from asignacion_plan ap, solicitud_capacitacion sc, plan_capacitacion pc".
                " where ap.id_solicitud = sc.id_solicitud".
                " and ap.id_plan = pc.id_plan";
        $obj_user->executeQuery($query);
        return $obj_user->fetchAll();

    }



    public static function getCapSolicByFiltro($periodo, $lugar_trabajo){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select sc.*, em.apellido EMPLEADO_APELLIDO, em.nombre EMPLEADO_NOMBRE, em.lugar_trabajo, emx.apellido SOLICITO_APELLIDO, emx.nombre SOLICITO_NOMBRE from solicitud_capacitacion sc, empleados em, empleados emx where sc.id_empleado=em.id_empleado and sc.apr_solicito=emx.id_empleado and sc.periodo = $periodo and em.lugar_trabajo = $lugar_trabajo");
        return $obj_sp->fetchAll(); // retorna todas las solicitudes de capacitacion
    }




}


?>