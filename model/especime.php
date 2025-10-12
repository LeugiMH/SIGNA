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
    private $CAP;
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
        $cmd = $con->prepare("INSERT INTO TBESPECIME (IDESPECIE,COORD,IMAGEM,DESCRICAOIMG,ESTADO,DAP,CAP,DATPLANT,DATACAD,IDCADADM) 
                                            VALUES (:IDESPECIE,:COORD,:IMAGEM,:DESCRICAOIMG,:ESTADO,:DAP,:CAP,:DATPLANT,:DATACAD,:IDCADADM)");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIE",   $this->IDESPECIE);
        $cmd->bindParam(":COORD",       $this->COORD);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":ESTADO",      $this->ESTADO);
        $cmd->bindParam(":DAP",         $this->DAP);
        $cmd->bindParam(":CAP",         $this->CAP);
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
    function listarAdm()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT TBA.IDESPECIME,TBA.IDESPECIE,TBA.COORD,TBA.IMAGEM,TBA.DESCRICAOIMG,TBA.ESTADO,TBA.DAP,TBA.DATPLANT,TBA.DATACAD,TBA.IDCADADM,TBB.NOMEPOP,ADM.NOME FROM TBESPECIME TBA JOIN TBESPECIE TBB ON TBA.IDESPECIE = TBB.IDESPECIE JOIN TBADMIN ADM ON TBA.IDCADADM = ADM.IDADMIN");

        //Executando o comando SQL
        $cmd->execute();
        
        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }
    function listarUsu()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT TBA.IDESPECIE,TBB.NOMEPOP, TBA.DATPLANT 'DATPLANT',TBA.COORD, TBA.IDESPECIME FROM TBESPECIME TBA JOIN TBESPECIE TBB ON TBA.IDESPECIE = TBB.IDESPECIE WHERE TBA.ESTADO = '1'");

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
    function buscarTudo()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("SELECT TBA.IMAGEM 'IMGESPECIME',TBA.DESCRICAOIMG 'DESCESPECIME',DAP,DATPLANT 'DATPLANT',NOMECIE,NOMEPOP,FAMILIA,HABITAT,CONSERV,ALTURA,TBB.IDESPECIE,TBB.IMAGEM 'IMGESPECIE',TBB.DESCRICAOIMG 'DESCESPECIE' 
        FROM TBESPECIME TBA JOIN TBESPECIE TBB ON TBA.IDESPECIE = TBB.IDESPECIE WHERE IDESPECIME = :IDESPECIME");
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
        $cmd = $con->prepare("UPDATE TBESPECIME SET IDESPECIE = :IDESPECIE, COORD = :COORD, IMAGEM = :IMAGEM, DESCRICAOIMG = :DESCRICAOIMG, ESTADO = :ESTADO, DAP = :DAP, CAP = :CAP, DATPLANT = :DATPLANT
                                            WHERE IDESPECIME = :IDESPECIME");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":IDESPECIE",   $this->IDESPECIE);
        $cmd->bindParam(":COORD",       $this->COORD);
        $cmd->bindParam(":IMAGEM",      $this->IMAGEM);
        $cmd->bindParam(":DESCRICAOIMG",$this->DESCRICAOIMG);
        $cmd->bindParam(":ESTADO",      $this->ESTADO);
        $cmd->bindParam(":DAP",         $this->DAP);
        $cmd->bindParam(":CAP",         $this->CAP);
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

    //Método Alterar coordenada
    function alterarCoord()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();
        
        //Preparar comando SQL para inserir
        $cmd = $con->prepare("UPDATE TBESPECIME SET COORD = :COORD
                                            WHERE IDESPECIME = :IDESPECIME");

        //Definindo parâmetros (SQL INJECTION)
        $cmd->bindParam(":COORD",       $this->COORD);
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