<?php
include_once "model/especime.php";

class EspecimeController
{
    function listar()
    {
        $cmd = new Especime();
        return $cmd->listar();
    }
}

?>
