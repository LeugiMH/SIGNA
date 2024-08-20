<?php
include_once "model/admin.php";

class AdminController
{
    function logar()
    {
        //Capturando informações do formulário
        $email = $_POST['inputEmail'];
        $senha = $_POST['inputSenha'];
        
        //Instanciando classe do administrador
        $cmd = new Admin();

        //Enviando email para a classe instânciada
        $cmd->EMAIL = $email;

        //Consultando informações do Email digitado para a variável $dadosLogin
        $dadosLogin = $cmd->logar();

        //Se o email existir e a senha estiver correta
        if (isset($dadosLogin) && password_verify($senha,$dadosLogin->SENHA))
        {
            //Faça isso
            $_SESSION['sessaoLogada'] = $dadosLogin;

            //Direciona para administrador
            header("Location:".URL."inicio");
        }
        else
        {
            //Define mensagem de erro
            setcookie("msg","Email ou senha estão incorretos.");

            //Direciona para login 
            header("Location:".URL."login");
            return;
        }
    }

    function sair()
    {
        $_SESSION[] = null;
        session_destroy();
        header("Location: login");
    }
}
?>
