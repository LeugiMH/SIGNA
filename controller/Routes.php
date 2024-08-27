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

    function abrirListaEspecie()
    {
        $especies = new EspecieController();
        $especies->listar();
        include_once "view/listaEspecie.php";
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
        include_once "view/LAYOUTPaginaFixa.php";
    }
}
?>