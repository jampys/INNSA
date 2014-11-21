<?php


class Comunicacion
{
    var $id_comunicacion;
    var $id_asignacion;
    var $situacion;
    var $objetivos;
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

    function getObjetivos()
    { return $this->objetivos;}

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

    function setObjetivos($val)
    {  $this->objetivos=$val;}

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
        //$obj_emp->executeQuery("select * from cap_comunicacion where id_asignacion=$id");
        $obj_emp->executeQuery("select * from cap_comunicacion, empleados where cap_comunicacion.comunico = empleados.id_empleado and id_asignacion=$id");
        return $obj_emp->fetchAll();
    }

    public function updateComunicacion()
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cap_comunicacion set situacion='$this->situacion', objetivos='$this->objetivos', indicadores_exito='$this->indicadores_exito', compromiso='$this->compromiso', comunico=$this->comunico where id_comunicacion = $this->id_comunicacion";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }

    public function updateComunicacionNotificacion()
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update cap_comunicacion set notificado=$this->notificado where id_comunicacion = $this->id_comunicacion";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }

    public function insertComunicacion()
    {
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into cap_comunicacion(id_asignacion, situacion, objetivos, indicadores_exito, compromiso, comunico)".
            "values($this->id_asignacion, '$this->situacion', '$this->objetivos' , '$this->indicadores_exito', '$this->compromiso', '$this->comunico')";
        $obj_emp->executeQuery($query);
        return $obj_emp->getAffect(); // retorna todos los registros afectados

    }









}


?>