<?php


class Empleado
{
    var $id_empleado;
    var $nombre;
    var $apellido;
    var $lugar_trabajo;
    var $n_legajo;
    var $empresa;
    var $funcion;
    var $categoria;
    var $id_division;
    var $fecha_ingreso;
    var $activo;
    var $email;
    var $cuil;


    public static function getEmpleados(){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        //$obj_emp->executeQuery("select * from empleados");
        $query="select empleados.*, division.nombre DIVISION from empleados, division".
                " where empleados.id_division = division.id_division (+)";
        $obj_emp->executeQuery($query);
        return $obj_emp->fetchAll(); // retorna todos los empleados
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

    public function autocompletarEmpleados($term, $id_empleado, $target){  //funcion usada para autocompletar de empleados (solo activos)
        /* Si se le pasa el parametro 'BYUSER': Devuelve solos los empleados habilitados para que el usuario opere
           Si se le para el parametro 'ALL': Devuelve todos los empleados
        */
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //$query="select * from empleados where (nombre like UPPER ('%".$term."%') or apellido like UPPER ('%".$term."%')) and activo = 1";
        if($target=='BYUSER'){
            $query="select em.*".
                " from empleados em, division di, supervisor_division sd, empleados su".
                " where em.id_division = di.id_division".
                " and di.id_division = sd.id_division".
                " and sd.id_empleado = su.id_empleado".
                " and su.id_empleado = $id_empleado".
                " and (em.nombre like UPPER ('%".$term."%') or em.apellido like UPPER ('%".$term."%'))".
                " and em.activo = 1";
        }else if ($target=='ALL'){
            $query="select * from empleados where (nombre like UPPER ('%".$term."%') or apellido like UPPER ('%".$term."%')) and activo = 1";
        }

        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll();
    }


    // metodos que devuelven valores
    function getIdEmpleado()
    { return $this->id_empleado;}

    function getNombre()
    { return $this->nombre;}

    function getApellido()
    { return $this->apellido;}

    function getLugarTrabajo()
    { return $this->lugar_trabajo;}

    function getNLegajo()
    { return $this->n_legajo;}

    function getEmpresa()
    { return $this->empresa;}

    function getFuncion()
    { return $this->funcion;}

    function getCategoria()
    { return $this->categoria;}

    function getDivision()
    { return $this->id_division;}

    function getFechaIngreso()
    { return $this->fecha_ingreso;}

    function getActivo()
    { return $this->activo;}

    function getEmail()
    { return $this->email;}

    function getCuil()
    { return $this->cuil;}

    // metodos que setean los valores
    function setIdEmpleado($val)
    { $this->id_empleado=$val;}

    function setNombre($val)
    {  $this->nombre=$val;}

    function setApellido($val)
    {  $this->apellido=$val;}

    function setLugarTrabajo($val)
    {  $this->lugar_trabajo=$val;}

    function setNLegajo($val)
    {  $this->n_legajo=$val;}

    function setEmpresa($val)
    {  $this->empresa=$val;}

    function setFuncion($val)
    {  $this->funcion=$val;}

    function setCategoria($val)
    {  $this->categoria=$val;}

    function setDivision($val)
    {  $this->id_division=$val;}

    function setFechaIngreso($val)
    {  $this->fecha_ingreso=$val;}

    function setActivo($val)
    {  $this->activo=$val;}

    function setEmail($val)
    {  $this->email=$val;}

    function setCuil($val)
    {  $this->cuil=$val;}




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

    public function insertEmpleado(){
        /*
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into empleados(apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, division, fecha_ingreso, activo, email, cuil)".
            "values('$this->apellido', '$this->nombre', '$this->lugar_trabajo' , '$this->n_legajo', '$this->empresa', '$this->funcion', '$this->division', to_date('$this->fecha_ingreso','DD/MM/YYYY'), $this->activo, '$this->email', '$this->cuil')";
        $obj_emp->executeQuery($query);
        return $obj_emp->getAffect(); */

        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into empleados (apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, id_division, fecha_ingreso, activo, email, cuil)".
            " values(:apellido, :nombre, :lugar_trabajo, :n_legajo, :empresa, :funcion, :division, to_date(:fecha_ingreso,'DD/MM/YYYY'), :activo, :email, :cuil)";
        $obj_emp->dpParse($query);

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