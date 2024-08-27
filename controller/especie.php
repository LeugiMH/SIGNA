<?php
include_once "model/especie.php";

class EspecieController
{
    function listar()
    {
        $cmd = new Especie();
        return $cmd->listar();
    }
}

?>
