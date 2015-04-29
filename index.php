<?php
session_start();
require_once("lib/config1.php");
//require_once("lib/Conection.php");

if(isset($_SESSION["ses_id"])){

    //if(!empty($_GET["accion"])){
    if(!empty($_REQUEST["accion"])){
        //$accion=$_GET["accion"];
        $accion=$_REQUEST["accion"];
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