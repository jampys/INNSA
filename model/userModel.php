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
        //$obj_user->executeQuery("select * from usuarios"); // ejecuta la consulta para traer al cliente
        $obj_user->executeQuery("select * from usuarios, perfiles where usuarios.id_perfil=perfiles.id_perfil");
        return $obj_user->fetchAll(); // retorna todos los clientes
    }

    public function getUsuarioById($id){
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$obj_user->executeQuery("select * from usuarios where id_usuario=$id");
        $obj_user->executeQuery("select * from usuarios, perfiles where usuarios.id_perfil = perfiles.id_perfil and id_usuario=$id");
        return $obj_user->fetchAll(); // retorna todos los clientes
    }



    function User($nro=0) // declara el constructor, si trae el numero de cliente lo busca , si no, trae todos los clientes
    {
        if ($nro!=0)
        {
            $obj_user=new sQuery();
            $result=$obj_user->executeQuery("select * from usuarios where id = $nro"); // ejecuta la consulta para traer al cliente
            $row=mysql_fetch_array($result);
            $this->id=$row['id'];
            $this->nombre=$row['nombre'];
            $this->apellido=$row['apellido'];
            $this->fecha=$row['fecha_nac'];
            $this->peso=$row['peso'];

            /*//DARIO: OJO para una buena separacion en capas no deberia estar el llamado al metodo de mysql fetch array, sino utilizar
            directamente un metodo de la clase sQuery, dado que cuando cambie a una conexion ORACLE esta parte va a fallar
             *
             *
             *  */
        }
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

    function setHabilitado($val)
    {  $this->habilitado=$val;}




    public function updateUsuario()	// actualiza el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        $query="update usuarios set login='$this->login', password='$this->password', id_perfil=$this->id_perfil, habilitado=$this->habilitado where id_usuario = $this->id_usuario   ";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    public function insertUsuario()	// inserta el cliente cargado en los atributos
    {
        $f=new Factory();
        $obj_user=$f->returnsQuery();
        //$query="insert into usuarios(id_usuario, login, password, fecha_alta, id_perfil, habilitado) values(7, '$this->login', '$this->password', TO_DATE('$this->fecha_alta','DD/MM/YYYY'), $this->id_perfil , 1)";
        $query="insert into usuarios(login, password, fecha_alta, id_perfil, habilitado)".
        "values('$this->login', '$this->password', TO_DATE('$this->fecha_alta','DD/MM/YYYY'), $this->id_perfil , $this->habilitado)";
        $obj_user->executeQuery($query); // ejecuta la consulta para traer al cliente
        //return $obj_user->getAffect(); // retorna todos los registros afectados

    }
    function delete()	// elimina el cliente
    {
        $obj_cliente=new sQuery();
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