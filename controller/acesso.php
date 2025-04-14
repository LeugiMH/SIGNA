<?php
include_once "model/acesso.php";

class AcessoController
{
    //Cadastrar
    function cadastrarAcesso($idEspecime)
    {
        $cmd = new Acesso();
        $cmd->IDACESSO = null; //ID do acesso, não é necessário passar, pois o banco de dados já gera automaticamente.
        $cmd->DATAACESSO = date("Y-m-d h:i:s"); //Data atual de cadastro
        $cmd->IDESPECIME = $idEspecime;

        $cmd->cadastrar(); //Chama o método cadastrarAcesso da classe Acesso
    }
}

?>
