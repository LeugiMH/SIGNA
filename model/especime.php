<?php
class Especime
{
    private $IDESPECIME;
    private $IDESPECIE;
    private $COORD;
    private $IMAGEM;
    private $DESCRICAOIMG;
    private $ESTADO;
    private $DAP;
    private $DATPLANT;
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

    //Método Cadastrar
    function cadastrar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("INSERT INTO TBESPECIME (IDESPECIE,COORD,IMAGEM,DESCRICAOIMG,ESTADO,DAP,DATPLANT,DATACAD,IDCADADM) 
                                            VALUES (:IDESPECIE,:COORD,:IMAGEM,:DESCRICAOIMG,:ESTADO,:DAP,:DATPLANT,:DATACAD,:IDCADADM)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIE",   $this->IDESPECIE);
        $cmd->bindParam(":COORD",       $this->COORD);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":ESTADO",      $this->ESTADO);
        $cmd->bindParam(":DAP",         $this->DAP);
        $cmd->bindParam(":DATPLANT",    $this->DATPLANT);
        $cmd->bindParam(":DATACAD",     $this->DATACAD);
        $cmd->bindParam(":IDCADADM",    $this->IDCADADM);
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
        $cmd = $con->prepare("SELECT TBA.*,NOMEPOP FROM TBESPECIME TBA JOIN TBESPECIE TBB ON TBA.IDESPECIE = TBB.IDESPECIE");

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
        $cmd = $con->prepare("SELECT * FROM TBESPECIME WHERE IDESPECIME = :IDESPECIME");
        $cmd->bindParam(":IDESPECIME", $this->IDESPECIME);

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
        $cmd = $con->prepare("UPDATE TBESPECIME SET IDESPECIE = :IDESPECIE, COORD = :COORD, IMAGEM = :IMAGEM, DESCRICAOIMG = :DESCRICAOIMG, ESTADO = :ESTADO, DAP = :DAP
                                            WHERE IDESPECIME = :IDESPECIME");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIE",   $this->IDESPECIE);
        $cmd->bindParam(":COORD",       $this->COORD);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":ESTADO",      $this->ESTADO);
        $cmd->bindParam(":DAP",         $this->DAP);
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
}
?>