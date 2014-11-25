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
    var $apr_aprobo;

    var $estado;



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

    function getAprAprobo()
    { return $this->apr_aprobo;}

    function getEstado()
    { return $this->estado;}



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

    function setDpSustitucionTemp($val)
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

    function setAprAprobo($val)
    {  $this->apr_aprobo=$val;}

    function setEstado($val)
    {  $this->estado=$val;}



    public static function getCapSolic(){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        //$obj_sp->executeQuery("select * from solicitud_capacitacion sc, empleados em where sc.id_empleado=em.id_empleado");
        $obj_sp->executeQuery("select * from solicitud_capacitacion sc, empleados em, empleados emx where sc.id_empleado=em.id_empleado and sc.apr_solicito=emx.id_empleado");
        return $obj_sp->fetchAll(); // retorna todas las solicitudes de capacitacion
    }

    public function getCapSolicById($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="select sc.id_solicitud, sc.situacion_actual, sc.situacion_deseada, sc.objetivo_medible_1, sc.objetivo_medible_2, sc.objetivo_medible_3,".
            " sc.periodo, em.apellido, em.nombre,".
            " sc.dp_ingreso, sc.dp_crecimiento, sc.dp_promocion, sc.dp_futura_transfer, sc.dp_sustitucion_temp,".
            " sc.di_nuevas_tecnicas, sc.di_crecimiento, sc.di_competencias_emp,".
            " sc.rp_falta_comp, sc.rp_no_conformidad, sc.rp_req_externo,".
            " (select emx.id_empleado from empleados emx where emx.id_empleado = sc.apr_solicito) as ID_SOLICITO,".
            " (select emx.apellido from empleados emx where emx.id_empleado = sc.apr_solicito) as APELLIDO_SOLICITO,".
            " (select emx.nombre from empleados emx where emx.id_empleado = sc.apr_solicito) as NOMBRE_SOLICITO,".
            " (select emx.id_empleado from empleados emx where emx.id_empleado = sc.apr_autorizo) as ID_AUTORIZO,".
            " (select emx.apellido from empleados emx where emx.id_empleado = sc.apr_autorizo) as APELLIDO_AUTORIZO,".
            " (select emx.nombre from empleados emx where emx.id_empleado = sc.apr_autorizo) as NOMBRE_AUTORIZO,".
            " (select emx.id_empleado from empleados emx where emx.id_empleado = sc.apr_aprobo) as ID_APROBO,".
            " (select emx.apellido from empleados emx where emx.id_empleado = sc.apr_aprobo) as APELLIDO_APROBO,".
            " (select emx.nombre from empleados emx where emx.id_empleado = sc.apr_aprobo) as NOMBRE_APROBO".
            " from solicitud_capacitacion sc, empleados em".
            " where sc.id_empleado = em.id_empleado and sc.id_solicitud=$id";

        $obj_cp->executeQuery($query);
        //$obj_cp->executeQuery("select * from solicitud_capacitacion sc, empleados em where sc.id_empleado = em.id_empleado and sc.id_solicitud=$id");
        return $obj_cp->fetchAll();
    }

    /*
    public function getCapSolicSolicito($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $obj_cp->executeQuery("select * from solicitud_capacitacion sc, empleados em where sc.apr_solicito = em.id_empleado and sc.id_solicitud=$id");
        return $obj_cp->fetchAll();
    }

    public function getCapSolicAutorizo($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $obj_cp->executeQuery("select * from solicitud_capacitacion sc, empleados em where sc.apr_autorizo = em.id_empleado and sc.id_solicitud=$id");
        return $obj_cp->fetchAll();
    }

    public function getCapSolicAprobo($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $obj_cp->executeQuery("select * from solicitud_capacitacion sc, empleados em where sc.apr_aprobo = em.id_empleado and sc.id_solicitud=$id");
        return $obj_cp->fetchAll();
    }
    */

    //Funcion que devuelve los totales
    public function getCapSolicTotalesById($id){
        $f=new Factory();
        $obj_cp=$f->returnsQuery();

        $query= "select * from".
                " (select sum(viaticos) as viaticos from asignacion_plan where id_solicitud=$id),".
                " (select sum (pc.importe) as pesos from plan_capacitacion pc, asignacion_plan ap".
                " where ap.id_plan = pc.id_plan and moneda='$' and ap.id_solicitud = $id),".
                " (select sum (pc.importe * pc.tipo_cambio) as dolares from plan_capacitacion pc, asignacion_plan ap".
                " where ap.id_plan = pc.id_plan and moneda='USD' and ap.id_solicitud = $id)";

        $obj_cp->executeQuery($query);
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






    public function updateCapSolic()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update solicitud_capacitacion set situacion_actual='$this->situacion_actual', situacion_deseada='$this->situacion_deseada', objetivo_medible_1='$this->objetivo_medible_1', objetivo_medible_2='$this->objetivo_medible_2', objetivo_medible_3='$this->objetivo_medible_3'".
               ", periodo='$this->periodo', dp_ingreso=$this->dp_ingreso, dp_crecimiento=$this->dp_crecimiento, dp_promocion=$this->dp_promocion, dp_futura_transfer=$this->dp_futura_transfer, dp_sustitucion_temp=$this->dp_sustitucion_temp,".
               "di_nuevas_tecnicas=$this->di_nuevas_tecnicas, di_crecimiento=$this->di_crecimiento, di_competencias_emp=$this->di_competencias_emp,".
               "rp_falta_comp=$this->rp_falta_comp, rp_no_conformidad=$this->rp_no_conformidad, rp_req_externo=$this->rp_req_externo,".
               "apr_solicito=$this->apr_solicito ".
               "where id_solicitud = $this->id_solicitud";
        $obj_cp->executeQuery($query);
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }



    public function autorizar_aprobarCapSolic()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="update solicitud_capacitacion set apr_autorizo=$this->apr_autorizo, apr_aprobo=$this->apr_aprobo, estado='$this->estado' where id_solicitud=$this->id_solicitud";
        $obj_cp->executeQuery($query);
        return $obj_cp->getAffect(); // retorna todos los registros afectados

    }

    public function insertCapSolic()
    {
        $conn=oci_connect('dario', 'dario', 'localhost');
        $sql="insert into solicitud_capacitacion (situacion_actual, situacion_deseada, objetivo_medible_1, objetivo_medible_2, objetivo_medible_3, fecha_solicitud, periodo, id_empleado, dp_ingreso, dp_crecimiento, dp_promocion, dp_futura_transfer, dp_sustitucion_temp, di_nuevas_tecnicas, di_crecimiento, di_competencias_emp, rp_falta_comp, rp_no_conformidad, rp_req_externo, estado, apr_solicito)".
            "values('$this->situacion_actual', '$this->situacion_deseada', '$this->objetivo_medible_1', '$this->objetivo_medible_2', '$this->objetivo_medible_3', SYSDATE, '$this->periodo' , $this->id_empleado, $this->dp_ingreso, $this->dp_crecimiento, $this->dp_promocion, $this->dp_futura_transfer, $this->dp_sustitucion_temp, $this->di_nuevas_tecnicas, $this->di_crecimiento, $this->di_competencias_emp, $this->rp_falta_comp, $this->rp_no_conformidad, $this->rp_req_externo, '$this->estado', $this->apr_solicito) returning id_solicitud into :id";

        $consulta=oci_parse($conn, $sql);
        oci_bind_by_name($consulta,':id',$id);
        oci_execute($consulta);
        return $id;





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

    var $estado;
    var $estado_cambio;
    var $reemplazo;


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

    function getEstado()
    { return $this->estado;}

    function getEstadoCambio()
    { return $this->estado_cambio;}

    function getReemplazo()
    { return $this->reemplazo;}



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

    function setEstado($val)
    {  $this->estado=$val;}

    function setEstadoCambio($val)
    {  $this->estado_cambio=$val;}

    function setReemplazo($val)
    {  $this->reemplazo=$val;}




    public function getAsignacionPlan()
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "select sc.fecha_solicitud FECHA_SOLICITUD, sc.periodo, em.apellido APELLIDO, em.nombre NOMBRE, cu.nombre NOMBRE_CURSO, pc.fecha_desde FECHA_DESDE, pc.modalidad MODALIDAD, ap.estado ESTADO, ap.id_asignacion ID_ASIGNACION".
                 " from asignacion_plan ap, solicitud_capacitacion sc, empleados em, plan_capacitacion pc, cursos cu where".
                 " ap.id_solicitud = sc.id_solicitud and sc.id_empleado = em.id_empleado".
                 " and ap.id_plan = pc.id_plan and pc.id_curso = cu.id_curso";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_cp->fetchAll(); // retorna todos los cursos

    }


    public function getAsignacionPlanByUser($id)
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "select sc. periodo PERIODO, cu.nombre NOMBRE_CURSO, pc.fecha_desde FECHA_DESDE, pc.fecha_hasta FECHA_HASTA, pc.duracion DURACION, pc.unidad UNIDAD, pc.modalidad MODALIDAD, ap.estado ESTADO, ap.id_asignacion ID_ASIGNACION".
            " from asignacion_plan ap, solicitud_capacitacion sc, empleados em, plan_capacitacion pc, cursos cu, usuarios us where".
            " ap.id_solicitud = sc.id_solicitud and sc.id_empleado = em.id_empleado".
            " and ap.id_plan = pc.id_plan and pc.id_curso = cu.id_curso".
            " and us.id_empleado = em.id_empleado and us.id_usuario = $id";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_cp->fetchAll(); // retorna todos los cursos

    }

    public function insertAsignacionPlan($id_solicitud)
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "insert into asignacion_plan (id_solicitud, objetivo, comentarios, viaticos, reemplazo, estado, id_plan) values($id_solicitud, '$this->objetivo', '$this->comentarios', $this->viaticos, $this->reemplazo, '$this->estado', $this->id_plan)";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }


    //update
    public function updateAsignacionPlan()
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "update asignacion_plan set objetivo='$this->objetivo', comentarios='$this->comentarios', viaticos=$this->viaticos, reemplazo=$this->reemplazo, id_plan=$this->id_plan where id_asignacion=$this->id_asignacion";
        $obj_cp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }

    public function updateEstadoAsignacionPlan()
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "update asignacion_plan set estado='$this->estado', estado_cambio='$this->estado_cambio' where id_asignacion=$this->id_asignacion";
        $obj_cp->executeQuery($query);
        return $obj_cp->getAffect(); // retorna todos los registros afectados

    }




    //delete
    function deleteAsignacionPlan()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="delete from asignacion_plan where id_asignacion=$this->id_asignacion";
        $obj_cp->executeQuery($query); // ejecuta la consulta para  borrar la asignacion
        //return $obj_cp->getAffect(); // retorna todos los registros afectados

    }





    public static function getAsignacionPlanBySolicitud($id){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select ap.objetivo OBJETIVO, ap.comentarios COMENTARIOS, ap.viaticos VIATICOS, ap.id_plan ID_PLAN, ap.id_asignacion ID_ASIGNACION, ap.reemplazo REEMPLAZO, em.apellido APELLIDO_REEMPLAZO, em.nombre NOMBRE_REEMPLAZO, cu.nombre NOMBRE, pc.fecha_desde FECHA_DESDE, pc.modalidad MODALIDAD, pc.duracion DURACION, pc.unidad UNIDAD, pc.moneda MONEDA, pc.importe IMPORTE from asignacion_plan ap, plan_capacitacion pc, cursos cu, empleados em where ap.id_plan = pc.id_plan and pc.id_curso = cu.id_curso and ap.reemplazo = em.id_empleado and id_solicitud=$id order by pc.fecha_desde ASC");
        return $obj_sp->fetchAll(); // retorna todas las asignaciones que corresponden con el id de solicitud
    }


    public static function getAsignacionPlanById($id){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select * from asignacion_plan where id_asignacion=$id");
        return $obj_sp->fetchAll(); // retorna todas las asignaciones que corresponden con el id de solicitud
    }



}





