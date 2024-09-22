<?php
class Especime
{
    private $IDESPECIME;
    private $IDESPECIE;
    private $ESTADO;
    private $COORD;
    private $DAP;
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

    //Método Consultar
    function listar()
    {
        //Conectando ao banco de dados
        $con = Conexao::conectar();

        //Preparar comando SQL para retornar
        $cmd = $con->prepare("
            SELECT
                em.*
                , ep.NOMEPOP
                , ad.NOME as NOMEADMIN
            FROM TBESPECIME em
            INNER JOIN TBESPECIE ep
                ON em.IDESPECIE = ep.IDESPECIE
            INNER JOIN TBADMIN ad
                ON em.IDCADADM = ad.IDADMIN
        ");

        //Executando o comando SQL
        $cmd->execute();

        return $cmd->fetchAll(PDO::FETCH_OBJ);
    }
    //Método Alterar

    //Método Excluir
}







?>