<?php

// Import Controllers
include_once "admin.php";
include_once "especie.php";
include_once "especime.php";
include_once "assunto.php";
include_once "atributo.php";

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

    #Página de login
    function abrirLogin()
    {
        include_once "view/paginaLogin.php";
    }

    #Valida login
    function validaLogin()
    {
        //Caso o usuário esteja logado, retorna verdadeiro, caso contrário o usuário é direcionado para a página de login
        if(isset($_SESSION['sessaoLogada']))
        {
            return true;
        }
        else
        {
            header("Location:".URL."login"); 
            return false;
        }
    }

    function abrirExibirEspecime($id)
    {
        $planta = new EspecimeController();
        $planta = $planta->buscarTudo($id);
        include_once "view/paginaExibePlanta.php";
    }
    
    /* Espécies */
    #Lista
    function abrirListaEspecie()
    {
        $this->validaLogin();

        $especies = new EspecieController();
        $especies = $especies->listar();
        include_once "view/listaEspecie.php";
    }

    function abrirCadastroEspecie()
    {
        $this->validaLogin();

        $atributos = new AtributoController();
        $atributos = $atributos->listar();
        include_once "view/paginaCadAltEspecie.php";
    }

    function abrirAlteraEspecie($id)
    {
        $this->validaLogin();

        $especie = new EspecieController();
        $especie = $especie->buscar($id);
        $atributos = new AtributoController();
        $atributos = $atributos->listar($id);
        include_once "view/paginaCadAltEspecie.php";
    }

    /* Admins */
    #Lista
    function abrirListaAdmin()
    {
        $this->validaLogin();

        $admins = new AdminController();
        $admins = $admins->listar();
        include_once "view/listaAdmin.php";
    }

    function abrirCadastroAdmin()
    {
        $this->validaLogin();

        include_once "view/paginaCadAltAdmin.php";
    }

    function abrirAlteraAdmin($id)
    {
        $this->validaLogin();

        $admin = new AdminController();
        $admin = $admin->buscar($id);
        include_once "view/paginaCadAltAdmin.php";
    }
    
    /* Espécimes */
    function abrirCadastroEspecime()
    {
        $this->validaLogin();

        $especies = new EspecieController();
        $especies = $especies->listar();
        include_once "view/paginaCadAltEspecime.php";
    }
    function abrirAlteraEspecime($id)
    {
        $this->validaLogin();

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
        $this->validaLogin();

        $assuntos = new AssuntoController();
        $assuntos = $assuntos->listar();
        include_once "view/listaAssuntos.php";
    }
    function abrirCadastroAssunto()
    {
        $this->validaLogin();

        include_once "view/paginaCadAltAssunto.php";
    }
    function abrirAlteraAssunto($id)
    {
        $this->validaLogin();

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