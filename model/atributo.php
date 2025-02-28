<?php
class Atributo
{
    private $IDATRIBUTO;
    private $NOMEATRIBUTO;
    private $IDESPECIE;

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
    function cadastrar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBATRIBUTO (NOMEATRIBUTO) 
                                            VALUES (:NOMEATRIBUTO)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":NOMEATRIBUTO",     $this->NOMEATRIBUTO);

        //Executando e retornando resultado
        try
        {
            $cmd->execute();
            return $con->lastInsertId();
        }
        catch (PDOException $e)
        {
            return false;
        }
        
    }

    //Método Consultar com associação
    function listar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("CALL SP_SELECTATRI_ESPECIE (:IDESPECIE)");

        $cmd->bindParam(":IDESPECIE", $this->IDESPECIE);

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }

    //Método Excluir
    //Conectando ao banco de dados
    function excluir()
    {
        $con = Conexao::conectar();
        
        //Preparar comando SQL para retornar
        $cmd = $con->prepare("DELETE FROM TBATRIBUTO WHERE IDATRIBUTO = :IDATRIBUTO");
        $cmd->bindParam(":IDATRIBUTO", $this->IDATRIBUTO);
        
        //Executando o comando SQL
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {            
            return false;
        }
    }
}







?>
