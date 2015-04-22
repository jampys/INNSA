<?php


class Comunicacion
{
    var $id_comunicacion;
    var $id_asignacion;
    var $situacion;
    var $objetivo_1;
    var $objetivo_2;
    var $objetivo_3;
    var $indicadores_exito;
    var $compromiso;
    var $comunico;
    var $notificado;


    // metodos que devuelven valores
    function getIdComunicacion()
    { return $this->id_comunicacion;}

    function getIdAsignacion()
    { return $this->id_asignacion;}

    function getSituacion()
    { return $this->situacion;}


    function getObjetivo1()
    { return $this->objetivo_1;}

    function getObjetivo2()
    { return $this->objetivo_2;}

    function getObjetivo3()
    { return $this->objetivo_3;}

    function getIndicadoresExito()
    { return $this->indicadores_exito;}

    function getCompromiso()
    { return $this->compromiso;}

    function getComunico()
    { return $this->comunico;}

    function getNotificado()
    { return $this->notificado;}


    // metodos que setean los valores
    function setIdComunicacion($val)
    { $this->id_comunicacion=$val;}

    function setIdAsignacion($val)
    {  $this->id_asignacion=$val;}

    function setSituacion($val)
    {  $this->situacion=$val;}


    function setObjetivo1($val)
    {  $this->objetivo_1=$val;}

    function setObjetivo2($val)
    {  $this->objetivo_2=$val;}

    function setObjetivo3($val)
    {  $this->objetivo_3=$val;}

    function setIndicadoresExito($val)
    {  $this->indicadores_exito=$val;}

    function setCompromiso($val)
    {  $this->compromiso=$val;}

    function setFuncion($val)
    {  $this->funcion=$val;}

    function setComunico($val)
    {  $this->comunico=$val;}

    function setNotificado($val)
    {  $this->notificado=$val;}



    public function getComunicacionByAsignacion($id){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        //$obj_emp->executeQuery("select * from cap_comunicacion, empleados where cap_comunicacion.comunico = empleados.id_empleado and id_asignacion=$id");
        $obj_emp->executeQuery("select * from cap_comunicacion co, empleados em, asignacion_plan ap where co.comunico = em.id_empleado (+) and co.id_asignacion = ap.id_asignacion and ap.id_asignacion=$id");
        return $obj_emp->fetchAll();
    }

    public function updateComunicacion(){
        /*
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cap_comunicacion set situacion='$this->situacion', objetivo_1='$this->objetivo_1', objetivo_2='$this->objetivo_2', objetivo_3='$this->objetivo_3', indicadores_exito='$this->indicadores_exito', compromiso='$this->compromiso', comunico=$this->comunico where id_comunicacion = $this->id_comunicacion";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); */

        $f=new Factory();
        $obj_com=$f->returnsQuery();
        $query="update cap_comunicacion set situacion=:situacion, objetivo_1=:objetivo_1, objetivo_2=:objetivo_2, objetivo_3=:objetivo_3, indicadores_exito=:indicadores_exito, compromiso=:compromiso, comunico=:comunico where id_comunicacion = :id_comunicacion";
        $obj_com->dpParse($query);

        $obj_com->dpBind(':situacion', $this->situacion);
        $obj_com->dpBind(':objetivo_1', $this->objetivo_1);
        $obj_com->dpBind(':objetivo_2', $this->objetivo_2);
        $obj_com->dpBind(':objetivo_3', $this->objetivo_3);
        $obj_com->dpBind(':indicadores_exito', $this->indicadores_exito);
        $obj_com->dpBind(':compromiso', $this->compromiso);
        $obj_com->dpBind(':comunico', $this->comunico);
        $obj_com->dpBind(':id_comunicacion', $this->id_comunicacion);

        $obj_com->dpExecute();
        return $obj_com->getAffect();

    }

    public function updateComunicacionNotificacion(){ //Se actualiza la comunicacion a notificada

        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cap_comunicacion set notificado=$this->notificado where id_comunicacion = $this->id_comunicacion";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect();

    }

    public function updateComunicacionComunicacion(){ //Se actualiza la comunicacion... se settea el campo "comunico"

        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cap_comunicacion set comunico=$this->comunico where id_comunicacion = $this->id_comunicacion";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect();

    }

    public function insertComunicacion(){
        /*
        $f=new Factory();
        $obj_com=$f->returnsQuery();
        $query="insert into cap_comunicacion(id_asignacion, situacion, objetivo_1, objetivo_2, objetivo_3, indicadores_exito, compromiso, comunico)".
            "values($this->id_asignacion, '$this->situacion', '$this->objetivo_1', '$this->objetivo_2', '$this->objetivo_3', '$this->indicadores_exito', '$this->compromiso', '$this->comunico')";
        $obj_com->executeQuery($query);
        return $obj_com->getAffect();  */

        $f=new Factory();
        $obj_com=$f->returnsQuery();
        $query="insert into cap_comunicacion(id_asignacion, situacion, objetivo_1, objetivo_2, objetivo_3, indicadores_exito, compromiso, comunico)".
            "values(:id_asignacion, :situacion, :objetivo_1, :objetivo_2, :objetivo_3, :indicadores_exito, :compromiso, :comunico)";
        $obj_com->dpParse($query);

        $obj_com->dpBind(':id_asignacion', $this->id_asignacion);
        $obj_com->dpBind(':situacion', $this->situacion);
        $obj_com->dpBind(':objetivo_1', $this->objetivo_1);
        $obj_com->dpBind(':objetivo_2', $this->objetivo_2);
        $obj_com->dpBind(':objetivo_3', $this->objetivo_3);
        $obj_com->dpBind(':indicadores_exito', $this->indicadores_exito);
        $obj_com->dpBind(':compromiso', $this->compromiso);
        $obj_com->dpBind(':comunico', $this->comunico);

        $obj_com->dpExecute();
        return $obj_com->getAffect();

    }

    public function copyPropuestaIntoComunicacion($id_solicitud){

        $f=new Factory();
        $obj_com=$f->returnsQuery();
        $query="insert into cap_comunicacion (id_asignacion, situacion, indicadores_exito, compromiso, objetivo_1, objetivo_2, objetivo_3)".
                " select ap.id_asignacion, pro.situacion, pro.indicadores_exito, pro.compromiso, pro.objetivo_1, pro.objetivo_2, pro.objetivo_3".
                " from solicitud_capacitacion sc, asignacion_plan ap, propuestas pro, plan_capacitacion pc".
                " where pro.id_solicitud = sc.id_solicitud".
                " and sc.id_solicitud = ap.id_solicitud".
                " and pro.id_curso = pc.id_curso".
                " and pc.id_plan = ap.id_plan".
                " and sc.id_solicitud = $id_solicitud";

        $obj_com->executeQuery($query);
        return $obj_com->getAffect();

    }


    public function getDatosForSendComunicationMail(){
        $f = new Factory();
        $obj_com = $f->returnsQuery();
        $query = "select pc.periodo, cu.nombre CURSO, em.apellido, em.nombre, em.email, pc.fecha_desde, pc.fecha_hasta".
                " from plan_capacitacion pc, asignacion_plan ap, cursos cu, solicitud_capacitacion sc, empleados em, usuarios us".
                " where ap.id_solicitud = sc.id_solicitud".
                " and sc.id_empleado = em.id_empleado".
                " and ap.id_plan = pc.id_plan".
                " and pc.id_curso = cu.id_curso".
                " and em.id_empleado = us.id_empleado".
                " and ap.id_asignacion = $this->id_asignacion";


        $obj_com->executeQuery($query);
        return $obj_com->fetchAll();


    }








}


?>