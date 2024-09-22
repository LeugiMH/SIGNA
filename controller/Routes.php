<?php

// Import Controllers
include_once "especie.php";
include_once "especime.php";

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

    function abrirListaEspecie()
    {
        $especies = new EspecieController();
        $especies = $especies->listar();
        include_once "view/listaEspecie.php";
    }

    function abrirInicioAdmin()
    {
        $plantas = new EspecimeController();
        $plantas = $plantas->listar();
        include_once "view/PaginaIniAdmin.php";
    }

    /*  */
    #Página não encontrada
    function abrirPaginaNaoEncontrada()
    {
       include_once "view/paginaNaoEncontrada.php";
    }

    #Página teste
    function abrirTeste()
    {
        include_once "view/list.php";
    }

    #Página teste
    function abrirTeste2()
    {
        include_once "view/LAYOUTPaginaRolavel.php";
    }
}
?>