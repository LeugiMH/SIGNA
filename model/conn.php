<?php

class Conexao{

    static function connect()  
    {  
        echo " aaaaaaaaaaaaaaaaaaaaaaaaaaaa";
    

        $serverName = "L4-00\sqlexpress"; //serverName\instanceName

        // Como UID e PWD não são especificados no array $connectionInfo,
        // A conexão será tentada usando a Autenticação do Windows.
        $connectionInfo = array( "Database"=>"SIGNA", "UID"=>"sa", "PWD"=>"alunos");
        $conn = sqlsrv_connect( $serverName, $connectionInfo);

        if( $conn ) {
            echo "Connection established.<br />";
        }else{
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }
        
    }
}
?>