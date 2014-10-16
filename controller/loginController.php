<?php

//suponiendo que los datos vienen por post

if (isset($_POST['stage']) && 'validaUsuario' == $_POST['stage']&& isset($_POST['USUARIO'])&& isset($_POST['PASWORD'])){

    require_once("model/userModel.php");

    $u=new Login();
    $id=$u->isAValidUser($_POST['USUARIO'],$_POST['PASWORD']);


    if($id>=1){
        $_SESSION["ses_id"]=$id;
        $_SESSION["foto"]=$_POST["USUARIO"]; //ver si se va a usar foto o no
        //tambien guardar en la sesion el perfil de usuario
        //$_SESSION['accesslevel']= xxxxxxx;

        header("Location: ".Conexion::ruta()."?accion=index");
    }
    else
    {
        if($id=0){
            $_SESSION["error"]="USUARIO DESHABILITADO";
            header("Location: ".Conexion::ruta()."?accion=error");
        }
        if($id=-1){
            $_SESSION["error"]="DISCULPE, USUARIO O CONSTRASEÑA INVALIDOS";
            header("Location: ".Conexion::ruta()."?accion=error");
        }
    }

}




?>