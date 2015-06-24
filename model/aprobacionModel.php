<?php

class Aprobacion{



    public function aprobarPlanIndividualmente($status, $id_asignacion){

        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update asignacion_plan set aprobada= $status where id_asignacion = $id_asignacion";
        $obj_cp->dpParse($query);

        //$obj_cp->dpBind(':id_curso', $this->id_curso);

        $obj_cp->dpExecute();
        return $obj_cp->getAffect();
    }

    public function aprobarPlanMasivamente($status, $id_plan){

        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update asignacion_plan set aprobada= $status where id_plan = $id_plan";
        $obj_cp->dpParse($query);

        //$obj_cp->dpBind(':id_curso', $this->id_curso);

        $obj_cp->dpExecute();
        return $obj_cp->getAffect();
    }


    public function copyPropuestaIntoComunicacion($id_asignacion){

        $f=new Factory();
        $obj_com=$f->returnsQuery();
        $query="insert into cap_comunicacion (id_asignacion, situacion, indicadores_exito, compromiso, objetivo_1, objetivo_2, objetivo_3)".
                "select ap.id_asignacion, pro.situacion, pro.indicadores_exito, pro.compromiso, pro.objetivo_1, pro.objetivo_2, pro.objetivo_3".
                " from solicitud_capacitacion sc, asignacion_plan ap, propuestas pro, plan_capacitacion pc, cursos cu, temas te".
                " where pro.id_solicitud = sc.id_solicitud".
                " and sc.id_solicitud = ap.id_solicitud".
                " and ap.id_plan = pc.id_plan".
                " and ((pro.id_curso = cu.id_curso and cu.id_curso = pc.id_plan) OR (pro.id_tema = te.id_tema and cu.id_tema = te.id_tema and cu.id_curso = pc.id_curso))". //si fue asignado por curso OR fue asignado por tema
                " and ap.id_asignacion = $id_asignacion";

        $obj_com->executeQuery($query);
        return $obj_com->getAffect();

    }


    public function copyPropuestaIntoComunicacionMasivamente($id_plan){

        $f=new Factory();
        $obj_com=$f->returnsQuery();

        $query="insert into cap_comunicacion (id_asignacion, situacion, indicadores_exito, compromiso, objetivo_1, objetivo_2, objetivo_3)".
            "select ap.id_asignacion, pro.situacion, pro.indicadores_exito, pro.compromiso, pro.objetivo_1, pro.objetivo_2, pro.objetivo_3".
            " from solicitud_capacitacion sc, asignacion_plan ap, propuestas pro, plan_capacitacion pc, cursos cu, temas te".
            " where pro.id_solicitud = sc.id_solicitud".
            " and sc.id_solicitud = ap.id_solicitud".
            " and ap.id_plan = pc.id_plan".
            " and ((pro.id_curso = cu.id_curso and cu.id_curso = pc.id_plan) OR (pro.id_tema = te.id_tema and cu.id_tema = te.id_tema and cu.id_curso = pc.id_curso))". //si fue asignado por curso OR fue asignado por tema
            " and pc.id_plan = $id_plan".
            " and ap.aprobada is null";

        $obj_com->executeQuery($query);
        return $obj_com->getAffect();

    }







}





?>