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
        }
        else
        {
            echo "<script type='text/javascript'> alert('Email ou senha estão incorretos'); </script>";
            header("");
        }
    }
}
?>
