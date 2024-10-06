<?php
class Assunto
{
    private $IDASSUNTO;
    private $DESCRICAO;


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
        $cmd = $con->prepare("INSERT INTO TBASSUNTO (DESCRICAO) 
                                            VALUES (:DESCRICAO)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":DESCRICAO",     $this->DESCRICAO);

        //Executando e retornando resultado
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {
            return false;
        }
        
    }

    //Método Consultar
    function listar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT * FROM TBASSUNTO");

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }

    //Método Buscar
    function buscar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT * FROM TBASSUNTO WHERE IDASSUNTO = :IDASSUNTO");
        $cmd->bindParam(":IDASSUNTO", $this->IDASSUNTO);

        //Executando o comando SQL
        $cmd->execute();
        
        return $cmd->fetch(PDO::FETCH_OBJ);
    }

    //Método Alterar
    function alterar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("UPDATE TBASSUNTO SET DESCRICAO = :DESCRICAO
                                            WHERE IDASSUNTO = :IDASSUNTO");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDASSUNTO",     $this->IDASSUNTO);
        $cmd->bindParam(":DESCRICAO",     $this->DESCRICAO);
        //Executando e retornando resultado
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    //Método Excluir
    //Conectando ao banco de dados
    function excluir()
    {
        $con = Conexao::conectar();
        
        //Preparar comando SQL para retornar
        $cmd = $con->prepare("DELETE FROM TBASSUNTO WHERE IDASSUNTO = :IDASSUNTO");
        $cmd->bindParam(":IDASSUNTO", $this->IDASSUNTO);
        
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