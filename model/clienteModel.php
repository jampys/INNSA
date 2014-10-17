<?php

require_once("../lib/configObsoleto.php");

class Cliente
{
    var $nombre;     //se declaran los atributos de la clase, que son los atributos del cliente
    var $apellido;
    var $fecha;
    Var $peso;
    Var $id;

    public static function getClientes()
    {
        $obj_cliente=new sQuery();
        $obj_cliente->executeQuery("select * from clientes"); // ejecuta la consulta para traer al cliente

        return $obj_cliente->fetchAll(); // retorna todos los clientes
    }

    function Cliente($nro=0) // declara el constructor, si trae el numero de cliente lo busca , si no, trae todos los clientes
    {
        if ($nro!=0)
        {
            $obj_cliente=new sQuery();
            $result=$obj_cliente->executeQuery("select * from clientes where id = $nro"); // ejecuta la consulta para traer al cliente
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
        if($this->id)                     //DARIO se refiere a si el atributo id trae algo (es porque el cliente existe) hace un update
        {$this->updateCliente();}         //si viene vacio se trata de un cliente nuevo
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