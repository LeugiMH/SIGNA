<?php
class Especime
{
    private $IDESPECIME;
    private $IDESPECIE;
    private $ESTADO;
    private $COORD;
    private $DAP;
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
        $cmd = $con->prepare("SELECT * FROM TBESPECIME");

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }
    //Método Alterar

    //Método Excluir
}







?>