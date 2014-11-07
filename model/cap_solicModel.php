<?php

class Cap_Solic
{
    //Atributos
    var $id_solicitud;
    var $situacion_actual;
    var $situacion_deseada;
    var $objetivo_medible_1;
    var $objetivo_medible_2;
    var $objetivo_medible_3;
    var $fecha_solicitud;
    var $periodo;
    var $id_empleado;
    //checkboxes
    var $dp_ingreso;
    var $dp_crecimiento;
    var $dp_promocion;
    var $dp_futura_transfer;
    var $dp_sustitucion_temp;

    var $di_nuevas_tecnicas;
    var $di_crecimiento;
    var $di_competencias_emp;

    var $rp_falta_comp;
    var $rp_no_conformidad;
    var $rp_req_externo;

    var $apr_solicito;
    var $apr_autorizo;
    var $apr_aprobacion;



    // metodos que devuelven valores
    function getIdSolicitud()
    { return $this->id_solicitud;}

    function getSituacionActual()
    { return $this->situacion_actual;}

    function getSituacionDeseada()
    { return $this->situacion_deseada;}

    function getObjetivoMedible1()
    { return $this->objetivo_medible_1;}

    function getObjetivoMedible2()
    { return $this->objetivo_medible_2;}

    function getObjetivoMedible3()
    { return $this->objetivo_medible_3;}

    function getFechaSolicitud()
    { return $this->fecha_solicitud;}

    function getPeriodo()
    { return $this->periodo;}

    function getIdEmpleado()
    { return $this->id_empleado;}

    function getDpIngreso()
    { return $this->dp_ingreso;}

    function getDpCrecimiento()
    { return $this->dp_crecimiento;}

    function getDpPromocion()
    { return $this->dp_promocion;}

    function getDpFuturaTransfer()
    { return $this->dp_futura_transfer;}

    function getDpSustitucionTemp()
    { return $this->dp_sustitucion_temp;}

    function getDiNuevasTecnicas()
    { return $this->di_nuevas_tecnicas;}

    function getDiCrecimiento()
    { return $this->di_crecimiento;}

    function getDiCompetenciasEmp()
    { return $this->di_competencias_emp;}

    function getRpFaltaComp()
    { return $this->rp_falta_comp;}

    function getRpNoConformidad()
    { return $this->rp_no_conformidad;}

    function getRpReqExterno()
    { return $this->rp_req_externo;}

    function getAprSolicito()
    { return $this->apr_solicito;}

    function getAprAutorizo()
    { return $this->apr_autorizo;}

    function getAprAprobacion()
    { return $this->apr_aprobacion;}



    // metodos que setean los valores
    function setIdSolicitud($val)
    { $this->id_solicitud=$val;}

    function setSituacionActual($val)
    {  $this->situacion_actual=$val;}

    function setSituacionDeseada($val)
    {  $this->situacion_deseada=$val;}

    function setObjetivoMedible1($val)
    {  $this->objetivo_medible_1=$val;}

    function setObjetivoMedible2($val)
    {  $this->objetivo_medible_2=$val;}

    function setObjetivoMedible3($val)
    {  $this->objetivo_medible_3=$val;}

    function setFechaSolicitud($val)
    {  $this->fecha_solicitud=$val;}

    function setPeriodo($val)
    {  $this->periodo=$val;}

    function setIdEmpleado($val)
    {  $this->id_empleado=$val;}

    function setDpIngreso($val)
    {  $this->dp_ingreso=$val;}

    function setDpCrecimiento($val)
    {  $this->dp_crecimiento=$val;}

    function setDpPromocion($val)
    {  $this->dp_promocion=$val;}

    function setDpFuturaTransfer($val)
    {  $this->dp_futura_transfer=$val;}

    function setDpSustitucion($val)
    {  $this->dp_sustitucion_temp=$val;}

    function setDiNuevasTecnicas($val)
    {  $this->di_nuevas_tecnicas=$val;}

    function setDiCrecimiento($val)
    {  $this->di_crecimiento=$val;}

    function setDiCompetenciasEmp($val)
    {  $this->di_competencias_emp=$val;}

    function setRpFaltaComp($val)
    {  $this->rp_falta_comp=$val;}

    function setRpNoConformidad($val)
    {  $this->rp_no_conformidad=$val;}

