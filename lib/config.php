<?php
//session_start(); //Se mueve esta linea al index.php para evitar errores al migrar el sitio a otro servidor

//Se configura el motor de BD que se usara. ORACLE o MYSQL
define('TIPO_CONEXION', 'ORACLE');
//Se configura la direccion IP del servidor donde se ejecuta la aplicacion
define('SERVIDOR', 'http://localhost/INNSA/');
//define('SERVIDOR', 'http://192.168.1.50/INNSA/');

//Se utiliza el patron FACTORY para configurar el motor de BD a utilizar sin afectar al resto del codigo

abstract class Conexion{
    var $con;
    abstract function getConexion();
    abstract function Close();

    public static function ruta(){
        return SERVIDOR;
    }

    public static function corta_palabra($palabra,$num)
    {
        $largo=strlen($palabra);//indicarme el largo de una cadena
        $cadena=substr($palabra,0,$num);
        return $cadena;
    }
}

abstract class sQuery{
    var $coneccion;
    var $consulta;
    var $resultados;  //DARIO: no lo usa nunca
    abstract function executeQuery($cons);

    public function getResults(){
        return $this->consulta;
    }

    public function Close(){
        $this->coneccion->Close();
    }
    abstract function Clean();
    //abstract function getResultados();
    abstract function getAffect();
    abstract function fetchAll();
}


class Factory{
    var $q;

    public function __construct(){
        switch(TIPO_CONEXION){
            case 'ORACLE':
                $this->q=new sQueryOracle();
                break;
            case 'MYSQL':
                $this->q=new sQueryMYSQL();
                break;
            default:
                $this->q=new sQueryOracle();
        }
    }

    public function returnsQuery(){
        return $this->q;
    }
}



class ConexionMYSQL extends Conexion  {// se declara una clase para hacer la conexion con la base de datos

    //hereda $con

    function __construct(){
        // se definen los datos del servidor de base de datos
        $conection['server']="localhost";  //host
        $conection['user']="root";         //  usuario
        $conection['pass']="admin";             //password
        $conection['base']="INNSADB";           //base de datos

        // crea la conexion pasandole el servidor , usuario y clave
        $conect= mysql_connect($conection['server'],$conection['user'],$conection['pass']);
        mysql_set_charset('utf8',$conect);

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

    //Al metodo ruta() lo hereda

}


class sQueryMYSQL extends sQuery   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
{
    //hereda los atributos
    //var $coneccion;
    //var $consulta;
    //var $resultados;  //DARIO: no lo usa nunca

    function __construct()  // constructor, solo crea una conexion usando la clase "Conexion"
    {
        $this->coneccion= new ConexionMYSQL();
    }
    function executeQuery($cons)  // metodo que ejecuta una consulta y la guarda en el atributo $pconsulta
    {
        $this->consulta= mysql_query($cons,$this->coneccion->getConexion());
        return $this->consulta;
    }

    //Al metodo getResults() lo hereda

    //Al metodo Close() lo hereda

    function Clean() // libera la consulta
    {mysql_free_result($this->consulta);}


    function getAffect() // devuelve las cantidad de filas afectadas
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

        $conect = oci_connect($conection['user'], $conection['pass'], $conection['server'],'AL32UTF8');
        //el parametro 'AL32UTF8' soluciona todo el tema de los acentos
        if (!$conect) {
            $m = oci_error();
            echo $m['message'], "\n";
            exit;
        } else {
            //echo "Conexión con éxito a Oracle!";
            $this->con=$conect;
        }

    }

    function getConexion(){ // devuelve la conexion
        return $this->con;
    }

    function Close(){  // cierra la conexion
        //mysql_close($this->con);
    }

    //Al metodo ruta() lo hereda


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
        //echo 'se ejecuto el constructor de la clase sQueryOracle';
    }


    function executeQuery($cons)  // se sobreescribe........funciona ok
    {
        $this->consulta=oci_parse($this->coneccion->getConexion(), $cons);
        oci_execute($this->consulta);
        return $this->consulta; //no es necesario que la devuelva
    }


    //Al metodo getResults() lo hereda

    //Al metodo Close() lo hereda

    function Clean() // libera la consulta
    {oci_free_statement($this->consulta);}


    //AGREGADA DARIO ULTIMO MOMENTO
    function cerrarConexion(){
        $this->coneccion->Close();
    }

    //-------------------------------


    function getAffect() // devuelve las cantidad de filas afectadas
    {
        /*OJO!!! Al usarlo con un SELECT primero debe hacerse un fetch_array. Esta informacion la aclara el manual del metodo
        Si no se hace el fetch array antes, devuelve 0. Con INSERT, UPDATE y DELETE si devuelve las filas afectadas. */
        return oci_num_rows($this->consulta);
    }


    //esta devuelve todos los registros en un array..... se debe sobreescribir
    //esta funcion devuelve un array de 2 dimensiones con los resultados de la consulta
    function fetchAll()
    {
        $rows=array();
        if ($this->consulta)
        {
            //la funcion oci_fetch_array devuelve cada fila de la consulta en forma de array
            while($row = oci_fetch_array($this->consulta, OCI_BOTH))
            {   //luego cada fila (como un array) se agrega a otro array... creando un array de 2 dimsnesiones
                $rows[]=$row;
            }
        }
        return $rows;
    }



    /* METODOS CREADOS PARA PODER TRABAJAR LAS CONSULTAS CON bind */

    function dpParse($cons){
        $this->consulta=oci_parse($this->coneccion->getConexion(), $cons);
        //return $this->consulta; //no es necesario que la devuelva
    }

    function dpExecute(){
        oci_execute($this->consulta);
    }

    function dpBind($a, $b){
        oci_bind_by_name($this->consulta, $a, $b);
    }


}


//SE CREA UNA CLASE ESTANDAR PHP
$view= new stdClass();



//******************************************* CONEXION PDO ********************************************************

class ConexionPDO{

    private $conn;



    public function __construct()
    {


        $tns = "
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = XE)
    )
  )
       ";
        $db_username = "dario";
        $db_password = "dario";
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            echo 'conexion exitosa';
        }catch(PDOException $e){
            echo ($e->getMessage());
        }


    }

    public function getConexion(){
        return $this->conn;
    }




}



?>