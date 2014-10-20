<?php

require_once("lib/config.php");
//require_once("lib/Conection.php");

if(isset($_SESSION["ses_id"])){

    if(!empty($_GET["accion"])){
        $accion=$_GET["accion"];
    }else
    {
        //$accion="index";
    }

    if(is_file("controller/".$accion."Controller.php")){
        require_once("controller/".$accion."Controller.php");
    }else
    {
        require_once("controller/errorController.php");
    }


}else
{
    //modificado Dario
    if($_GET["accion"]=="error"){
        require_once("controller/errorController.php");
    }
    else{
        require_once("controller/loginController.php");
    }

}

require_once("view/layout.php");


?>