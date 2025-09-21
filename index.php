<?php
session_start();

//Import de controllers
include_once "controller/routes.php";

//Definindo fuso horário default
date_default_timezone_set("America/Sao_Paulo");

//Definindo uma constante para a URL do site
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']))
    $uri = 'https://';
else
    $uri = 'http://';
if(str_contains($_SERVER['HTTP_HOST'],"signa.eco.br"))
    $uri .= $_SERVER['HTTP_HOST']."/";
else
    $uri .= $_SERVER['HTTP_HOST']."/SIGNA/";

define("URL",$uri);

//Criando uma sessão para o usuário
if(isset($_COOKIE['sessao']) && !(isset($_SESSION['sessaoLogada'])) && !isset($_SESSION['try']))
{
    $_SESSION['try'] = true; //Evita loop infinito

    $admin = new AdminController();
    $admin->loginByCookie();
}

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

        // FEEDBACK
        case "envFeedback":
            $route = new FeedbackController();
            $route->enviarFeedback();
        break;

        case "buscaFeedback":
            $route = new FeedbackController();
            $route->buscar($url[1]);
        break;

        case "respFeedback":
            $route = new FeedbackController();
            $route->enviarRespostaAdmin();
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

        case "recuperar-senha": 
            $route = new Route();
            $route->abrirRecuperacaoSenha();
        break;

        case "gerar-codigo":
            $route = new AdminController();
            $route->gerarCodigoRecuperacao();
        break;

        case "codigo-recuperacao":
            $route = new Route();
            $route->abrirCodigoRecuperacaoSenha($url[1]);
        break;

        case "confirmar-recuperacao":
            $route = new AdminController();
            $route->confirmarCodigoRecuperacao();
        break;

        case "redefinir-senha":
            $route = new Route();
            $route->abrirRedefinirSenha($url[1]);
        break;

        case "alterar-senha":
            $route = new AdminController();
            $route->alterarSenha();
        break;

        // FUNÇÕES ADMIN
        case "admins":
            switch($url[1])
            {
                case "lista":
                    $route = new Route();
                    $route->abrirListaAdmin();
                break;
                case "cadastro":
                    $route = new Route();
                    $route->abrirCadastroAdmin();
                break;
                case "cadastrar":
                    $route = new AdminController();
                    $route->cadastrarAdmin();
                break;
                case "altera":
                    $route = new Route();
                    $route->abrirAlteraAdmin($url[2]);
                break;
                case "alterar":
                    $route = new AdminController();
                    $route->alterarAdmin();
                break;
                case "alterarEstado":
                    $route = new AdminController();
                    $route->alterarEstado($url[2]);
                break;
                case "excluir":
                    $route = new AdminController();
                    $route->excluirAdmin($url[2]);
                break;
                default:
                    // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
                break;
            }
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
        
        //MANEJO
        case "manejo":
            switch($url[1])
            {   
                case "listar":
                    $route = new ManejoController();
                    $route->listar($url[2] ?? null,true);
                break;
                case "cadastrar":
                    $route = new ManejoController();
                    $route->cadastrar();
                break;
                case "excluir":
                    $route = new ManejoController();
                    $route->excluir($url[2]);
                break;
                default:
                // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
                break;
            }
        break;

        //ATRIBUTOS
        case "atributos":
            switch($url[1])
            {   
                case "listar":
                    $route = new AtributoController();
                    $route->listarJSON($url[2]);
                break;
                case "cadastrar":
                    $route = new AtributoController();
                    $route->cadastrarAtributo();
                break;
                case "excluir":
                    $route = new AtributoController();
                    $route->excluirAtributo($url[2]);
                break;
                default:
                // URL INVÁLIDA
                    $route = new Route();
                    $route->abrirPaginaNaoEncontrada();
                break;
            }
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

        // FUNÇÕES ASSUNTOS
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
                /*case "alterar":
                    $route = new AssuntoController();
                    $route->alterarAssunto();
                break;*/
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