<?php

// Import Controllers

class Route
{
    #Página inicial
    function abrirInicio()
    {
        include_once "view/paginaInicial.php";
    }

    #Página de login
    function abrirLogin()
    {
        include_once "view/paginaLogin.php";
    }

    #Página não encontrada
    function abrirPaginaNaoEncontrada()
    {
       include_once "view/paginaNaoEncontrada.php";
    }
}
?>