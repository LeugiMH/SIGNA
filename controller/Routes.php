<?php

// Import Controllers
include_once "especie.php";
include_once "especime.php";
include_once "especime.php";
include_once "assunto.php";

class Route
{
    #Página inicial
    function abrirInicio()
    {
        if(isset($_SESSION["sessaoLogada"])) 
        {
            $especimes = new EspecimeController();
            $especimes = $especimes->listarAdm();
            //$especimes->DATPLANT = date("d/m",strtotime($especimes->DATPLANT));
            include_once "view/paginaInicialADM.php";
        }
        else 
        {
            $especimes = new EspecimeController();
            $especimes = $especimes->listarUsu();
            //$especimes->DATPLANT = date("d/m/Y",strtotime($especimes->DATPLANT));
            include_once "view/paginaInicial.php";
        }
    }
    function abrirExibirEspecime($id)
    {
        $planta = new EspecimeController();
        $planta = $planta->buscarTudo($id);
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

    /* Assuntos */
    #Lista
    function abrirListaAssunto()
    {
        $assuntos = new AssuntoController();
        $assuntos = $assuntos->listar();
        include_once "view/listaAssuntos.php";
    }
    function abrirCadastroAssunto()
    {
        include_once "view/paginaCadAltAssunto.php";
    }
    function abrirAlteraAssunto($id)
    {
        $assunto = new AssuntoController();
        $assunto = $assunto->buscar($id);
        include_once "view/paginaCadAltAssunto.php";
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