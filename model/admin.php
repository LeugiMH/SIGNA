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
    function cadastrar()
    { 
        //Conectando ao banco de dados
        $con = Conexao::conectar();
                
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBADMIN (NOME,MATRICULA,EMAIL,SENHA,DATACAD,ESTADO) 
                                            VALUES (:NOME,:MATRICULA,:EMAIL,:SENHA,:DATACAD,:ESTADO)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":NOME",        $this->NOME);
        $cmd->bindParam(":MATRICULA",   $this->MATRICULA);
        $cmd->bindParam(":EMAIL",       $this->EMAIL);
        $cmd->bindParam(":SENHA",       $this->SENHA);
        $cmd->bindParam(":DATACAD",     $this->DATACAD);
        $cmd->bindParam(":ESTADO",      $this->ESTADO);

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
        $cmd = $con->prepare("SELECT * FROM TBADMIN");

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
        $cmd = $con->prepare("SELECT * FROM TBADMIN WHERE IDADMIN = :IDADMIN");

        $cmd->bindParam(":IDADMIN", $this->IDADMIN);

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
        $cmd = $con->prepare("UPDATE TBADMIN SET NOME = :NOME, MATRICULA = :MATRICULA, EMAIL = :EMAIL, SENHA = :SENHA, DATACAD = :DATACAD, ESTADO = :ESTADO
                                            WHERE IDADMIN = :IDADMIN");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDADMIN",     $this->IDADMIN);
        $cmd->bindParam(":NOME",        $this->NOME);
        $cmd->bindParam(":NOME",        $this->NOME);
        $cmd->bindParam(":MATRICULA",   $this->MATRICULA);
        $cmd->bindParam(":EMAIL",       $this->EMAIL);
        $cmd->bindParam(":SENHA",       $this->SENHA);
        $cmd->bindParam(":DATACAD",     $this->DATACAD);
        $cmd->bindParam(":ESTADO",      $this->ESTADO);

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
    function excluir()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para retornar
        $cmd = $con->prepare("DELETE FROM TBADMIN WHERE IDADMIN = :IDADMIN");
        $cmd->bindParam(":IDADMIN",     $this->IDADMIN);
        
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

    //Método altera status
    function altEstado()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para retornar
        $cmd = $con->prepare("UPDATE TBADMIN SET ESTADO = :ESTADO WHERE IDADMIN = :IDADMIN");
        $cmd->bindParam(":IDADMIN",     $this->IDADMIN);
        $cmd->bindParam(":ESTADO",     $this->ESTADO);
        
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

    function gerarCodigo()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("UPDATE TBADMIN SET CODRECUPERACAO = :CODRECUPERACAO WHERE IDADMIN = :IDADMIN");
        $cmd->bindParam(":IDADMIN",     $this->IDADMIN);
        $cmd->bindParam(":CODRECUPERACAO",     $this->CODRECUPERACAO);
        
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