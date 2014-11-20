<?php

//require_once("lib/config.php");

class User
{
    var $id_usuario;
    var $login;     //se declaran los atributos de la clase, que son los atributos del usuario
    var $password;
    var $fecha_alta;
    var $id_perfil;
    var $id_empleado;
    var $habilitado;
    var $fecha_baja;


    public static function getUsuarios(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$obj_user->executeQuery("select * from usuarios, perfiles where usuarios.id_perfil=perfiles.id_perfil");
        $obj_user->executeQuery("select * from usuarios, perfiles, empleados where usuarios.id_perfil=perfiles.id_perfil and usuarios.id_empleado=empleados.id_empleado");
        return $obj_user->fetchAll(); // retorna todos los clientes
    }

    public function getUsuarioById($id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$obj_user->executeQuery("select * from usuarios, perfiles where usuarios.id_perfil = perfiles.id_perfil and id_usuario=$id");
        $obj_user->executeQuery("select * from usuarios, perfiles, empleados where usuarios.id_perfil = perfiles.id_perfil and usuarios.id_empleado=empleados.id_empleado and id_usuario=$id");
        return $obj_user->fetchAll(); // retorna todos los clientes
    }




    // metodos que devuelven valores
    function getIdUsuario()
    { return $this->id_usuario;}

    function getLogin()
    { return $this->login;}

    function getPassword()
    { return $this->password;}

    function getFechaAlta()
    { return $this->fecha_alta;}

    function getIdPerfil()
    { return $this->id_perfil;}

    function getIdEmpleado()
    { return $this->id_empleado;}

    function getHabilitado()
    { return $this->habilitado;}

    // metodos que setean los valores
    function setIdUsuario($val)
    { $this->id_usuario=$val;}

    function setLogin($val)
    {  $this->login=$val;}

    function setPassword($val)
    {  $this->password=$val;}

    function setFechaAlta($val)
    {  $this->fecha_alta=$val;}

    function setIdPerfil($val)
    {  $this->id_perfil=$val;}

    function setIdEmpleado($val)
    {  $this->id_empleado=$val;}

    function setHabilitado($val)
    {  $this->habilitado=$val;}




    public function updateUsuario()	// actualiza el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update usuarios set login='$this->login', password='$this->password', id_perfil=$this->id_perfil, id_empleado=$this->id_empleado, habilitado=$this->habilitado where id_usuario = $this->id_usuario   ";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }

    public function insertUsuario()	// inserta el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="insert into usuarios(login, password, id_perfil, id_empleado, habilitado)".
            "values('$this->login', '$this->password', $this->id_perfil , $this->id_empleado, $this->habilitado)";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }
    function delete()	// elimina el cliente
    {
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function autocompletarEmpleadosSinUser($term){  //funcion usada para autocompletar de empleados
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //$query="select * from empleados where nombre like UPPER ('%".$term."%') or apellido like UPPER ('%".$term."%')";
        //La consulta trae solos los empleados que no tienen usuario asociado
        $query="select * from empleados where (nombre like UPPER ('%".$term."%') or apellido like UPPER ('%".$term."%')) and id_empleado not in (select id_empleado from usuarios)";
        $obj_cp->executeQuery($query);
        return $obj_cp->fetchAll(); // retorna todos los cursos
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
        //$query="select * from usuarios, perfiles where login ='$login' and password='$pass' and usuarios.id_perfil=perfiles.id_perfil ";
        $query="select * from usuarios, perfiles, empleados where login ='$login' and password='$pass' and".
               " usuarios.id_perfil=perfiles.id_perfil and usuarios.id_empleado = empleados.id_empleado";
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
                $datos[3]=$r[0]['APELLIDO'];
                $datos[4]=$r[0]['NOMBRE'];
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