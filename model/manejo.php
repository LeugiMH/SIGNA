<?php
class Manejo
{
    private $IDMANEJO;
    private $IDESPECIME;
    private $TIPOMANEJO; #RG-Rega; PD-Poda; AD-Adubação; CP-Controle de Praga; OT-Outro
    private $DATAMANEJO;

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

    //Método Cadastrar
    function cadastrar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBMANEJO (IDESPECIME,TIPOMANEJO,DATAMANEJO) 
                                            VALUES (:IDESPECIME,:TIPOMANEJO,:DATAMANEJO)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIME",      $this->IDESPECIME);
        $cmd->bindParam(":TIPOMANEJO",      $this->TIPOMANEJO);
        $cmd->bindParam(":DATAMANEJO",      $this->DATAMANEJO);
        //Executando e retornando resultado
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {
            //Debug
            //setcookie("erro",$e, time() + 1,"/");
            return false;
        }
    }

    //Método Consultar
    function listar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT IDMANEJO,IDESPECIME,TIPOMANEJO,DATAMANEJO FROM TBMANEJO");

        //Executando o comando SQL
        $cmd->execute();
        
        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }
    //Método Consultar
    function listarPorEspecime()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT IDMANEJO,IDESPECIME,TIPOMANEJO,DATAMANEJO FROM TBMANEJO WHERE IDESPECIME = :IDESPECIME ORDER BY DATAMANEJO DESC");
        $cmd->bindParam(":IDESPECIME", $this->IDESPECIME);

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
        $cmd = $con->prepare("SELECT IDMANEJO,IDESPECIME,TIPOMANEJO,DATAMANEJO FROM TBMANEJO WHERE IDMANEJO = :IDMANEJO");
        $cmd->bindParam(":IDMANEJO", $this->IDMANEJO);

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
        $cmd = $con->prepare("UPDATE TBMANEJO SET TIPOMANEJO = :TIPOMANEJO, DATPLANT = :DATPLANT
                                            WHERE IDESPECIME = :IDESPECIME");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":TIPOMANEJO",  $this->TIPOMANEJO);
        $cmd->bindParam(":DATPLANT",    $this->DATPLANT);
        $cmd->bindParam(":IDESPECIME",  $this->IDESPECIME);
        

        //Executando e retornando resultado
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {
            //Debug
            //setcookie("erro",$e, time() + 1,"/");
            return false;
        }
    }

    //Método deletar
    function excluir()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("DELETE FROM TBMANEJO WHERE IDMANEJO = :IDMANEJO");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDMANEJO",  $this->IDMANEJO);

        //Executando e retornando resultado
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {
            //Debug
            //setcookie("msg","$e",time() + 1,"/");
            return false;
        }
        
    }
}
?>