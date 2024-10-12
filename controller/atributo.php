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
            echo true;
        }
        else
        {
            echo false;
        }
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

    //Excluir
    function excluirAtributo($id)
    {
        $idAtr = $id;

        $cmd = new Atributo();
        $cmd->IDATRIBUTO = $idAtr;

        if($cmd->excluir())
        {
            echo true;
        }
        else
        {
            echo false;
        }
    }
}

?>
