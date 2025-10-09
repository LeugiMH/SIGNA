<?php
include_once "model/manejo.php";

class ManejoController
{
    //Cadastrar
    function cadastrar()
    {

        $especime = $_POST["inputEspecime"];
        $tipoManejo = $_POST["inputTipoManejo"];
        $dataManejo = date("Y-m-d",strtotime($_POST["inputDataManejo"]));

        // Se for um lote, chama o método de cadastrar lote
        if(count(explode(",",$especime)) > 1){return $this->cadastrarLote();}

        #Cria objeto da classe espécie e define valores
        $cmd = new Manejo();
        $cmd->IDESPECIME = $especime;
        $cmd->TIPOMANEJO = $tipoManejo;
        $cmd->DATAMANEJO = $dataManejo;  

        echo json_encode($cmd->cadastrar());

        //header("Location: ".URL."inicio");
    }

    function cadastrarLote()
    {
        $especimes = $_POST["inputEspecime"];
        $tipoManejo = $_POST["inputTipoManejo"];
        $dataManejo = date("Y-m-d",strtotime($_POST["inputDataManejo"]));

        #Cria objeto da classe espécie e define valores
        $especimes = explode(",",$especimes);
        foreach($especimes as $especime)
        {
            $cmd = new Manejo();
            $cmd->IDESPECIME = $especime;
            $cmd->TIPOMANEJO = $tipoManejo;
            $cmd->DATAMANEJO = $dataManejo;  
    
            $sucesso = $cmd->cadastrar();
            //header("Location: ".URL."inicio");
        }
        echo json_encode($sucesso);
    }

    #Consultar
    function buscar($id)
    {
        $cmd = new Manejo();
        $cmd->IDMANEJO = $id;
        return $cmd->buscar();
    }

    function formataTipos(&$tipo)
    {
        switch($tipo)
        {
            case "RG":
                $tipo = "Rega";
            break;
            case "PD":
                $tipo = "Poda";
            break;
            case "AD":
                $tipo = "Adubação";
            break;
            case "CP":
                $tipo = "Controle de Praga";
            break;
            case "OT":
                $tipo = "Outro";
            break;
            default:
            $tipo = "Desconhecido";
        }
    }

    /** Listar manejos por espécime
     * @param int $id ID do espécime para listar os manejos daquele espécime.
     * @param bool $json define se o retorno será em JSON.
     * @return array objeto ou JSON com os manejos daquele espécime.
     */
    function listar($id = null, $json = false)
    {
        $cmd = new Manejo();
        $cmd->IDESPECIME = $id;

        if(isset($id) and !empty($id))
            $return = $cmd->listarPorEspecime();
        else
            $return = $cmd->listar();

        // Formata os dados
        foreach($return as $r)
        {
            // Formata a data
            $r->DATAMANEJO = date("d/m/Y",strtotime($r->DATAMANEJO));

            // Formata o tipo de manejo
            $this->formataTipos($r->TIPOMANEJO);
        }

        if($json)
            echo json_encode($return);
        else
            return $return;
    }

    function ultimoDoTipo($id)
    {
        $cmd = new Manejo();
        $cmd->IDESPECIME = $id;

        $return = $cmd->UltimoDoTipo();

        // Formata os dados
        foreach($return as $r)
        {
            // Formata a data
            $r->DATAMANEJO = date("d/m/Y",strtotime($r->DATAMANEJO));

            // Formata o tipo de manejo
            $this->formataTipos($r->TIPOMANEJO);
        }

        return $return;
    }

    #Excluir
    function excluir($id)
    {
        $cmd = new Manejo();
        $cmd->IDMANEJO = $id;

        echo json_encode($cmd->excluir());

        //header("Location: ".URL."inicio#sectionFeedbacks");
    }
}   

?>
