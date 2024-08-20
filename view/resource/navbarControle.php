<?php
//CONTROLE DA NAVBAR
if(isset($_SESSION["sessaoLogada"])) //caso esteja logado
{
    include_once "navbarAdm.php";
}
//caso não esteja logado
else
{
    include_once "navbarUser.php";
}
?>