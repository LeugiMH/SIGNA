<?php
session_start();

    //Import de controllers
    include_once "controller/Controller.php";


//Definindo uma constante para a URL do site
define("URL","http://localhost/SIGNA/");
if($_GET)
{
    //Pegando a URL e apagando a "/" no final dela.
    $url = $_GET["url"];
    $url = explode("/",$url);
    
    //Definindo os nomes das telas que vão aparecer na URL
    switch($url[])
    {   
        // PÁGINA INICIAL
        case "inicio":
            $direciona = new Controller();
            $direciona->abrirInicio();
        break;

        // LOGIN 
        case "login": 
            $direciona = new Controller();
            $direciona->abrirLogin();
        break;
        case "logar": 
            $usuario = new UsuarioController();
            $usuario->logar();
        break;
        case "esqueci-a-senha": 
            $direciona = new Controller();
            $direciona->abrirEsqSenha();
        break;
        case "recuperar-senha":
            $direciona = new UsuarioController();
            $direciona->recuperarSenha();
        break;
        case "codigo-de-recuperacao":
            $direciona = new Controller();
            $direciona->abrirRecuperacao($url[1]);
        break;
        case "confirmar-recuperacao":
            $direciona = new UsuarioController();
            $direciona->confirmarCodigo();
        break;
        case "redefinir-senha":
            $direciona = new UsuarioController();
            $direciona->redefinirSenha();
        break;

        // USUÁRIO
        case "home-usuario":
            $usuario = new Controller();
            $usuario->abrirHomeUsuario();
        break;
        case "perfil":
            $usuario = new Controller();
            $usuario->abrirPerfil();
        break;
        case "alterar-senha":
            $usuario = new Controller();
            $usuario->abrirAlterarSenha($url[1]);
        break;

        // LOGOUT
        case "encerrar-sessao":
            $login = new UsuarioController();
            $login->sair();
        break;

        // TESTE
        case "tst":
            $teste = new Controller();
            $teste->abrirTeste();
        break;

        default:
            // URL INVÁLIDA
            $direciona = new Controller();
            $direciona->paginaNaoEncontrada();
    }
}
else
{
    //ABRIR PÁGINA INICIAL
    $direciona = new Controller();
    $direciona->abrirInicio();
}
?>