<?php


class Programa
{
    var $id_programa;
    var $nro_proyecto;
    var $periodo;
    var $fecha_ingreso;
    var $fecha_evaluacion;
    var $fecha_preaprobacion;
    var $fecha_aprobacion;
    var $tipo_programa;
    var $estado;

    var $contacto;
    var $email;


    // metodos que devuelven valores
    function getIdPrograma()
    { return $this->id_programa;}

    function getNroPrograma()
    { return $this->nro_proyecto;}

    function getPeriodo()
    { return $this->periodo;}

    function getFechaIngreso()
    { return $this->fecha_ingreso;}

    function getFechaEvaluacion()
    { return $this->fecha_evaluacion;}

    function getFechaPreaprobacion()
    { return $this->fecha_preaprobacion;}

    function getFechaAprobacion()
    { return $this->fecha_aprobacion;}

    function getTipoPrograma()
    { return $this->tipo_programa;}

    function getEstado()
    { return $this->estado;}

    function getContacto()
    { return $this->contacto;}

    function getEmail()
    { return $this->email;}


    // metodos que setean los valores
    function setIdPrograma($val)
    { $this->id_programa=$val;}

    function setNroPrograma($val)
    {  $this->nro_proyecto=$val;}

    function setPeriodo($val)
    {  $this->periodo=$val;}

    function setFechaIngreso($val)
    {  $this->fecha_ingreso=$val;}

    function setFechaEvaluacion($val)
    {  $this->fecha_evaluacion=$val;}

    function setFechaPreaprobacion($val)
    {  $this->fecha_preaprobacion=$val;}

    function setFechaAprobacion($val)
    {  $this->fecha_aprobacion=$val;}

    function setTipoPrograma($val)
    {  $this->tipo_programa=$val;}

    function setEstado($val)
    {  $this->estado=$val;}

    function setContacto($val)
    {  $this->contacto=$val;}

    function setEmail($val)
    {  $this->email=$val;}



    public static function getProgramas(){
        $f=new Factory();
        $obj_pro=$f->returnsQuery();
        $query="select * from programas";
        $obj_pro->executeQuery($query);
        //$obj_pro->executeQuery($query);
        return $obj_pro->fetchAll(); // retorna todos los programas
    }

    public function getProgramaById($id){

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        /*$query="select id_empleado, nombre, apellido, lugar_trabajo, n_legajo, empresa, funcion, to_char(fecha_ingreso,'DD/MM/YYYY')".
            " as fecha_ingreso, activo, email, cuil, id_division as division from empleados where id_empleado = :id";*/
        $query="select tipo_programa, periodo, nro_programa, estado, to_char(fecha_ingreso,'DD/MM/YYYY') as fecha_ingreso, to_char(fecha_evaluacion,'DD/MM/YYYY') as fecha_evaluacion,".
                " to_char(fecha_preaprobacion,'DD/MM/YYYY') as fecha_preaprobacion, to_char(fecha_aprobacion,'DD/MM/YYYY') as fecha_aprobacion, contacto, email from programas where id_programa = :id";
        $obj_emp->dpParse($query);
        $obj_emp->dpBind(':id', $id);
        $obj_emp->dpExecute();
        return $obj_emp->fetchAll();
    }


    public function updatePrograma(){

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="update programas set nro_programa= :nro_programa, periodo= :periodo, fecha_ingreso=to_date(:fecha_ingreso,'DD/MM/YYYY'), fecha_evaluacion=to_date(:fecha_evaluacion,'DD/MM/YYYY'),".
                " fecha_preaprobacion=to_date(:fecha_preaprobacion,'DD/MM/YYYY'), fecha_aprobacion=to_date(:fecha_aprobacion,'DD/MM/YYYY'), tipo_programa= :tipo_programa, estado= :estado, contacto= :contacto, email= :email where id_programa = :id_programa";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':id_programa', $this->id_programa);
        $obj_emp->dpBind(':nro_programa', $this->getNroPrograma());
        $obj_emp->dpBind(':periodo', $this->getPeriodo());
        $obj_emp->dpBind(':fecha_ingreso', $this->getFechaIngreso());
        $obj_emp->dpBind(':fecha_evaluacion', $this->getFechaEvaluacion());
        $obj_emp->dpBind(':fecha_preaprobacion', $this->getFechaPreaprobacion());
        $obj_emp->dpBind(':fecha_aprobacion', $this->getFechaAprobacion());
        $obj_emp->dpBind(':tipo_programa', $this->getTipoPrograma());
        $obj_emp->dpBind(':estado', $this->getEstado());
        $obj_emp->dpBind(':contacto', $this->getContacto());
        $obj_emp->dpBind(':email', $this->getEmail());

        $obj_emp->dpExecute();
        return $obj_emp->getAffect();

    }

    public function insertPrograma(){

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into programas (nro_programa, periodo, fecha_ingreso, fecha_evaluacion, fecha_preaprobacion, fecha_aprobacion, tipo_programa, estado, contacto, email)".
            " values(:nro_programa, :periodo, to_date(:fecha_ingreso,'DD/MM/YYYY'), to_date(:fecha_evaluacion,'DD/MM/YYYY'), to_date(:fecha_preaprobacion,'DD/MM/YYYY'), to_date(:fecha_aprobacion,'DD/MM/YYYY'), :tipo_programa, :estado, :contacto, :email)";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':nro_programa', $this->getNroPrograma());
        $obj_emp->dpBind(':periodo', $this->getPeriodo());
        $obj_emp->dpBind(':fecha_ingreso', $this->getFechaIngreso());
        $obj_emp->dpBind(':fecha_evaluacion', $this->getFechaEvaluacion());
        $obj_emp->dpBind(':fecha_preaprobacion', $this->getFechaPreaprobacion());
        $obj_emp->dpBind(':fecha_aprobacion', $this->getFechaAprobacion());
        $obj_emp->dpBind(':tipo_programa', $this->getTipoPrograma());
        $obj_emp->dpBind(':estado', $this->getEstado());
        $obj_emp->dpBind(':contacto', $this->getContacto());
        $obj_emp->dpBind(':email', $this->getEmail());

        $obj_emp->dpExecute();
        return $obj_emp->getAffect();

    }

    public function getProgramasByPeriodo($periodo){
        $f=new Factory();
        $obj_pro=$f->returnsQuery();
        $query="select * from programas where periodo = $periodo";
        $obj_pro->executeQuery($query);
        return $obj_pro->fetchAll(); // retorna todos los programas
        //echo $query;
    }

    /*
    function delete(){
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query);
        return $obj_cliente->getAffect();
    }*/



}


?>