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
    function cadastrar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) 
                                            VALUES (:NOMECIE,:NOMEPOP,:FAMILIA,:HABITAT,:ALTURA,:IMAGEM,:DESCRICAOIMG,:DATACAD,:IDCADADM)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":NOMECIE",     $this->NOMECIE);
        $cmd->bindParam(":NOMEPOP",     $this->NOMEPOP);
        $cmd->bindParam(":FAMILIA",     $this->FAMILIA);
        $cmd->bindParam(":HABITAT",     $this->HABITAT);
        $cmd->bindParam(":ALTURA",      $this->ALTURA);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":DATACAD",     $this->DATACAD);
        $cmd->bindParam(":IDCADADM",    $this->IDCADADM);

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
        $cmd = $con->prepare("SELECT * FROM TBESPECIE");

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
        $cmd = $con->prepare("SELECT * FROM TBESPECIE WHERE IDESPECIE = :IDESPECIE");
        $cmd->bindParam(":IDESPECIE", $this->IDESPECIE);

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
        $cmd = $con->prepare("UPDATE TBESPECIE SET NOMECIE = :NOMECIE, NOMEPOP = :NOMEPOP, FAMILIA = :FAMILIA, HABITAT = :HABITAT, ALTURA = :ALTURA, IMAGEM = :IMAGEM, DESCRICAOIMG = :DESCRICAOIMG
                                            WHERE IDESPECIE = :IDESPECIE");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":NOMECIE",     $this->NOMECIE);
        $cmd->bindParam(":NOMEPOP",     $this->NOMEPOP);
        $cmd->bindParam(":FAMILIA",     $this->FAMILIA);
        $cmd->bindParam(":HABITAT",     $this->HABITAT);
        $cmd->bindParam(":ALTURA",      $this->ALTURA);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":IDESPECIE",   $this->IDESPECIE);

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
        $cmd = $con->prepare("delete FROM TBESPECIE WHERE IDESPECIE = :IDESPECIE");
        $cmd->bindParam(":IDESPECIE", $this->IDESPECIE);
        
        //Executando o comando SQL
        return $cmd->execute();
    }
}







?>