<?php
class Especie
{
    private $IDESPECIE;
    private $NOMECIE;
    private $NOMEPOP;
    private $FAMILIA;
    private $HABITAT;
    private $ALTURA;
    private $CONSERV;
    private $IMAGEM;
    private $DESCRICAOIMG;
    private $DATACAD;
    private $IDCADADM;
    //Atributo
    private $IDATRIBUTO;
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
        $cmd = $con->prepare("INSERT INTO TBESPECIE (NOMECIE,NOMEPOP,FAMILIA,HABITAT,CONSERV,ALTURA,IMAGEM,DESCRICAOIMG,DATACAD,IDCADADM) 
                                            VALUES (:NOMECIE,:NOMEPOP,:FAMILIA,:HABITAT,:CONSERV,:ALTURA,:IMAGEM,:DESCRICAOIMG,:DATACAD,:IDCADADM)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":NOMECIE",     $this->NOMECIE);
        $cmd->bindParam(":NOMEPOP",     $this->NOMEPOP);
        $cmd->bindParam(":FAMILIA",     $this->FAMILIA);
        $cmd->bindParam(":CONSERV",     $this->CONSERV);
        $cmd->bindParam(":HABITAT",     $this->HABITAT);
        $cmd->bindParam(":ALTURA",      $this->ALTURA);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":DATACAD",     $this->DATACAD);
        $cmd->bindParam(":IDCADADM",    $this->IDCADADM);

        //Executando e retornando resultado
        try
        {
            $cmd->execute();
            return $con->lastInsertId();
        }
        catch (PDOException $e)
        {
            setcookie("msg","<div class='alert alert-danger'>$e</div>",time() + 1,"/");
            return false;
        }
        
    }

    //Método desassociar Atributos
    function desAssociarAtributo()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para inserir
        $cmd = $con->prepare("DELETE FROM TBATRI_ESPECIE WHERE IDESPECIE = :IDESPECIE");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIE",     $this->IDESPECIE);

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

    //Método associar atributo
    function associarAtributo()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBATRI_ESPECIE (IDESPECIE,IDATRIBUTO,DESCRICAO) 
                                            VALUES (:IDESPECIE,:IDATRIBUTO,:DESCRICAO)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIE",     $this->IDESPECIE);
        $cmd->bindParam(":IDATRIBUTO",     $this->IDATRIBUTO);
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
        $cmd = $con->prepare("SELECT ESP.*,NOME FROM TBESPECIE ESP JOIN TBADMIN ADM ON ESP.IDCADADM = ADM.IDADMIN");

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }

    //Método Consultar
    function listarAdm()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT ESP.*,NOME, (SELECT COUNT(1) FROM TBESPECIME ESP2 WHERE ESP2.IDESPECIE = ESP.IDESPECIE) AS QUANT FROM TBESPECIE ESP JOIN TBADMIN ADM ON ESP.IDCADADM = ADM.IDADMIN HAVING QUANT > 0");

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }

    //Método Consultar
    function listarUsu()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT ESP.*,NOME, (SELECT COUNT(1) FROM TBESPECIME ESP2 WHERE ESP2.IDESPECIE = ESP.IDESPECIE AND ESP2.ESTADO = '1') AS QUANTATIVA FROM TBESPECIE ESP JOIN TBADMIN ADM ON ESP.IDCADADM = ADM.IDADMIN HAVING QUANTATIVA > 0");

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

    function buscarAtrAssoc()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT NOMEATRIBUTO,DESCRICAO FROM TBATRI_ESPECIE ASS JOIN TBATRIBUTO ART ON ART.IDATRIBUTO = ASS.IDATRIBUTO WHERE IDESPECIE = :IDESPECIE");
        $cmd->bindParam(":IDESPECIE", $this->IDESPECIE);

        //Executando o comando SQL
        $cmd->execute();
        
        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }

    //Método Alterar
    function alterar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("UPDATE TBESPECIE SET NOMECIE = :NOMECIE, NOMEPOP = :NOMEPOP, FAMILIA = :FAMILIA, HABITAT = :HABITAT, ALTURA = :ALTURA, CONSERV = :CONSERV, IMAGEM = :IMAGEM, DESCRICAOIMG = :DESCRICAOIMG
                                            WHERE IDESPECIE = :IDESPECIE");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":NOMECIE",     $this->NOMECIE);
        $cmd->bindParam(":NOMEPOP",     $this->NOMEPOP);
        $cmd->bindParam(":FAMILIA",     $this->FAMILIA);
        $cmd->bindParam(":HABITAT",     $this->HABITAT);
        $cmd->bindParam(":CONSERV",     $this->CONSERV);
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
        $con->beginTransaction();

        $cmd1 = $con->prepare("DELETE FROM TBATRI_ESPECIE WHERE IDESPECIE = :IDESPECIE");
        $cmd1->bindParam(":IDESPECIE", $this->IDESPECIE);

        $cmd2 = $con->prepare("DELETE FROM TBESPECIE WHERE IDESPECIE = :IDESPECIE");
        $cmd2->bindParam(":IDESPECIE", $this->IDESPECIE);
        
        //Executando o comando SQL
        try
        {
            $cmd1->execute();
            $cmd2->execute();

            //Confirma a transação caso positivo
            $con->commit();

            return true;
        }
        catch (PDOException $e)
        {
            setcookie("msgLista","<div class='alert alert-danger'>$e</div><div class='alert alert-danger'>$e</div>",time() + 1,"/");

            //Reverte a transação caso erro 
            $con->rollBack();

            return false;
        }
    }
}







?>