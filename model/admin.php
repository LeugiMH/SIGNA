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
        require_once "conexao.php";
    }

    //Método realiza Login
    function logar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT * FROM TBADMIN WHERE EMAIL = :EMAIL");
        
        //Parâmetros SQL
        $cmd->bindParam(":EMAIL", $this->EMAIL);

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetch(PDO::FETCH_OBJ);
    }

    //OBSERVAÇÃO: Seguir diagrama de classe
    //Método Cadastrar

    //Método Consultar

    //Método Alterar

    //Método Excluir
}







?>