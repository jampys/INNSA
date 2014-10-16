<?php

require_once("../lib/config.php");

/*esta clase debe incluir los metodos para:
 - validar al usuario
 - iniciar sesion
 - cerrar sesion
/*
 *
 *
 */
class Login{

    Var $id;
    var $login;
    var $pass;
    var $tipo;
    var $habilitado;


    function isAValidUser($login,$pass){
        /*
        Esta funcion deberia devolver en un array de la forma $user['habilitado']=1    $user['accesslevel']=xxx    return $user
         */

        $pass=md5($pass);

        $obj_cliente=new sQuery();
        $query="select * from usuarios where login ='$login' and `pass`= '$pass'";
        $obj_cliente->executeQuery($query);


        if ($obj_cliente->getAffect()>=1) //en teoria devuelve la cantidad de filas afectadas. OJO controlar esta funcion
        {
            $user=$obj_cliente->fetchAll(); //OJO controlar esta funcion
            if($user['habilitado']==1)
                return $user['id'];
            else return 0;
        }
        else
        { return -1;
        }
    }


    public function salir()
    {
        session_destroy();
        header("Location: ".Conexion::ruta()."?accion=index");
        exit;
    }




}

?>