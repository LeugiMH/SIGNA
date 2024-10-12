<?php
include_once "model/atributo.php";

class AtributoController
{
    //Cadastrar
    function cadastrarAtributo()
    {
        $nome =  $_POST["inputNomeAtr"];

        //Cria objeto da classe espécie e define valores
        $cmd = new Atributo();
        $cmd->NOMEATRIBUTO = $nome;

        if($cmd->cadastrar())  //Sucesso ao cadastrar atributo
        {
            setcookie("msg","<div class='alert alert-success'>Atributo cadastrado com sucesso</div>",time() + 1,"/");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar o Atributo</div>",time() + 1,"/");
        }
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
    function listarAtributos()
    {
        $cmd = new Atributo();
        echo json_encode($cmd->listar());
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

        if($cmd->alterar()) //Sucesso ao alterar atributo
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
        $idAtr = $id;

        $cmd = new Atributo();
        $cmd->IDATRIBUTO = $idAtr;

        if($cmd->excluir())
        {
            return true;
        }
        else
        {
            setcookie("msgLista","<div class='alert alert-danger'>Erro ao excluir a atributo, é possível que esse atributo possua alguma espécie relacionado.</div>",time() + 1,"/");
        }
    }
}

?>
