<?php

//Se usa request (en vez de get o post) porque al loguearse usa post pero al salir usa get.
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/userModel.php");
$view->u=new User();

switch($operacion){

    case 'login':

        if (isset($_POST['usuario'])&& isset($_POST['password'])){

            $id=$view->u->isAValidUser($_POST['usuario'],$_POST['password']);
            //echo "el id que devuelve luego del logueo es??".$id;

            if($id>=1){
                //$_SESSION["ses_id"]=$id;
                //$_SESSION["user"]=$_POST['usuario'];
                $_SESSION["ses_id"]=$id[0];
                $_SESSION["user"]=$id[1];
                $_SESSION['ACCESSLEVEL']=$id[2];
                //echo $_SESSION['ACCESSLEVEL'];

                //tambien guardar en la sesion el perfil de usuario
                //$_SESSION['accesslevel']= xxxxxxx;

                //header("Location: ".Conexion::ruta()."?accion=index");
                //echo "EL USUARIO SE SE LOGUEO OK";
                //IMPORTANTE: probar mas que un header location cargar una $view->content error
                //Por el momento no se le carga ninguna vista para cuando ingresa ok.
            }
            else
            {
                //echo "EL USUARIO NO SE PUDO LOGUEAR";
                if($id=0){
                    $_SESSION["error"]="USUARIO DESHABILITADO";
                    //header("Location: ".Conexion::ruta()."?accion=error");
                    $view->content="view/error.phtml";
                }
                if($id=-1){
                    $_SESSION["error"]="DISCULPE, USUARIO O CONSTRASEÑA INVALIDOS";
                    //header("Location: ".Conexion::ruta()."?accion=error");
                    $view->content="view/error.phtml";
                }
            }

        }

        break;

    case 'salir':
        $view->u->salir();
        //$view->content="view/login.php";
        header("Location: index.php");
        break;

    default:
        $view->content="view/login.php";
        break;


}







?>