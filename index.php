<?php
session_start();

    //Import de controllers
    include_once "controller/routes.php";
    include_once "controller/admin.php";


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
        
        case "especies":
            switch($url[1])
            {
                case "listar":
                    $route = new Route();
                    $route->abrirListaEspecie();
                break;
                default:
                    // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
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