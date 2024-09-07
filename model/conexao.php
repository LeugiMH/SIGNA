<?php
class Conexao{

    static function conectar(){

        //Informações do host para acessar o servidor do banco de dados
        $host = "sqlsrv:Server=localhost;Database=SIGNA";
        //Usuário e senha nulos para autenticação windows
        $usuario = null;
        $senha = null;
        
        try
        {

            $conn = new PDO($host,$usuario,$senha);

            //Ativando recurso de exibição de erro
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
            //Retorna conexão para uso
            return $conn;            
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