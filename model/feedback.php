<?php
class Feedback
{
    private $IDFEEDBACK;
    private $IDESPECIME;
    private $TPUSUARIO;
    private $AVALIACAO;
    private $IDASSUNTO;
    private $TEXTO;
    private $EMAIL;
    private $DATACAD;  
    private $IDADMIN; 
    private $COMENT_ADMIN; 

    //Método get
    function __get($feedback)
    {
        return $this->$feedback;
    }

    //Método set
    function __set($feedback, $valor)
    {
        $this->$feedback = $valor;
    }

    //Método construtor
    function __construct()
    {
        //Importando arquivo de conexão com banco de dados
        require_once "conexao.php";
    }

    //OBSERVAÇÃO: Seguir diagrama de classe
    //Método Cadastrar
    function sendFeedback()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBFEEDBACK (IDESPECIME,TPUSUARIO,AVALIACAO,IDASSUNTO,EMAIL,DATACAD,TEXTO) 
                                            VALUES (:IDESPECIME,:TPUSUARIO,:AVALIACAO,:IDASSUNTO,:EMAIL,:DATACAD,:TEXTO)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIME",     $this->IDESPECIME);
        $cmd->bindParam(":TPUSUARIO",     $this->TPUSUARIO);
        $cmd->bindParam(":AVALIACAO",     $this->AVALIACAO);
        $cmd->bindParam(":IDASSUNTO",      $this->IDASSUNTO);
        $cmd->bindParam(":TEXTO",      $this->TEXTO);
        $cmd->bindParam(":EMAIL",      $this->EMAIL);
        $cmd->bindParam(":DATACAD",     $this->DATACAD);

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

    //Método Consultar
    function listar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT * FROM TBFEEDBACK");

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
        $cmd = $con->prepare("SELECT * FROM TBFEEDBACK WHERE IDFEEDBACK = :IDFEEDBACK");
        $cmd->bindParam(":IDFEEDBACK", $this->IDFEEDBACK);

        //Executando o comando SQL
        $cmd->execute();
        
        return $cmd->fetch(PDO::FETCH_OBJ);
    }

    //Método Alterar
    function enviarRespostaAdmin()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("UPDATE TBFEEDBACK SET IDADMIN = :IDADMIN, COMENT_ADMIN = :COMENT_ADMIN
                                            WHERE IDFEEDBACK = :IDFEEDBACK");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDADMIN",     $this->IDADMIN);
        $cmd->bindParam(":IDFEEDBACK",     $this->IDFEEDBACK);
        $cmd->bindParam(":COMENT_ADMIN",     $this->COMENT_ADMIN);

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
    /*Conectando ao banco de dados
    function excluir()
    {
        $con = Conexao::conectar();
        
        //Preparar comando SQL para retornar
        $cmd = $con->prepare("delete FROM TBESPECIE WHERE IDESPECIE = :IDESPECIE");
        $cmd->bindParam(":IDESPECIE", $this->IDESPECIE);
        
        //Executando o comando SQL
        try
        {
            return $cmd->execute();
        }
        catch (PDOException $e)
        {            
            return false;
        }
    }*/
}

?>