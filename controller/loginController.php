<?php

//Se usa request (en vez de get o post) porque al loguearse usa post pero al salir usa get.
if(isset($_REQUEST['operacion']))
{$operacion=$_REQUEST['operacion'];}

require_once("model/userModel.php");
require_once("model/empleadoModel.php");
$view->u=new User();

switch($operacion){

    case 'login':

        if (isset($_POST['usuario'])&& isset($_POST['password'])){

            $id=$view->u->isAValidUser($_POST['usuario'],$_POST['password']);
            //echo "el id que devuelve luego del logueo es??".$id;

            if($id>=1){
                //$_SESSION["ses_id"]=$id;
                //$_SESSION["user"]=$_POST['usuario'];
                if($id[5]!=1) { //si se ha limpiado el password  hay que cambiarlo...
                    $_SESSION["ses_id"] = $id[0];
                    $_SESSION["user"] = $id[1];
                    $_SESSION['ACCESSLEVEL'] = $id[2];
                    $_SESSION['USER_APELLIDO'] = $id[3];
                    $_SESSION['USER_NOMBRE'] = $id[4];
                    $_SESSION['USER_ID_EMPLEADO'] = $id[6];
                }
                else{
                    $view->id_usuario = (int)$id[0];
                    $view->content="view/login_clear_pass.php";
                }


                //header("Location: ".Conexion::ruta()."?accion=index");
                //echo "EL USUARIO SE SE LOGUEO OK";
                //IMPORTANTE: probar mas que un header location cargar una $view->content error
                //Por el momento no se le carga ninguna vista para cuando ingresa ok.
            }
            else
            {
                //echo "EL USUARIO NO SE PUDO LOGUEAR";
                if($id==0){
                    $_SESSION["error"]="Usuario inhabilitado";
                    //header("Location: ".Conexion::ruta()."?accion=error");
                    $view->content="view/error.php";
                }
                if($id==-1){
                    $_SESSION["error"]="Usuario o contraseña inválidos";
                    //header("Location: ".Conexion::ruta()."?accion=error");
                    $view->content="view/error.php";
                }
            }

        }

        break;



    case 'clear_pass':
        $view->u->setIdUsuario($_POST['id_usuario']);
        $view->u->setPassword($_POST['password']);
        $view->u->setClearPass(0);

        $rta=$view->u->updatePassword();

        header("Location: index.php");
        break;


    case 'clear_pass_first':

        $view->u->setIdUsuario($_POST['id_usuario']);
        $view->u->setClearPass(1);
        $pass = substr( md5(microtime()), 1, 8); //genero un password aleatorio de 8 caracteres
        $view->u->setPassword($pass);
        $view->u->updatePassword();

        $usuario=$view->u->getUsuarioById($_POST['id_usuario']);
        $id_empleado=$usuario[0]['ID_EMPLEADO'];


        //***********************EMAIL**********************************
        //Obtener datos para enviar el mail
        $view->e=new Empleado();
        $emp=$view->e->getEmpleadoById($id_empleado); //id_empleado

        if(!$emp){ //Si la consulta SQL no devuelve ningun registro
            $respuesta = array ('response'=>'error','comment'=>'Problemas con la consulta SQL');
        }
        else{ //si la consulta SQL devuelve 1 registro

            //codigo para el envio de e-mail
            $para=$emp[0]['EMAIL'];
            $asunto = 'INNSA - Blanqueo de clave de acceso';
            $body_usuario=$usuario[0]['LOGIN'];
            $body_pass=$pass;

            //codigo para incluir en la variable $mensaje el template de correo de la comunicacion, que se encuentra en email/comunicacion.php
            ob_start();
            include ('email/password.php');
            $mensaje= ob_get_contents();
            ob_get_clean();

            //Cabecera que especifica que es un HMTL
            $headers = 'From: INNSA Capacitacion <no-reply@innsa.com>' . "\r\n";
            $headers.= 'MIME-Version: 1.0' . "\r\n";
            $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            if(mail($para, utf8_decode($asunto), $mensaje, $headers)){ //Si envia email (por mas que la direccion sea incorrecta y lo rebote)

                $respuesta = array ('response'=>'success','comment'=>'Password enviado correctamente');

            }
            else{ //No pudo enviar el e-mail
                $respuesta = array ('response'=>'error','comment'=>'Error al enviar el nuevo password');
            }

        }
        //------------------FIN EMAIL----------------------------------------

        print_r(json_encode($respuesta));
        exit;
        break;



    case 'salir':
        $view->u->salir();
        //$view->content="view/login.php";
        //header("Location: index.php");
        //para evitar los tipicos errores del header location =>lo hago con javascript
        echo "<script>window.location='index.php';</script>";
        break;

    default:
        $view->content="view/login.php";
        break;


}


?>

