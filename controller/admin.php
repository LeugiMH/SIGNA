<?php

include_once "model/admin.php";
include_once "model/email.php";
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
        header("Location:".URL."login");
    }

    //Cadastrar
    function cadastrarAdmin()
    {
        $nome =  $_POST["inputNome"];
        $matricula =  $_POST["inputMatricula"];
        $email =  $_POST["inputEmail"];
        $senha =  $_POST["inputSenha"];
        $estado = 1;

        //Cria objeto da classe espécie e define valores
        $cmd = new Admin();
        $cmd->NOME = $nome;
        $cmd->MATRICULA = $matricula;
        $cmd->EMAIL = $email;
        $cmd->SENHA = password_hash($senha,PASSWORD_DEFAULT);
        $cmd->DATACAD = date("Y-m-d H:i:s"); //Data atual de cadastro;
        $cmd->ESTADO = $estado;

        if($cmd->cadastrar())  //Sucesso ao cadastrar admin
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
        $id =  $_POST["inputId"];
        $nome =  $_POST["inputNome"];
        $matricula =  $_POST["inputMatricula"];
        $email =  $_POST["inputEmail"];
        $senha =  $_POST["inputSenha"];
        $senhaBkp =  $_POST["inputSenhaBkp"];
        $estado = 1;

        //Cria objeto da classe espécie e define valores        
        $cmd = new Admin();
        $cmd->IDADMIN = $id;
        $cmd->NOME = $nome;
        $cmd->MATRICULA = $matricula;
        $cmd->EMAIL = $email;
        $cmd->SENHA = $senha!="" ? password_hash($senha,PASSWORD_DEFAULT) : $senhaBkp; // caso a senha esteja vazia, vai manter a senha antiga
        $cmd->DATACAD = date("Y-m-d h:i:s"); //Data atual de cadastro;
        $cmd->ESTADO = $estado;

        if($cmd->alterar()) //Sucesso ao alterar admin
        {
            header("location: ".URL."admins/lista");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao alterar administrador</div>",time() + 1,"/");
            header("location: ".URL."admins/altera/$id");
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

    //Ativa / Inativa
    function alterarEstado($id)
    {
        $idAdmin = $id;

        $cmd = new Admin();
        $cmd->IDADMIN = $idAdmin;
        $buscaAdm = $cmd->buscar();

        if($buscaAdm->ESTADO == '1')
        {
            $cmd->ESTADO = 0;
            $cmd->altEstado();
        }
        else
        {
            $cmd->ESTADO = 1;
            $cmd->altEstado();
        }
        header("location: ".URL."admins/lista");
    }

    //Gerar código de recuperação de senha
    function gerarCodigoRecuperacao()
    {
        $emailDest = $_POST['inputEmail'];
        $cmd = new Admin();
        $cmd->EMAIL = $emailDest;
        $dadosRecuperacao = $cmd->logar();
        
        if($dadosRecuperacao != null)
        {
            
            //Salva código no banco de dados
            $cmd->IDADMIN = $dadosRecuperacao->IDADMIN;
            $codigo = $this->gerarCodigo($cmd);

            //Envia Email com o código de recuperação
            $email = new Email();
            $email->emailRemetente = Ambiente::EMAIL_SUPORTE_CONTA; 
            $email->senhaRemetente = Ambiente::SENHA_SUPORTE_CONTA; 
            $email->nomeRemetente = "Suporte Signa"; 
            $email->codsenha = $codigo;
            $email->emailDestinatario = $dadosRecuperacao->EMAIL;
            $email->enviarCodigo();
            
            if(!isset($_COOKIE["tentativas"]))
            {
                setcookie("tentativas", 1, time() + 3600, "/","",true,true);
            }
            echo "<script>window.location.href = '".URL."codigo-recuperacao/$dadosRecuperacao->IDADMIN'</script>";
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Parece que esse email não existe no sistema</div>",time() + 1,"/");
            header("Location:".URL."recuperar-senha");
        }
    }
    #Gerar código de recuperação
    function gerarCodigo($cmd)
    {
        $codigo = rand(100000,999999);
            
        //Salva código no banco de dados
        $cmd->CODRECUPERACAO = $codigo;
        $cmd->gerarCodigo();
        return $codigo;
    }

    function confirmarCodigoRecuperacao()
    {
        $idAdmin = $_POST['inputIdAdmin'];
        $codigo = $_POST['inputCodigo'];
        $cmd = new Admin();
        $cmd->IDADMIN = $idAdmin;

        if(!isset($_COOKIE["tentativas"])){
            $this->gerarCodigo($cmd);
            setcookie("msg","<div class='alert alert-danger'>Muitas tentativas realizadas, tente novamente mais tarde</div>",time() + 1,"/");
        }

        $dadosRecuperacao = $cmd->buscar();

        if($_COOKIE["tentativas"] < 5)
        {
            if(isset($codigo) && strlen($codigo) == 6 && isset($dadosRecuperacao) && $dadosRecuperacao->CODRECUPERACAO == $codigo)
            {
                setcookie("tentativas", 0, time() - 1, "/");
                $_SESSION["PermissaoRedefinirSenha"] = true;
                header("Location:".URL."redefinir-senha/$idAdmin");
            }
            else
            {
                setcookie("tentativas", 1 + $_COOKIE["tentativas"], time() + 3600, "/");
                setcookie("msg","<div class='alert alert-danger'>Código de recuperação incorreto</div>",time() + 1,"/","",true,true);
                header("Location:".URL."codigo-recuperacao/$idAdmin");
            }
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Muitas tentativas realizadas, tente novamente mais tarde</div>",time() + 1,"/");
            header("Location:".URL."codigo-recuperacao/$idAdmin");
        }
    }

    function alterarSenha()
    {
        $id = $_POST['inputIdAdmin'];
        $senha = $_POST['inputSenha'];

        $cmd = new Admin();
        $cmd->IDADMIN = $id;
        $cmd->SENHA = password_hash($senha,PASSWORD_DEFAULT);
        $cmd->alterarSenha();

        setcookie("msg","<div class='alert alert-success'>Senha alterada com sucesso!</div>",time() + 1,"/");
        header("Location:".URL."login");
    }
}
?>
