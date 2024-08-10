<?php
session_start();

/*  
    include_once "controller/Controller.php";
    include_once "controller/AnimalController.php";
    include_once "controller/UsuarioController.php";
    include_once "controller/ClinicaController.php";
*/

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
        case "cadastra-animal":
            $animal = new Controller();
            $animal->abrirCadAnimal();
        break;
        case "carregar-raca":
            $raca = new AnimalController();
            $raca->carregarRaca($url[1]);    
        break;
        case "cadastrar-animal":
            $animal = new AnimalController();
            $animal->cadastrarAnimal();
        break;
        case "meus-animais":
            $usuario = new Controller();
            $usuario->abrirMeusAnimais();
        break;
        case "atualizar-animal":
            $usuario = new AnimalController();
            $usuario->atualizarAnimal($url[1],$url[2]);
        break;
        case "excluir-animal":
            $usuario = new AnimalController();
            $usuario->excluirAnimal($url[1],$url[2],$url[3]);
        break;
        case "solicitar-castracao":
            $usuario = new UsuarioController();
            $usuario->solicitarCastracao();
        break;
        case"excluir-tutor":
            $usuario = new UsuarioController();
            $usuario->excluir($url[1],$url[2]);
        break;

        // ADM
        case "novo-mes":
            $adm = new UsuarioController();
            $adm->novoMes();
        break;
        case "home-adm":
            $adm = new Controller();
            $adm->abrirHomeAdm();
        break;
               
        // LOGOUT
        case "encerrar-sessao":
            $login = new UsuarioController();
            $login->sair();
        break;

        // TESTE
        case "teste":
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