<?php
//CONTROLE DA NAVBAR
if(isset($_SESSION["dadosLogin"])) //caso esteja logado
{
    include_once "navbarAdm.php"
}
//caso não esteja logado
else
{
    include_once "navbarUser.php";
}
?>