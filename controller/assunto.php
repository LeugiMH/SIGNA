<?php
include_once "model/assunto.php";

class AssuntoController
{
    //Cadastrar
    function cadastrarAssunto()
    {
        $descricao =  $_POST["inputDescricao"];

        //Cria objeto da classe espécie e define valores
        $cmd = new Assunto();
        $cmd->DESCRICAO = $descricao;

        if($cmd->cadastrar())  //Sucesso ao cadastrar assunto
        {
            setcookie("msg","<div class='alert alert-success'>Assunto cadastrado com sucesso</div>",time() + 1,"/");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar o assunto</div>",time() + 1,"/");
        }
        header("location: ".URL."assuntos/cadastro");
    }

    //Consultar
    function buscar($id)
    {
        $assunto = new Assunto();
        $assunto->IDASSUNTO = $id;
        return $assunto->buscar();
    }

    //Listar
    function listar()
    {
        $cmd = new Assunto();
        return $cmd->listar();
    }

    //Alterar
    function alterarAssunto()
    {
        $idAssunto =  $_POST["inputId"];
        $descricao =  $_POST["inputDescricao"];

        
        //Cria objeto da classe espécie e define valores        
        $cmd = new Assunto();
        $cmd->IDASSUNTO = $idAssunto;
        $cmd->DESCRICAO = $descricao;

        if($cmd->alterar()) //Sucesso ao alterar assunto
        {
            header("location: ".URL."assuntos/lista");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao alterar assunto</div>",time() + 1,"/");
            header("location: ".URL."assuntos/altera/$idAssunto");
        }
    }

    //Excluir
    function excluirAssunto($id)
    {
        $idAssunto = $id;

        $cmd = new Assunto();
        $cmd->IDASSUNTO = $idAssunto;

        if($cmd->excluir())
        {}
        else
        {
            setcookie("msgLista","<div class='alert alert-danger'>Erro ao excluir a assunto, é possível que esse assunto possua algum feedback relacionado.</div>",time() + 1,"/");
        }
        header("location: ".URL."assuntos/lista");
    }
}

?>
