<?php
include_once "model/assunto.php";

class AssuntoController
{
    //Cadastrar
    function cadastrarAssunto()
    {
        $descricao =  $_POST["inputDescricao"];
        $id = $_POST["inputIdAssunto"];

        $cmd = new Assunto();
        $cmd->DESCRICAO = $descricao;

        if($_POST["inputIdAssunto"]){
            $id = $_POST["inputIdAssunto"];
            $cmd->IDASSUNTO = $id;
            if($cmd->alterar()) //Sucesso ao alterar assunto
            {
                setcookie("msgAssunto","<div class='alert alert-success'>Assunto alterado com sucesso!</div>",time() + 1,"/");
            }
            else
            {
                setcookie("msgAssunto","<div class='alert alert-danger'>Erro ao alterar assunto!</div>",time() + 1,"/");
            }
        }else{
            if($cmd->cadastrar())  //Sucesso ao cadastrar assunto
            {
                setcookie("msgAssunto","<div class='alert alert-success'>Assunto cadastrado com sucesso!</div>",time() + 1,"/");
            }
            else
            {
                setcookie("msgAssunto","<div class='alert alert-danger'>Senha alterada com sucesso!</div>",time() + 1,"/");
            }
        }
        header("Location: ".URL."inicio#sectionFeedbacks");
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

    //Excluir
    function excluirAssunto($id)
    {
        $idAssunto = $id;

        $cmd = new Assunto();
        $cmd->IDASSUNTO = $idAssunto;

        if(!$cmd->excluir())//erro ao excluir assunto
        { 
            setcookie("msgLista","<script>alert('Erro ao excluir a assunto, é possível que esse assunto possua algum feedback relacionado.')</script>",time() + 1,"/");
        }
        header("Location: ".URL."inicio#sectionFeedbacks");
    }
}

?>
