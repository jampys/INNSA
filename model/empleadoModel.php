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
    var $division;
    var $fecha_ingreso;
    var $activo;
    var $email;
    var $cuil;


    public static function getEmpleados(){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $obj_emp->executeQuery("select * from empleados");
        return $obj_emp->fetchAll(); // retorna todos los empleados
    }

    public function getEmpleadoById($id){
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        //$obj_emp->executeQuery("select * from empleados where id_empleado=$id");
        $obj_emp->executeQuery("select id_empleado, nombre, apellido, lugar_trabajo, n_legajo, empresa, funcion, division, to_char(fecha_ingreso,'DD/MM/YYYY') as fecha_ingreso, activo, email, cuil from empleados where id_empleado=$id");
        return $obj_emp->fetchAll(); // retorna todos los clientes
    }

    public function autocompletarEmpleados($term){  //funcion usada para autocompletar de empleados (solo activos)
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        $query="select * from empleados where (nombre like UPPER ('%".$term."%') or apellido like UPPER ('%".$term."%')) and activo = 1";
        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll(); // retorna todos los cursos
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
    { return $this->division;}

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
    {  $this->division=$val;}

    function setFechaIngreso($val)
    {  $this->fecha_ingreso=$val;}

    function setActivo($val)
    {  $this->activo=$val;}

    function setEmail($val)
    {  $this->email=$val;}

    function setCuil($val)
    {  $this->cuil=$val;}




    public function updateEmpleado()
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo=$this->n_legajo, empresa='$this->empresa', funcion='$this->funcion', categoria='$this->categoria', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo='$this->n_legajo', empresa='$this->empresa', funcion='$this->funcion', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }

    public function insertEmpleado()
    {
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        /*$query="insert into empleados(apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, categoria, division, fecha_ingreso, activo, email, cuil)".
            "values('$this->apellido', '$this->nombre', '$this->lugar_trabajo' , $this->n_legajo, '$this->empresa', '$this->funcion', '$this->categoria', '$this->division', to_date('$this->fecha_ingreso','DD/MM/YYYY'), $this->activo, '$this->email', '$this->cuil')"; */
        $query="insert into empleados(apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, division, fecha_ingreso, activo, email, cuil)".
            "values('$this->apellido', '$this->nombre', '$this->lugar_trabajo' , '$this->n_legajo', '$this->empresa', '$this->funcion', '$this->division', to_date('$this->fecha_ingreso','DD/MM/YYYY'), $this->activo, '$this->email', '$this->cuil')";
        $obj_emp->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_emp->getAffect(); // retorna todos los registros afectados

    }
    function delete()	// elimina el cliente
    {
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }








}


?>