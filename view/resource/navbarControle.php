<?php
//CONTROLE DA NAVBAR
if(isset($_SESSION["dadosLogin"])) //caso esteja logado e exista uma sessão
{
    switch($_SESSION["dadosLogin"]->nivelacesso)
    {
        //caso tenha nível de acesso de usuário
        case 0: include_once "navbarUser.php"; break;
        //caso tenha nível de acesso de Administrador
        case 2: include_once "navbarAdm.php"; break;
    }
}
else{ include_once "navbarUser.php"; }
?>