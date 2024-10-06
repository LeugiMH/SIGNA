<?php
session_start();

    //Import de controllers
    include_once "controller/routes.php";
    include_once "controller/admin.php";


//Definindo fuso horário default
date_default_timezone_set("America/Sao_Paulo");

//Definindo uma constante para a URL do site
define("URL","http://localhost/SIGNA/");
if($_GET)
{
    //Pegando a URL e apagando a "/" no final dela.
    $url = $_GET["url"];
    $url = explode("/",$url);
    
    //Definindo os nomes das telas que vão aparecer na URL
    switch($url[0])
    {   
        // PÁGINA INICIAL
        case "inicio":
            $route = new Route();
            $route->abrirInicio();
        break;

        // LOGIN 
        case "login": 
            $route = new Route();
            $route->abrirLogin();
        break;
        
        case "logar": 
            $route = new AdminController();
            $route->logar();
        break;

        // FUNÇÕES ESPÉCIE
        case "especies":
            switch($url[1])
            {
                case "lista":
                    $route = new Route();
                    $route->abrirListaEspecie();
                break;
                case "cadastro":
                    $route = new Route();
                    $route->abrirCadastroEspecie();
                break;
                case "cadastrar":
                    $route = new EspecieController();
                    $route->cadastrarEspecie();
                break;
                case "altera":
                    $route = new Route();
                    $route->abrirAlteraEspecie($url[2]);
                break;
                case "alterar":
                    $route = new EspecieController();
                    $route->alterarEspecie();
                break;
                case "excluir":
                    $route = new EspecieController();
                    $route->excluirEspecie($url[2]);
                break;
                default:
                    // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
                break;
            }
        break;

        // PÁGINA DA PLANTA
        case "especime":
            $route = new Route();
            $route->abrirExibirEspecime($url[1]);
        break;
        
        // FUNÇÕES ESPÉCIMES
        case "especimes":
            switch($url[1])
            {
                case "cadastro":
                    $route = new Route();
                    $route->abrirCadastroEspecime();
                break;
                case "cadastrar":
                    $route = new EspecimeController();
                    $route->cadastrarEspecime();
                break;
                case "altera":
                    $route = new Route();
                    $route->abrirAlteraEspecime($url[2]);
                break;
                case "alterar":
                    $route = new EspecimeController();
                    $route->alterarEspecime();
                break;
                default:
                    // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
                break;
            }
        break;

        case "iniAdmin":
            $route = new Route();
            $route->abrirInicioAdmin();

        break;
        case "assuntos":
            switch($url[1])
            {
                case "lista":
                    $route = new Route();
                    $route->abrirListaAssunto();
                break;
                case "cadastro":
                    $route = new Route();
                    $route->abrirCadastroAssunto();
                break;
                case "cadastrar":
                    $route = new AssuntoController();
                    $route->cadastrarAssunto();
                break;
                case "altera":
                    $route = new Route();
                    $route->abrirAlteraAssunto($url[2]);
                break;
                case "alterar":
                    $route = new AssuntoController();
                    $route->alterarAssunto();
                break;
                case "excluir":
                    $route = new AssuntoController();
                    $route->excluirAssunto($url[2]);
                break;
                default:
                    // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
                break;
            }
        break;
        /*
        case "esqueci-a-senha": 
            $route = new Controller();
            $route->abrirEsqSenha();
        break;
        case "recuperar-senha":
            $route = new UsuarioController();
            $route->recuperarSenha();
        break;
        case "codigo-de-recuperacao":
            $route = new Controller();
            $route->abrirRecuperacao($url[1]);
        break;
        case "confirmar-recuperacao":
            $route = new UsuarioController();
            $route->confirmarCodigo();
        break;
        case "redefinir-senha":
            $route = new UsuarioController();
            $route->redefinirSenha();
        break;

        // USUÁRIO
        case "home-usuario":
            $route = new Controller();
            $route->abrirHomeUsuario();
        break;
        case "perfil":
            $route = new Controller();
            $route->abrirPerfil();
        break;
        case "alterar-senha":
            $route = new Controller();
            $route->abrirAlterarSenha($url[1]);
        break;
        */  

        // LOGOFF
        case "sair":
            $route = new AdminController();
            $route->sair();
        break;
        
        case "tst":
            $route = new Route();
            $route->abrirTeste();
        break;

        case "tst2":
            $route = new Route();
            $route->abrirTeste2();
        break;

        default:
            // URL INVÁLIDA
            $route = new Route();
            $route->abrirPaginaNaoEncontrada();
    }
}
else
{
    //ABRIR PÁGINA INICIAL
    $route = new Route();
    $route->abrirInicio();
}
?>