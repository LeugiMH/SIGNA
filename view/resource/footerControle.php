<?php

//CONTROLE DA NAVBAR
if(isset($_SESSION["sessaoLogada"])) //caso esteja logado
{
    include_once "rodapeAdm.php";
}
//caso não esteja logado
else
{
    $assuntos = new AssuntoController();
    $assuntos = $assuntos->listar();
    include_once "rodapeUser.php";
}
?>