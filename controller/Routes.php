<?php

// Import models


class Route
{
    #Página inicial
    function abrirInicio()
    {
        include_once "view/PaginaInicial.php";
    }

    #Página de testes
    function abrirTeste()
    {
        include_once "view/paginaTeste.php";
    }

    #Página não encontrada
    function abrirPaginaNaoEncontrada()
    {
       include_once "view/paginaNaoEncontrada.php";
    }

    #Teste mapa
    function testeMaps()
    {
       include_once "testeCoordenadas.php";
    }
}

?>