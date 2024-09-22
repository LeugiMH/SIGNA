<?php
include_once "model/especie.php";

class EspecieController
{
    function listar()
    {
        $cmd = new Especie();
        return $cmd->listar();
    }
    function CadastrarEspecie()
    {
        $nomeCie =  $_POST["inputNomeCie"];
        $nomePop =  $_POST["inputNomePop"];
        $Familia =  $_POST["inputFamilia"];
        $habitat =  $_POST["inputHabitat"];
        $altura  =  $_POST["inputAltura"];
        #$img    =  $_POST["inputImagem"];
        $img     = 'Nome Imagem Exemplo.jpg';
        $ImgDesc =  $_POST["inputImgDesc"];
        
        //Cria objeto da classe espécie e define valores
        $cmd = new Especie();
        $cmd->NOMECIE      = $nomeCie;
        $cmd->NOMEPOP      = $nomePop;
        $cmd->FAMILIA      = $Familia;
        $cmd->HABITAT      = $habitat;
        $cmd->ALTURA       = $altura;
        $cmd->IMAGEM       = $img;
        $cmd->DESCRICAOIMG = $ImgDesc;
        $cmd->DATACAD      = date("d-m-Y h:i:s"); //Data atual de cadastro
        $cmd->IDCADADM     = $_SESSION["sessaoLogada"]->IDADMIN; //Id do administrador logado
        
        var_dump($cmd->Cadastrar());
        if($cmd->Cadastrar())
        {
            setcookie("msg","<div class='alert alert-success'>Espécie cadastrada com sucesso</div>");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar espécie</div>");
        }
        header("location: ".URL."especies/cadastro");
    }
}

?>
