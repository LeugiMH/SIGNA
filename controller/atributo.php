<?php
include_once "model/atributo.php";

class AtributoController
{
    //Cadastrar
    function cadastrarAtributo()
    {
        $descricao =  $_POST["inputDescricao"];

        //Cria objeto da classe espécie e define valores
        $cmd = new Atributo();
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
        $assunto = new Atributo();
        $assunto->IDASSUNTO = $id;
        return $assunto->buscar();
    }

    //Listar
    function listar()
    {
        $cmd = new Atributo();
        return $cmd->listar();
    }

    //Alterar
    function alterarAtributo()
    {
        $idAssunto =  $_POST["inputId"];
        $descricao =  $_POST["inputDescricao"];

        
        //Cria objeto da classe espécie e define valores        
        $cmd = new Atributo();
        $cmd->IDASSUNTO = $idAssunto;
        $cmd->DESCRICAO = $descricao;

        if($cmd->alterar()) //Sucesso ao alterar assunto
        {
            header("location: ".URL."assuntos/lista");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao alterar assunto</div>",time() + 1,"/");
            header("location: ".URL."assuntos/altera/$idEspecie");
        }
    }

    //Excluir
    function excluirAtributo($id)
    {
        $idAssunto = $id;

        $cmd = new Atributo();
        $cmd->IDASSUNTO = $idAssunto;

        $especie = $cmd->buscar();

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
