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


    //NO SE USA
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
        /*$query="select sc.id_empleado, pc.id_curso, ap.estado".
            " from asignacion_plan ap, solicitud_capacitacion sc, plan_capacitacion pc".
            " where ap.id_solicitud = sc.id_solicitud".
            " and ap.id_plan = pc.id_plan".
            " UNION".
            " select ah.id_empleado, ah.id_curso, ah.estado from asignacion_plan_historico ah";*/
        $query="(select sc.id_empleado, pc.id_curso, ap.estado, pc.periodo, pc.fecha_desde".
                " from asignacion_plan ap, solicitud_capacitacion sc, plan_capacitacion pc".
                " where ap.id_solicitud = sc.id_solicitud".
                " and ap.id_plan = pc.id_plan".
                " UNION".
                " select aph.id_empleado, pch.id_curso, aph.estado, pch.periodo, pch.fecha_desde".
                " from asignacion_plan_historico aph, solicitud_capacitacion sc, plan_capacitacion_historico pch".
                " where aph.id_plan_historico = pch.id_plan_historico) order by id_empleado asc";
        $obj_user->executeQuery($query);
        return $obj_user->fetchAll();

    }



    public static function getCapSolicByFiltro($periodo, $lugar_trabajo){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select sc.*, em.apellido EMPLEADO_APELLIDO, em.nombre EMPLEADO_NOMBRE, em.lugar_trabajo, emx.apellido SOLICITO_APELLIDO, emx.nombre SOLICITO_NOMBRE from solicitud_capacitacion sc, empleados em, empleados emx where sc.id_empleado=em.id_empleado and sc.apr_solicito=emx.id_empleado and sc.periodo = $periodo and em.lugar_trabajo = $lugar_trabajo");
        return $obj_sp->fetchAll(); // retorna todas las solicitudes de capacitacion
    }


    public function getCursosPropuestosByFiltro($periodo){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        /*$query= "select cu.id_curso, cu.nombre, count(*) as cantidad".
                " from propuestas pro, cursos cu, solicitud_capacitacion sc".
                " where pro.id_curso = cu.id_curso and pro.id_solicitud = sc.id_solicitud and sc.periodo = $periodo".
                " group by cu.id_curso, cu.nombre order by cantidad DESC"; */
        $query="select cu.id_curso, cu.nombre, count(*) as cantidad".
            " from propuestas pro, cursos cu, solicitud_capacitacion sc".
            " where pro.id_curso = cu.id_curso".
            " and pro.id_solicitud = sc.id_solicitud and sc.periodo = $periodo".
            " and cu.id_curso not in".
            " (select pc.id_curso from plan_capacitacion pc, asignacion_plan ap".
            " where pc.id_plan = ap.id_plan and ap.id_solicitud = sc.id_solicitud)".
            " group by cu.id_curso, cu.nombre order by cantidad DESC";
        $obj_sp->executeQuery($query);
        return $obj_sp->fetchAll();
    }

    public function getEmpleadosByCurso($id_curso){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        /*$query= "select em.apellido, em.nombre".
            " from empleados em, solicitud_capacitacion sc, propuestas pro".
            " where pro.id_solicitud = sc.id_solicitud".
            " and em.id_empleado = sc.id_empleado".
            " and pro.id_curso = $id_curso"; */
        $query="select em.apellido, em.nombre".
                " from empleados em, solicitud_capacitacion sc, propuestas pro".
                " where pro.id_solicitud = sc.id_solicitud".
                " and em.id_empleado = sc.id_empleado".
                " and pro.id_curso = $id_curso".
                " and pro.id_curso not in".
                " (select pc.id_curso".
                " from plan_capacitacion pc, asignacion_plan ap".
                " where pc.id_plan = ap.id_plan and ap.id_solicitud = sc.id_solicitud)";
        $obj_sp->executeQuery($query);
        return $obj_sp->fetchAll();
    }


    public function getPeriodos(){ //metodo utilizado para rellenar los combos de los periodos
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $query="select DISTINCT periodo from solicitud_capacitacion".
        " UNION".
        " select DISTINCT periodo from plan_capacitacion";
        $obj_sp->executeQuery($query);
        return $obj_sp->fetchAll();
    }


    public function getPlanesCapacitacion($periodo, $lugar_trabajo){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();

            /* para planes abiertos */
        $query="select
                pc.id_plan,
                pc.periodo,
                pc.objetivo,
                cantidadasignaciones(pc.id_plan, nvl($lugar_trabajo, null) ) as cantidad,
                pc.fecha_desde,
                pc.fecha_hasta,
                /*pc.duracion,
                pc.unidad,*/
                pc.caracter_actividad as caracter,
                /*pc.importe as precio_unitario,*/
                pc.porcentaje_reintegrable,
                pc.moneda,
                pc.tipo_cambio,
                pc.importe_total,
                pro.tipo_programa,
                (pc.importe *pc.tipo_cambio) as precio_unitario,
                cantidadasignaciones(pc.id_plan, nvl($lugar_trabajo, null) ) * pc.importe * pc.tipo_cambio as subSViaticos,
                cantidadasignaciones(pc.id_plan, nvl($lugar_trabajo, null) ) * pc.importe * pc.tipo_cambio + (select sum(nvl(apx.viaticos, 0))
                                                                                          from asignacion_plan apx, solicitud_capacitacion scx, empleados em
                                                                                          where apx.id_plan = pc.id_plan and apx.id_solicitud = scx.id_solicitud
                                                                                          and scx.id_empleado = em.id_empleado
                                                                                          and em.lugar_trabajo = nvl($lugar_trabajo, em.lugar_trabajo)) as totCViaticos,

                ((select count(*) from asignacion_plan apx where apx.id_plan = pc.id_plan) - (select count(*) from asignacion_plan apx where apx.id_plan = pc.id_plan and apx.aprobada = 1) ) as diferencia,

                (select nvl(sum(pcx.importe * pcx.tipo_cambio * (nvl(pcx.porcentaje_reintegrable, 0)/100)), 0)
                      from plan_capacitacion pcx, asignacion_plan apx, solicitud_capacitacion scx, empleados emx
                      where pcx.id_plan = pc.id_plan
                      and apx.id_plan = pcx.id_plan
                      and apx.id_solicitud = scx.id_solicitud
                      and scx.id_empleado = emx.id_empleado
                      and emx.lugar_trabajo = nvl($lugar_trabajo, emx.lugar_trabajo)
                      and apx.programa = 1) as total_reintegrable,

                ((select count(*)
                      from asignacion_plan apx, solicitud_capacitacion scx, empleados emx
                      where apx.id_plan = pc.id_plan
                      and apx.id_solicitud = scx.id_solicitud
                      and scx.id_empleado = emx.id_empleado
                      and emx.lugar_trabajo = nvl($lugar_trabajo, emx.lugar_trabajo)
                      and apx.aprobada = 1) * pc.importe * pc.tipo_cambio) as total_aprobado

            from plan_capacitacion pc, programas pro
            /*where exists (select 1 from asignacion_plan apx where apx.id_plan = pc.id_plan)*/
            where exists (select 1 from asignacion_plan apx, solicitud_capacitacion scx, empleados emx where apx.id_plan = pc.id_plan and apx.id_solicitud = scx.id_solicitud and scx.id_empleado = emx.id_empleado and emx.lugar_trabajo = nvl($lugar_trabajo, emx.lugar_trabajo) )
            and pc.id_programa = pro.id_programa (+)
            and pc.periodo = $periodo
            and pc.caracter_actividad = 'ABIERTA'";
            /* FALTA AGREGAR EL UNION PARA LOS PROGRAMAS CERRADOS */


        $obj_sp->executeQuery($query);
        return $obj_sp->fetchAll();
    }

    public function getEmpleadosByPlan($lugar_trabajo, $id_plan){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $query="select em.apellido, em.nombre, em.lugar_trabajo, ap.viaticos, ap.id_asignacion, ap.aprobada, ap.programa
                from empleados em, plan_capacitacion pc, asignacion_plan ap, solicitud_capacitacion sc
                where pc.id_plan = ap.id_plan and ap.id_solicitud = sc.id_solicitud and sc.id_empleado = em.id_empleado
                and em.lugar_trabajo = nvl($lugar_trabajo, em.lugar_trabajo)
                and ap.id_plan = $id_plan";
        $obj_sp->executeQuery($query);
        return $obj_sp->fetchAll();
    }


    public function getEmpleadosByCursoReporte($id_categoria, $id_tema, $id_curso, $id_empleado, $activos){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $query="(".
        " select em.apellido, em.nombre, em.lugar_trabajo, pc.objetivo as capacitacion, pc.periodo, pc.fecha_desde, te.nombre as tema, ca.nombre as categoria, pc.modalidad, ec.nombre as entidad, tc.nombre as tipo_curso, ap.estado".
" from empleados em, asignacion_plan ap, plan_capacitacion pc, solicitud_capacitacion sc, cursos cu, categorias ca, temas te, entidades_capacitadoras ec, tipo_curso tc".
" where em.id_empleado = sc.id_empleado".
        " and sc.id_solicitud = ap.id_solicitud".
        " and ap.id_plan = pc.id_plan".
        " and pc.id_curso = cu.id_curso".
        " and cu.id_tema = te.id_tema".
        " and te.id_categoria = ca.id_categoria".
        " and pc.entidad = ec.id_entidad_capacitadora".
        " and pc.id_tipo_curso = tc.id_tipo_curso".
        //filtros
        " and cu.id_curso = $id_curso".
        " and cu.id_tema = $id_tema".
        " and ca.id_categoria = $id_categoria".
        " and em.id_empleado = $id_empleado".
        " and em.activo = $activos".

" UNION".

" select em.apellido, em.nombre, em.lugar_trabajo, pch.objetivo as capacitacion, pch.periodo, pch.fecha_desde, te.nombre as tema, ca.nombre as categoria, pch.modalidad, ec.nombre as entidad, null, aph.estado".
" from empleados em, asignacion_plan_historico aph, plan_capacitacion_historico pch, cursos cu, categorias ca, temas te, entidades_capacitadoras ec".
" where em.id_empleado = aph.id_empleado".
        " and aph.id_plan_historico = pch.id_plan_historico".
        " and pch.id_curso = cu.id_curso".
        " and cu.id_tema = te.id_tema".
        " and te.id_categoria = ca.id_categoria".
        " and pch.id_entidad = ec.id_entidad_capacitadora (+)".
        //filtros
            " and cu.id_curso = $id_curso".
            " and cu.id_tema = $id_tema".
            " and ca.id_categoria = $id_categoria".
            " and em.id_empleado = $id_empleado".
            " and em.activo = $activos".
" )".
" order by apellido, nombre, fecha_desde asc";
        $obj_sp->executeQuery($query);
        return $obj_sp->fetchAll();
    }








}


?>