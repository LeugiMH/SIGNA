<?php
require_once "/config/ambiente.php";
class Conexao{

    static function conectar(){              
        $server = Ambiente::SERVER;
        $database = Ambiente::DATABASE;
        
        //Informações do host para acessar o servidor do banco de dados
        $host = "mysql:host=$server;dbname=$database";
        $usuario = Ambiente::USER;
        $senha = Ambiente::PASSWORD;
        
        try
        {
            $conn = new PDO($host,$usuario,$senha);

            //Ativando recurso de exibição de erro
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            //Retorna conexão para uso
            return $conn;

            $conn = null;
        }
        //Tratamento de erro
        catch(PDOException $e)
        {
            echo "
            <script>
                alert('ERRO AO REALIZAR CONEXÃO COM BANCO DE DADOS.');
                window.location.href = '".URL."inicio';
            </script>";
        }
    }
}
?>