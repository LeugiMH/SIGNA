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
                setcookie("msg","<div class='alert alert-danger'>Usuário desativado.</div>",time() + 1,"/");
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
            setcookie("msg","<div class='alert alert-danger'>Email ou senha estão incorretos.</div>",time() + 1,"/");

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

    //Cadastrar
    function cadastrarAdmin()
    {
        $descricao =  $_POST["inputDescricao"];

        //Cria objeto da classe espécie e define valores
        $cmd = new Admin();
        $cmd->DESCRICAO = $descricao;

        if($cmd->cadastrar())  //Sucesso ao cadastrar assunto
        {
            setcookie("msg","<div class='alert alert-success'>Administrador cadastrado com sucesso</div>",time() + 1,"/");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar o administrador</div>",time() + 1,"/");
        }
        header("location: ".URL."admins/cadastro");
    }

    //Consultar
    function buscar($id)
    {
        $admin = new Admin();
        $admin->IDADMIN = $id;
        return $admin->buscar();
    }

    //Listar
    function listar()
    {
        $cmd = new Admin();
        return $cmd->listar();
    }

    //Alterar
    function alterarAdmin()
    {
        $idAssunto =  $_POST["inputId"];
        $descricao =  $_POST["inputDescricao"];

        
        //Cria objeto da classe espécie e define valores        
        $cmd = new Admin();
        $cmd->IDASSUNTO = $idAssunto;
        $cmd->DESCRICAO = $descricao;

        if($cmd->alterar()) //Sucesso ao alterar assunto
        {
            header("location: ".URL."admins/lista");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao alterar administrador</div>",time() + 1,"/");
            header("location: ".URL."admins/altera/$idEspecie");
        }
    }

    //Excluir
    function excluirAdmin($id)
    {
        $idAdmin = $id;

        $cmd = new Admin();
        $cmd->IDADMIN = $idAdmin;

        if($cmd->excluir())
        {}
        else
        {
            setcookie("msgLista","<div class='alert alert-danger'>Erro ao excluir a administrador, é possível que esse adminstrador possua algum registro relacionado.</div>",time() + 1,"/");
        }
        header("location: ".URL."admins/lista");
    }
}
?>
