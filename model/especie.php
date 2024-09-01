<?php
class Especie
{
    private $IDESPECIE;
    private $NOMECIE;
    private $NOMEPOP;
    private $FAMILIA;
    private $HABITAT;
    private $ALTURA;
    private $IMAGEM;
    private $DESCRICAOIMG;
    private $DATACAD;
    private $IDCADADM;

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
        require_once "conexao.php";
    }

    //OBSERVAÇÃO: Seguir diagrama de classe
    //Método Cadastrar

    //Método Consultar
    function listar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT * FROM TBESPECIE");

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }
    //Método Alterar

    //Método Excluir
}







?>