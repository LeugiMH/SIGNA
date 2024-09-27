<?php

// Import Controllers
include_once "especie.php";
include_once "especime.php";

class Route
{
    #Página inicial
    function abrirInicio()
    {
        $especimes = new EspecimeController();
        $especimes = $especimes->listar();
        if(isset($_SESSION["sessaoLogada"])) 
        {include_once "view/paginaInicialADM.php";}
        else 
        {include_once "view/paginaInicial.php";}
    }
    function abrirExibirEspecime($id)
    {
        $especimes = new EspecimeController();
        $especimes = $especimes->buscar($id);
        include_once "view/paginaExibePlanta.php";
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

    function abrirCadastroEspecie()
    {
        include_once "view/paginaCadAltEspecie.php";
    }

    function abrirAlteraEspecie($id)
    {
        $especie = new EspecieController();
        $especie = $especie->buscar($id);
        include_once "view/paginaCadAltEspecie.php";
    }
    
    /* Espécimes */
    function abrirCadastroEspecime()
    {
        $especies = new EspecieController();
        $especies = $especies->listar();
        include_once "view/paginaCadAltEspecime.php";
    }
    function abrirAlteraEspecime($id)
    {
        $especies = new EspecieController();
        $especies = $especies->listar();
        $especime = new EspecimeController();
        $especime = $especime->buscar($id);
        include_once "view/paginaCadAltEspecime.php";
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