    function setRpReqExterno($val)
    {  $this->rp_req_externo=$val;}

    function setAprSolicito($val)
    {  $this->apr_solicito=$val;}

    function setAprAutorizo($val)
    {  $this->apr_autorizo=$val;}

    function setAprAprobacion($val)
    {  $this->apr_aprobacion=$val;}



    public static function getCapSolic(){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select * from solicitud_capacitacion sc, empleados em where sc.id_empleado=em.id_empleado");
        return $obj_sp->fetchAll(); // retorna todas las solicitudes de capacitacion
    }

    public function getCapPlanById($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();

        $obj_cp->executeQuery("select * from plan_capacitacion, cursos where plan_capacitacion.id_curso=cursos.id_curso and plan_capacitacion.id_plan=$id");
        return $obj_cp->fetchAll();
    }

    public static function getPlanes($term){  //funcion usada para autocompletar planes
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //$query="select * from cursos where nombre like UPPER ('%".$term."%')";
        $query="select * from plan_capacitacion, cursos where plan_capacitacion.id_curso = cursos.id_curso and nombre like UPPER ('%".$term."%')";
        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll(); // retorna todos los cursos
    }






    public function updateCapPlan()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update plan_capacitacion set periodo=$this->periodo, objetivo='$this->objetivo', modalidad='$this->modalidad', fecha_desde=TO_DATE('$this->fecha_desde','DD/MM/YYYY'), fecha_hasta=TO_DATE('$this->fecha_hasta','DD/MM/YYYY'), duracion=$this->duracion, unidad='$this->unidad', prioridad=$this->prioridad, estado='$this->estado', importe=$this->importe, moneda='$this->moneda', tipo_cambio=$this->tipo_cambio, forma_pago='$this->forma_pago', forma_financiacion=$this->forma_financiacion, profesor_1='$this->profesor_1', profesor_2='$this->profesor_2', comentarios_plan='$this->comentarios' where id_plan = $this->id_plan";
        $obj_cp->executeQuery($query);
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function insertCapPlan()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="insert into plan_capacitacion (id_curso, periodo, objetivo, modalidad, fecha_desde, fecha_hasta, duracion, unidad, prioridad, estado, importe, moneda, tipo_cambio, forma_pago, forma_financiacion, profesor_1, profesor_2, comentarios_plan)".
        "values($this->id_curso, $this->periodo, '$this->objetivo', '$this->modalidad', TO_DATE('$this->fecha_desde','DD/MM/YYYY'), TO_DATE('$this->fecha_hasta','DD/MM/YYYY'), $this->duracion , '$this->unidad', $this->prioridad, '$this->estado', $this->importe, '$this->moneda', $this->tipo_cambio, '$this->forma_pago', $this->forma_financiacion, '$this->profesor_1', '$this->profesor_2', '$this->comentarios')";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }
    function deleteCurso()	// elimina el cliente
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cp->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cp->getAffect(); // retorna todos los registros afectados

    }






}

//Definicion de clase asignacion de plan

class Asignacion_plan{

    //Atributos
    var $id_asignacion;
    var $objetivo;
    var $comentarios;
    var $viaticos;
    var $id_solicitud;
    var $id_plan;


    // metodos que devuelven valores
    function getIdAsignacion()
    { return $this->id_asignacion;}

    function getObjetivo()
    { return $this->objetivo;}

    function getComentarios()
    { return $this->comentarios;}

    function getViaticos()
    { return $this->viaticos;}

    function getIdSolicitud()
    { return $this->id_solicitud;}

    function getIdPlan()
    { return $this->id_plan;}



    // metodos que setean los valores
    function setIdAsignacion($val)
    { $this->id_asignacion=$val;}

    function setObjetivo($val)
    {  $this->objetivo=$val;}

    function setComentarios($val)
    {  $this->comentarios=$val;}

    function setViaticos($val)
    {  $this->viaticos=$val;}

    function setIdSolicitud($val)
    {  $this->id_solicitud=$val;}

    function setIdPlan($val)
    {  $this->id_plan=$val;}


    public function insertAsignacionPlan()
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "insert into asignacion_plan (objetivo, comentarios, viaticos, id_plan) values('$this->objetivo', '$this->comentarios', $this->viaticos, $this->id_plan)";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }



}



?>