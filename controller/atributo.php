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

        $lastId = $cmd->cadastrar();
        if($lastId)  //Sucesso ao cadastrar atributo
        {
            echo $lastId;
        }
        else
        {
            echo false;
        }
    }

    //Listar
    function listar($id = null)
    {
        $cmd = new Atributo();
        $cmd->IDESPECIE = $id;
        return $cmd->listar();
    }
    function listarJSON($id = null)
    {
        $cmd = new Atributo();
        $cmd->IDESPECIE = $id;
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
            echo "true";
        }
        else
        {
            echo "false";
        }
    }
}

?>
