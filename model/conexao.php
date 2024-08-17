<?php
class Conexao{

    static function connect(){

        //Informações para acessar o servidor do banco de dados
        $host = "sqlsrv:Server=localhost;Database=SIGNA";
        $usuario = null;
        $senha = null;
        

        $con = new PDO($host,$usuario,$senha);
        
        //Ativando recurso de exibição de erro
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        return $con;//Retorna conexão para uso
    }
}
?>