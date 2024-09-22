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
            //Caso usuário esteja desativado
            if($dadosLogin->ESTADO != 1)
            {
                setcookie("msg","Usuário desativado.");
                header("Location:".URL."login");
            }
            else
            {
                //Define informações do usuário para uma sessão
                $_SESSION['sessaoLogada'] = $dadosLogin;
    
                //Direciona para administrador
                header("Location:".URL."inicio");
            }
        }
        else
        {
            //Define mensagem de erro
            setcookie("msg","<div class='alert alert-success'>Email ou senha estão incorretos.</div>");

            //Direciona para login 
            header("Location:".URL."login");
        }
        return 0;
    }

    function sair()
    {
        $_SESSION[] = null;
        session_destroy();
        header("Location: login");
    }
}
?>
