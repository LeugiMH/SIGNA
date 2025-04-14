<?php
class Acesso
{
    private $IDACESSO;
    private $DATAACESSO;
    private $IDESPECIME;

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
    function cadastrar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("INSERT INTO TBACESSO (DATAACESSO,IDESPECIME) VALUES (:DATAACESSO,:IDESPECIME);");
        
        //Parâmetros SQL
        $cmd->bindParam(":DATAACESSO", $this->DATAACESSO);
        $cmd->bindParam(":IDESPECIME", $this->IDESPECIME);

        //Executando o comando SQL
        return $cmd->execute();
    }
}
?>