//Definicion de clase Propuestas

class Propuesta{

    //Atributos
    var $id_propuesta;
    var $id_solicitud;
    var $id_curso;


    // metodos que devuelven valores
    function getIdPropuesta()
    { return $this->id_propuesta;}

    function getIdSolicitud()
    { return $this->id_solicitud;}

    function getIdCurso()
    { return $this->id_curso;}


    // metodos que setean los valores
    function setIdPropuesta($val)
    {  $this->id_propuesta=$val;}

    function setIdSolicitud($val)
    {  $this->id_solicitud=$val;}

    function setIdCurso($val)
    {  $this->id_curso=$val;}


    public function insertPropuesta()
    {
        $f = new Factory();
        $obj_cp = $f->returnsQuery();
        $query = "insert into propuestas (id_solicitud, id_curso) values($this->id_solicitud, $this->id_curso)";
        $obj_cp->executeQuery($query);
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }



    //delete
    function deletePropuesta()
    {
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="delete from propuestas where id_propuesta=$this->id_propuesta";
        $obj_cp->executeQuery($query);
        //return $obj_cp->getAffect(); // retorna todos los registros afectados

    }



    public static function getPropuestaBySolicitud($id){
        $f=new Factory();
        $obj_sp=$f->returnsQuery();
        $obj_sp->executeQuery("select * from propuestas, cursos where propuestas.id_curso = cursos.id_curso and id_solicitud=$id");
        return $obj_sp->fetchAll(); // retorna todas las asignaciones que corresponden con el id de solicitud
    }



}



?>