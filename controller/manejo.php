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

        #Cria objeto da classe espécie e define valores
        $cmd = new Manejo();
        $cmd->IDESPECIME = $especime;
        $cmd->TIPOMANEJO = $tipoManejo;
        $cmd->DATAMANEJO = $dataManejo;  

        $cmd->cadastrar();

        header("Location: ".URL."inicio");
    }

    #Consultar
    function buscar($id)
    {
        $cmd = new Manejo();
        $cmd->IDMANEJO = $id;
        return $cmd->buscar();
    }

    /*
    #Listar
    function listar()
    {
        $cmd = new Manejo();
        return $cmd->listar();
    }*/

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
            switch($r->TIPOMANEJO)
            {
                case "RG":
                    $r->TIPOMANEJO = "Rega";
                break;
                case "PD":
                    $r->TIPOMANEJO = "Poda";
                break;
                case "AD":
                    $r->TIPOMANEJO = "Adubação";
                break;
                case "CP":
                    $r->TIPOMANEJO = "Controle de Praga";
                break;
                case "OT":
                    $r->TIPOMANEJO = "Outro";
                break;
                default:
                $r->TIPOMANEJO = "Desconhecido";
            }
        }

        if($json)
            echo json_encode($return);
        else
            return $return;
    }

    #Excluir
    function excluir($id)
    {
        $cmd = new Manejo();
        $cmd->IDMANEJO = $id;

        $cmd->excluir();

        header("Location: ".URL."inicio#sectionFeedbacks");
    }
}   

?>
