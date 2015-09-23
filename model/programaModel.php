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
        $obj_pro->executeQuery($query);
        return $obj_pro->fetchAll(); // retorna todos los programas
    }

    public function getEmpleadoById($id){
        /*
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        //$obj_emp->executeQuery("select * from empleados where id_empleado=$id");
        $obj_emp->executeQuery("select id_empleado, nombre, apellido, lugar_trabajo, n_legajo, empresa, funcion, division, to_char(fecha_ingreso,'DD/MM/YYYY') as fecha_ingreso, activo, email, cuil from empleados where id_empleado=$id");
        return $obj_emp->fetchAll(); */

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="select id_empleado, nombre, apellido, lugar_trabajo, n_legajo, empresa, funcion, to_char(fecha_ingreso,'DD/MM/YYYY')".
            " as fecha_ingreso, activo, email, cuil, id_division as division from empleados where id_empleado = :id";
        $obj_emp->dpParse($query);
        $obj_emp->dpBind(':id', $id);
        $obj_emp->dpExecute();
        return $obj_emp->fetchAll();
    }


    public function updateEmpleado(){
        /*
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo=$this->n_legajo, empresa='$this->empresa', funcion='$this->funcion', categoria='$this->categoria', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo='$this->n_legajo', empresa='$this->empresa', funcion='$this->funcion', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $obj_user->executeQuery($query);
        return $obj_user->getAffect(); */

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="update empleados set apellido= :apellido, nombre= :nombre, lugar_trabajo= :lugar_trabajo, n_legajo= :n_legajo, empresa= :empresa, funcion= :funcion, ".
            " id_division= :division, fecha_ingreso=to_date(:fecha_ingreso,'DD/MM/YYYY'), activo= :activo, email= :email, cuil= :cuil where id_empleado = :id_empleado";
        $obj_emp->dpParse($query);

        $obj_emp->dpBind(':id_empleado', $this->id_empleado);
        $obj_emp->dpBind(':apellido', $this->apellido);
        $obj_emp->dpBind(':nombre', $this->nombre);
        $obj_emp->dpBind(':lugar_trabajo', $this->lugar_trabajo);
        $obj_emp->dpBind(':n_legajo', $this->n_legajo);
        $obj_emp->dpBind(':empresa', $this->empresa);
        $obj_emp->dpBind(':funcion', $this->funcion);
        $obj_emp->dpBind(':division', $this->id_division);
        $obj_emp->dpBind(':fecha_ingreso', $this->fecha_ingreso);
        $obj_emp->dpBind(':activo', $this->activo);
        $obj_emp->dpBind(':email', $this->email);
        $obj_emp->dpBind(':cuil', $this->cuil);

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

    /*
    function delete(){
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query);
        return $obj_cliente->getAffect();
    }*/


    public function getDivisiones(){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="select * from division";
        $obj_emp->executeQuery($query);
        return $obj_emp->fetchAll(); // retorna todas las divisiones
    }


    public function availableLegajo($l, $e, $id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $obj_user->executeQuery("select * from empleados where n_legajo = $l and empresa = $e and $id not in (select id_empleado from empleados where n_legajo = $l and id_empleado = $id)");

        $r=$obj_user->fetchAll();
        if($obj_user->getAffect()==0){
            $output = true;
        }
        else{
            $output = false;
        }
        return $output;
    }




}


?>