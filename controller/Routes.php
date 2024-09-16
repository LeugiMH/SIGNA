<?php

// Import Controllers
include_once "especie.php";

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

    /* Espécies */
    #Lista
    function abrirListaEspecie()
    {
        $especies = new EspecieController();
        $especies = $especies->listar();
        include_once "view/listaEspecie.php";
    }
    function abrirALteraEspecie($id)
    {
        var_dump($id);
        include_once "view/";
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
    function abrirCadastroEstagio()
    {
        include_once "view/paginaCadastraEspecie.php";
    }
}
?>