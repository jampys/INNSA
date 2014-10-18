<?php


require_once("model/userModel.php");
$view->u=new User();

$view->usuarios=$view->u->getUsuarios();
$view->content="view/user.php";


?>