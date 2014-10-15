<?php

require_once("../lib/config.php");

class User
{
    Var $id;
    var $login;     //se declaran los atributos de la clase, que son los atributos del usuario
    var $pass;
    var $tipo;
    var $habilitado;


    public static function getUsuarios(){
        $obj_user=new sQuery();
        $obj_user->executeQuery("select * from usuarios"); // ejecuta la consulta para traer al cliente

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
    function getID()
    { return $this->id;}
    function getNombre()
    { return $this->nombre;}
    function getApellido()
    { return $this->apellido;}
    function getFecha()
    { return $this->fecha;}
    function getPeso()
    { return $this->peso;}

    // metodos que setean los valores
    function setNombre($val)
    { $this->nombre=$val;}
    function setApellido($val)
    {  $this->apellido=$val;}
    function setFecha($val)
    {  $this->fecha=$val;}
    function setPeso($val)
    {  $this->peso=$val;}

    function save(){
        if($this->id)
        {$this->updateCliente();}
        else
        {$this->insertCliente();}
    }

    private function updateCliente()	// actualiza el cliente cargado en los atributos
    {
        $obj_cliente=new sQuery();
        $query="update clientes set nombre='$this->nombre', apellido='$this->apellido',fecha_nac='$this->fecha',peso='$this->peso' where id = $this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

    private function insertCliente()	// inserta el cliente cargado en los atributos
    {
        $obj_cliente=new sQuery();
        $query="insert into clientes( nombre, apellido, fecha_nac,peso)values('$this->nombre', '$this->apellido','$this->fecha','$this->peso')";

        $obj_cliente->executeQuery($query); // ejecuta la consulta para traer al cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }
    function delete()	// elimina el cliente
    {
        $obj_cliente=new sQuery();
        $query="delete from clientes where id=$this->id";
        $obj_cliente->executeQuery($query); // ejecuta la consulta para  borrar el cliente
        return $obj_cliente->getAffect(); // retorna todos los registros afectados

    }

}


?>