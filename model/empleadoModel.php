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
        $obj_emp->executeQuery("select * from empleados where id_empleado=$id");
        return $obj_emp->fetchAll(); // retorna todos los clientes
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
        $query="update empleados set apellido='$this->apellido', nombre='$this->nombre', lugar_trabajo='$this->lugar_trabajo', n_legajo=$this->n_legajo, empresa='$this->empresa', funcion='$this->funcion', categoria='$this->categoria', division='$this->division', fecha_ingreso=to_date('$this->fecha_ingreso','DD/MM/YYYY'), activo=$this->activo, email='$this->email', cuil='$this->cuil'  where id_empleado = $this->id_empleado";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function insertEmpleado()
    {
        $f=new Factory();
        $obj_emp=$f->returnsQuery();
        $query="insert into empleados(apellido, nombre, lugar_trabajo, n_legajo, empresa, funcion, categoria, division, fecha_ingreso, activo, email, cuil)".
            "values('$this->apellido', '$this->nombre', '$this->lugar_trabajo' , $this->n_legajo, '$this->empresa', '$this->funcion', '$this->categoria', '$this->division', to_date('$this->fecha_ingreso','DD/MM/YYYY'), $this->activo, '$this->email', '$this->cuil')";
        $obj_emp->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }
    function delete()	// elimina el cliente
    {
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    //*****************************************************************************************

    /*esta clase debe incluir los metodos para:
 - validar al usuario
 - iniciar sesion
 - cerrar sesion */

    function isAValidUser($login,$pass){
        /*
        Esta funcion deberia devolver en un array de la forma $user['habilitado']=1    $user['accesslevel']=xxx    return $user
         */

        //No olvider despues de hacer la codificacionn a md5
        //$pass=md5($pass);

        $f=new Factory();
        $s=$f->returnsQuery();
        //$query="select * from usuarios where login ='$login' and password='$pass'";
        $query="select * from usuarios, perfiles where login ='$login' and password='$pass' and usuarios.id_perfil=perfiles.id_perfil ";
        $s->executeQuery($query);
        $r=$s->fetchAll();
        //print_r($r);
        //echo $r[0]['HABILITADO'];

        //echo "ESTO ES LO QUE ME DEVUELVE EL GETAFFECT ".$s->getAffect();
        if ($s->getAffect()>=1) //en teoria devuelve la cantidad de filas afectadas. OJO controlar esta funcion
        {
            //lo trabajo de la manera porque a pesar de ser un solo registro el de la consulta
            // lo devuelve en forma de un array bidimensional
            $datos=array();
            if($r[0]['HABILITADO']==1){
                $datos[0]=$r[0]['ID_USUARIO'];
                $datos[1]=$r[0]['LOGIN'];
                $datos[2]=$r[0]['ACCESSLEVEL'];
                return $datos;
            }

            else return 0;
        }
        else
        { return -1;
        }
    }


    public function salir(){
        session_destroy();

    }





}


?>