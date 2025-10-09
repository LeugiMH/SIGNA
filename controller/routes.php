<?php

// Import Controllers
include_once "admin.php";
include_once "especie.php";
include_once "especime.php";
include_once "assunto.php";
include_once "atributo.php";
include_once "acesso.php";
include_once "feedback.php";
include_once "manejo.php";


class Route
{
    
    #Página inicial
    function abrirInicio()
    {
        if(isset($_SESSION["sessaoLogada"])) 
        {
            $especies = new EspecieController();
            $especies = $especies->listarAdm();
            $especimes = new EspecimeController();
            $especimes = $especimes->listarAdm();
            $assuntos = new AssuntoController();
            $assuntos = $assuntos->listar();
            $feedbacks = new FeedbackController();
            $feedbacks = $feedbacks->listar();
            include_once "view/paginaInicialADM.php";
        }
        else 
        {
            $especies = new EspecieController();
            $especies = $especies->listarUsu();
            $especimes = new EspecimeController();
            $especimes = $especimes->listarUsu();
            include_once "view/paginaInicial.php";
        }
    }

    #Página de login
    function abrirLogin()
    {  
        include_once "view/paginaLogin.php";
    }
    #Página de recuperação de senha
    function abrirRecuperacaoSenha()
    {  
        include_once "view/paginaRecuperarSenha.php";
    }
    #Página inserir código de recuperação
    function abrirCodigoRecuperacaoSenha($idadmin)
    {   
        include_once "view/paginaCodigoRecuperacaoSenha.php";
    }
    #Página de redefinição de senha
    function abrirRedefinirSenha($idadmin)
    {  
        if ($_SESSION["PermissaoRedefinirSenha"] == true)
        {
            include_once "view/paginaRedefinirSenha.php";
            $_SESSION["PermissaoRedefinirSenha"] = false;
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Você não tem permissão para alterar a senha ou sua permissão expirou.</div>",time() + 1,"/");
            header("Location:".URL."login");
        }
    }

    function abrirExibirEspecime($idEspecime)
    {
        // Cadastra um acesso para o espécime
        $acesso = new AcessoController();
        $acesso->cadastrarAcesso($idEspecime);

        $planta = new EspecimeController();
        $planta = $planta->buscarTudo($idEspecime);
        $atributos = new EspecieController();
        $atributos = $atributos->buscarAtrAssoc($planta->IDESPECIE);
        $manejos = new ManejoController();
        $manejos = $manejos->ultimoDoTipo($idEspecime);
        include_once "view/paginaExibePlanta.php";
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
        $atributos = new AtributoController();
        $atributos = $atributos->listar();
        include_once "view/paginaCadAltEspecie.php";
    }

    function abrirAlteraEspecie($id)
    {
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
        $admins = new AdminController();
        $admins = $admins->listar();
        include_once "view/listaAdmin.php";
    }

    function abrirCadastroAdmin()
    {
        include_once "view/paginaCadAltAdmin.php";
    }

    function abrirAlteraAdmin($id)
    {
        $admin = new AdminController();
        $admin = $admin->buscar($id);
        include_once "view/paginaCadAltAdmin.php";
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
        include_once "view/paginaEmail.php";
    }
}
?>
