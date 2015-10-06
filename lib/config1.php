<?php
/*colocada provisoriamente para desactivar toda notificacion de error
http://www.lawebdelprogramador.com/foros/PHP/1395996-solucionado-Como-desactivar-los-warning-notice-y-error-de-PHP.html
*/
//error_reporting(0);
//session_start(); //Se mueve esta linea al index.php para evitar errores al migrar el sitio a otro servidor

//Se configura el motor de BD que se usara. ORACLE o MYSQL
define('TIPO_CONEXION', 'ORACLE');
//Se configura la direccion IP del servidor donde se ejecuta la aplicacion
define('SERVIDOR', 'http://localhost/INNSA/');
//define('SERVIDOR', 'http://192.168.1.50/INNSA/');

//Se utiliza el patron FACTORY para configurar el motor de BD a utilizar sin afectar al resto del codigo

abstract class Conexion{

    public static $con;

    public static abstract function getConexion();


    public static function ruta(){
        return SERVIDOR;
    }

    public static function corta_palabra($palabra,$num)
    {
        $largo=strlen($palabra);//indicarme el largo de una cadena
        $cadena=substr($palabra,0,$num);
        return $cadena;
    }

    public static function stringANumber($palabra)
    {
        $numero=str_replace(',', '.', $palabra);
        $numero=(float)$numero;
        $numero=number_format($numero, 2, '.', '');

        return $numero;
    }

}

abstract class sQuery{
    var $coneccion;
    var $consulta;
    //var $resultados;  //DARIO: no lo usa nunca
    abstract function executeQuery($cons);

    public static abstract function hacerCommit();
    public static abstract function hacerRollback();

    public function getResults(){
        return $this->consulta;
    }

    /*public function Close(){
        $this->coneccion->Close();
    }*/

    abstract function clean();
    abstract function close();
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





//****************************************************************************************************************

class ConexionOracle extends Conexion{

    //var $con se hereda

    static function getConexion(){ // devuelve la conexion
        //return $this->con;
        //return parent::getConexion();
        if (!isset(self::$con)) {
            //$c = __CLASS__;
            //self::$con = new $c;


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
                //parent::setConexion($conect);
                self::$con = $conect;
            }


        }
        return self::$con;
    }

    /*function Close(){  // cierra la conexion
        mysql_close($this->con);
    }*/

    //Al metodo ruta() lo hereda




}

//**************************************************************************************

class sQueryOracle extends sQuery   // se declara una clase para poder ejecutar las consultas, esta clase llama a la clase anterior
{
    //var $coneccion; //se hereda
    //var $consulta;  //se hereda
    //var $resultados;  //se hereda

    function __construct()  { //se sobreescribe ...funciona ok
        //$a= new ConexionOracle();
        //$this->coneccion=new ConexionOracle();
        //$this->coneccion=$a->getConexion();
        $this->coneccion=ConexionOracle::getConexion(); //no es necesario crear una instancia por ser el metodo statico
        //echo 'se ejecuto el constructor de la clase sQueryOracle';
    }


    function executeQuery($cons)  // se sobreescribe........funciona ok
    {
        $this->consulta=oci_parse($this->coneccion, $cons);
        oci_execute($this->consulta, OCI_DEFAULT); //para que no haga los commit de manera automatica
        //return $this->consulta; //no es necesario que la devuelva
    }


    //Al metodo getResults() lo hereda

    //Al metodo Close() lo hereda

    function clean(){ // libera la consulta
        oci_free_statement($this->consulta);
    }

    function close(){
        //oci_close($this->coneccion);
        oci_close(ConexionOracle::getConexion());
    }


    //AGREGADA DARIO ULTIMO MOMENTO
    /*function cerrarConexion(){
        $this->coneccion->Close();
    }*/

    //-------------------------------


    function getAffect() // devuelve las cantidad de filas afectadas
    {
        /*OJO!!! Al usarlo con un SELECT primero debe hacerse un fetch_array. Esta informacion la aclara el manual del metodo
        Si no se hace el fetch array antes, devuelve 0. Con INSERT, UPDATE y DELETE si devuelve las filas afectadas y false en caso de error */
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
        //$this->clean(); //Agregado 30/04/15 para liberar la consulta!!

        return $rows;
    }


    public static function hacerCommit(){
        oci_commit(ConexionOracle::getConexion());
        self::close();
    }

    public static function hacerRollback(){
        oci_rollback(ConexionOracle::getConexion());
        self::close();
    }





    /* METODOS CREADOS PARA PODER TRABAJAR LAS CONSULTAS CON bind */

    function dpParse($cons){
        $this->consulta=oci_parse($this->coneccion, $cons);
        return $this->consulta; //no es necesario que la devuelva
    }

    function dpExecute(){
        oci_execute($this->consulta, OCI_DEFAULT);
    }

    function dpBind($a, $b){
        return oci_bind_by_name($this->consulta, $a, $b);
    }

    /*function dpBindLarge($a, $b, $c, $d){
        return oci_bind_by_name($this->consulta, $a, $b, $c, $d);

    }*/


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