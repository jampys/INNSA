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
    var $clear_pass;


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

    function setClearPass($val)
    {  $this->clear_pass=$val;}




    public function updateUsuario(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="update usuarios set login='$this->login', password='$this->password', id_perfil=$this->id_perfil, id_empleado=$this->id_empleado, habilitado=$this->habilitado where id_usuario = $this->id_usuario";
        $query="update usuarios set login='$this->login', id_perfil=$this->id_perfil, id_empleado=$this->id_empleado, habilitado=$this->habilitado where id_usuario = $this->id_usuario";
        $obj_user->executeQuery($query);
        $obj_user->cerrarConexion(); //cierra la conexion
        return $obj_user->getAffect();

    }

    public function insertUsuario(){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="insert into usuarios(login, password, id_perfil, id_empleado, habilitado, clear_pass)".
            "values('$this->login', '$this->password', $this->id_perfil , $this->id_empleado, $this->habilitado, $this->clear_pass)";
        $obj_user->executeQuery($query);
        $obj_user->cerrarConexion(); //cierra la conexion
        return $obj_user->getAffect();
    }

    /*
    function delete(){
        $f=new Factory();
        $obj_cliente=$f->returnsQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query);
        return $obj_cliente->getAffect();
    } */

    public function autocompletarEmpleadosSinUser($term, $user){  //funcion usada para autocompletar de empleados
        $f=new Factory();
        $obj_cp=$f->returnsQuery();
        //La consulta trae solos los empleados que no tienen usuario asociado y al propio empleado (de tratarse de una edicion)
        /*$query="select em.id_empleado, em.apellido, em.nombre from empleados em where (em.nombre like UPPER ('%".$term."%') or em.apellido like UPPER ('%".$term."%')) and em.id_empleado not in (select id_empleado from usuarios)".
            " UNION".
            " select emx.id_empleado, emx.apellido, emx.nombre from empleados emx, usuarios us where us.id_empleado = emx.id_empleado and us.id_usuario = $user"; */
        //Se modifica consulta para que solo devuelva los empleados activos
        $query="select em.id_empleado, em.apellido, em.nombre, em.n_legajo, em.empresa from empleados em where (em.nombre like UPPER ('%".$term."%') or em.apellido like UPPER ('%".$term."%')) and em.activo = 1 and em.id_empleado not in (select id_empleado from usuarios)".
            " UNION".
            " select emx.id_empleado, emx.apellido, emx.nombre, emx.n_legajo, emx.empresa from empleados emx, usuarios us where us.id_empleado = emx.id_empleado and us.id_usuario = $user";
        $obj_cp->executeQuery($query);
        $obj_cp->cerrarConexion(); //cierra la conexion
        return $obj_cp->fetchAll();
    }

    //*****************************************************************************************

    /*esta clase debe incluir los metodos para:
 - validar al usuario
 - iniciar sesion
 - cerrar sesion */

    function isAValidUser($login,$pass){
        /*
        Esta funcion deberia devolver en un array de la forma $user['habilitado']=1    $user['accesslevel']=xxx    return $user
        *No olvidar despues de hacer la codificacionn a md5
        *$pass=md5($pass); */

        $f=new Factory();
        $s=$f->returnsQuery();
        /*$query="select * from usuarios, perfiles, empleados where login ='$login' and password='$pass' and".
               " usuarios.id_perfil=perfiles.id_perfil and usuarios.id_empleado = empleados.id_empleado"; */
        $query="select * from usuarios, perfiles, empleados where login ='$login' and password = encrypt('$pass') and".
            " usuarios.id_perfil=perfiles.id_perfil and usuarios.id_empleado = empleados.id_empleado";
        $s->executeQuery($query);
        $s->cerrarConexion(); //cierra la conexion
        $r=$s->fetchAll();
        //print_r($r);
        //echo $r[0]['HABILITADO'];

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
                $datos[5]=$r[0]['CLEAR_PASS'];
                $datos[6]=$r[0]['ID_EMPLEADO'];
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

    //funcion para limpiar el password
    public function updatePassword()
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update usuarios set password='$this->password', clear_pass = $this->clear_pass where id_usuario = $this->id_usuario";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_user->getAffect(); // retorna todos los registros afectados

    }


    //Funcion para validar que el nombre de usuario (login) no exista
    /*public function availableUser($u){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $obj_user->executeQuery("select * from usuarios where login = '$u'");

        $r=$obj_user->fetchAll();
        if($obj_user->getAffect()==0){
            $output = true;
        }
        else{
            $output = false;
        }
        return $output;
    } */





}


?>