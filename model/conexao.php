<?php
class Conexao{

    static function connect(){

        //Informações do host para acessar o servidor do banco de dados
        $host = "sqlsrv:Server=localhost;Database=SIGNA";
        //Usuário e senha nulos para autenticação windows
        $usuario = null;
        $senha = null;
        
        $conn = new PDO($host,$usuario,$senha);
        
        //Ativando recurso de exibição de erro
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        return $conn;//Retorna conexão para uso
    }
}
?>