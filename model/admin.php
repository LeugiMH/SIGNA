<?php
class Admin
{
    private $IDADMIN;
    private $NOME;
    private $MATRICULA;
    private $EMAIL;
    private $SENHA;
    private $CODRECUPERACAO;
    private $DATACAD;
    private $ESTADO;

    //Método get
    function __get($atributo)
    {
        return $this->$atributo;
    }

    //Método set
    function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    //Método construtor
    function __construct()
    {
        //Importando arquivo de conexão com banco de dados
        require_once "Conexao.php";
    }


    //OBSERVAÇÃO: Seguir diagrama de classe
    //Método Cadastrar

    //Método Consultar

    //Método Alterar

    //Método Excluir
}







?>