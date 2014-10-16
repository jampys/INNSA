<?php
session_start();


class Conexion  {// se declara una clase para hacer la conexion con la base de datos

    var $con;

    function __construct(){
        // se definen los datos del servidor de base de datos
        $conection['server']="localhost";  //host
        $conection['user']="root";         //  usuario
        $conection['pass']="admin";             //password
        $conection['base']="INNSADB";           //base de datos

        // crea la conexion pasandole el servidor , usuario y clave
        $conect= mysql_connect($conection['server'],$conection['user'],$conection['pass']);

        if ($conect) {// si la conexion fue exitosa , selecciona la base
            mysql_select_db($conection['base']);
            $this->con=$conect;
        }

    }


    function getConexion(){ // devuelve la conexion
        return $this->con;
    }

    function Close(){  // cierra la conexion
        mysql_close($this->con);
    }

    public static function ruta(){
        return "http://localhost/innsa/";
    }

}


class sQuery   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
{
    var $coneccion;
    var $consulta;
    var $resultados;  //DARIO: no lo usa nunca

    function __construct()  // constructor, solo crea una conexion usando la clase "Conexion"
    {
        $this->coneccion= new Conexion();
    }
    function executeQuery($cons)  // metodo que ejecuta una consulta y la guarda en el atributo $pconsulta
    {
        $this->consulta= mysql_query($cons,$this->coneccion->getConexion());
        return $this->consulta;
    }

    function getResults()   // retorna la consulta en forma de result.
    {return $this->consulta;}

    function Close()		// cierra la conexion
    {$this->coneccion->Close();}

    function Clean() // libera la consulta
    {mysql_free_result($this->consulta);}

    function getResultados() // debuelve la cantidad de registros encontrados
    {return mysql_affected_rows($this->coneccion->getConexion()) ;}

    function getAffect() // devuelve las cantidad de filas afectadas     //DARIO: este metodo es igual al de arriba
    {return mysql_affected_rows($this->coneccion->getConexion()) ;}


    function fetchAll(){
        $rows=array();
        if ($this->consulta)
        {
            while($row=  mysql_fetch_array($this->consulta))
            {
                $rows[]=$row;
            }
        }
        return $rows;
    }
}

//****************************************************************************************************************

class ConexionOracle extends Conexion{

    //var $con se hereda

    function __construct() {

        $conection['server']="localhost";  //host
        $conection['user']="dario";         //  usuario
        $conection['pass']="dario";             //password
        $conection['base']="INNSADB";           //base de datos

        $conect = oci_connect($conection['user'], $conection['pass'], $conection['server']);
        //conexion oracle
        if (!$conect) {
            $m = oci_error();
            echo $m['message'], "\n";
            exit;
        } else {
            echo "Conexión con éxito a Oracle!";
            $this->con=$conect;
        }

    }

   //function getConexion() se hereda y no se modifica

    function Close(){  // se redefine
        oci_close($this->$con);
    }

    //public static function ruta() se hereda y no se modifica

}

//**************************************************************************************

class sQueryOracle extends sQuery   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
{
    //var $coneccion; //se hereda
    //var $consulta;  //se hereda
    //var $resultados;  //se hereda

    function __construct()  { //se sobreescribe ...funciona ok
        //$c= new ConexionOracle();
        $this->coneccion=new ConexionOracle();
        echo 'se ejecuto el constructor de la clase sQueryOracle';
    }


    function executeQuery($cons)  // se sobreescribe........funciona ok
    {
        $this->consulta=oci_parse($this->coneccion->getConexion(), $cons);
        oci_execute($this->consulta);
        return $this->consulta;
    }

    //getResults() no se sobreescribe

   //Close()    no se sobrescribe

    function Clean() // libera la consulta
    {oci_free_statement($this->consulta);}


    function getResultados() // debuelve la cantidad de registros encontrados
    {
        //return oci_num_rows($this->coneccion->getConexion()) ;}
        return oci_num_rows($this->consulta);}

    function getAffect() // devuelve las cantidad de filas afectadas     //DARIO: este metodo es igual al de arriba
    {return oci_num_rows($this->consulta);}


    //esta devuelve todos los registros en un array..... se debe sobreescribir
    //esta funcion devuelve un array de 2 dimensiones con los resultados de la consulta
    function fetchAll()
    {
        $rows=array();
        if ($this->consulta)
        {
            //la funcion oci_fetch_array devuelve cada fila de la consulta en forma de array
            while($row = oci_fetch_array($this->consulta, OCI_ASSOC))
            {   //luego cada fila (como un array) se agrega a otro array... creando un array de 2 dimsnesiones
                $rows[]=$row;
            }
        }
        return $rows;
    }


}

?>