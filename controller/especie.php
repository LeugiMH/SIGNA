<?php
include_once "model/especie.php";

class EspecieController
{
    //Cadastrar
    function cadastrarEspecie()
    {
        $nomeCie =  $_POST["inputNomeCie"];
        $nomePop =  $_POST["inputNomePop"];
        $Familia =  $_POST["inputFamilia"];
        $habitat =  $_POST["inputHabitat"];
        $altura  =  $_POST["inputAltura"];
        $ImgDesc =  $_POST["inputImgDesc"];

        //Cria objeto da classe espécie e define valores
        $cmd = new Especie();
        $cmd->NOMECIE      = $nomeCie;
        $cmd->NOMEPOP      = $nomePop;
        $cmd->FAMILIA      = $Familia;
        $cmd->HABITAT      = $habitat;
        $cmd->ALTURA       = $altura;
        $cmd->DESCRICAOIMG = $ImgDesc;
        $cmd->DATACAD      = date("d-m-Y h:i:s"); //Data atual de cadastro
        $cmd->IDCADADM     = $_SESSION["sessaoLogada"]->IDADMIN; //Id do administrador logado
        
        $novoNome = "";
        $nomeTemp = "";
        //Cadastra imagem
        if($_FILES["inputImagem"]["error"] == 0)
        {
            $nomeArquivo = $_FILES["inputImagem"]["name"];    //Nome do arquivo
            $nomeTemp =    $_FILES["inputImagem"]["tmp_name"];   //nome temporário
            
            //pegar a extensão do arquivo
            $info = new SplFileInfo($nomeArquivo);
            $extensao = $info->getExtension();
            
            if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "webp")
            {
                setcookie("msg","<div class='alert alert-danger'>Imagem deve ter a extensão .JPG, .JPEG, .PNG, ou .WEBP.</div>",time() + 1,"/");
                header("location: ".URL."especies/cadastro");
                return;
            }
            //gerar novo nome
            $novoNome = md5(microtime()) . ".$extensao";
            
            //enviando para o banco de dados
            $cmd->IMAGEM = $novoNome;
        }

        if($cmd->cadastrar())  //Sucesso ao cadastrar espécie
        {
            setcookie("msg","<div class='alert alert-success'>Espécie cadastrada com sucesso</div>",time() + 1,"/");

            //Mover imagem para pastas no servidor
            $pastaDestino = "resource/imagens/especies/$novoNome";   //pasta destino
            move_uploaded_file($nomeTemp, $pastaDestino);       //mover o arquivo 
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar espécie</div>",time() + 1,"/");
        }
        header("location: ".URL."especies/cadastro");
    }

    //Consultar
    function buscar($id)
    {
        $especie = new Especie();
        $especie->IDESPECIE = $id;
        return $especie->buscar();
    }

    //Listar
    function listar()
    {
        $cmd = new Especie();
        return $cmd->listar();
    }

    //Alterar
    function alterarEspecie()
    {
        $idEspecie =  $_POST["inputId"];
        $nomeCie =  $_POST["inputNomeCie"];
        $nomePop =  $_POST["inputNomePop"];
        $Familia =  $_POST["inputFamilia"];
        $habitat =  $_POST["inputHabitat"];
        $altura  =  $_POST["inputAltura"];
        $ImgDesc =  $_POST["inputImgDesc"];
        
        //Cria objeto da classe espécie e define valores
        $cmd = new Especie();
        $cmd->IDESPECIE    = $idEspecie;
        $cmd->NOMECIE      = $nomeCie;
        $cmd->NOMEPOP      = $nomePop;
        $cmd->FAMILIA      = $Familia;
        $cmd->HABITAT      = $habitat;
        $cmd->ALTURA       = $altura;
        $cmd->DESCRICAOIMG = $ImgDesc;
        
        $busca = new Especie();
        $busca->IDESPECIE = $idEspecie;
        $dadosEspecie = $busca->buscar();

        $nomeTemp = "";
        $novoNome = "";
        //Caso imagem seja enviada sem erros
        if($_FILES["inputImagem"]["error"] == 0)
        {
            //Espécie já possuia uma imagem
            if(isset($dadosEspecie->IMAGEM))
            {
                unlink("resource/imagens/especies/$dadosEspecie->IMAGEM"); //excluir a imagem
            }
            $nomeArquivo = $_FILES["inputImagem"]["name"];       //Nome do arquivo
            $nomeTemp =    $_FILES["inputImagem"]["tmp_name"];      //nome temporário
            
            //pegar a extensão do arquivo
            $info = new SplFileInfo($nomeArquivo);
            $extensao = $info->getExtension();
            
            if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "webp")
            {
                setcookie("msg","<div class='alert alert-danger'>Imagem deve ter a extensão .JPG, .JPEG, .PNG, ou .WEBP.</div>",time() + 1,"/");
                header("location: ".URL."especies/altera/$idEspecie");
                return;
            }
            //gerar novo nome
            $novoNome = md5(microtime()) . ".$extensao";
            
            //enviando para o banco
            $cmd->IMAGEM = $novoNome;
        }
        else //Caso não seja enviada mantém imagem original
        {
            $cmd->IMAGEM = $dadosEspecie->IMAGEM;
        }

        if($cmd->alterar()) //Sucesso ao alterar espécie
        {
            header("location: ".URL."especies/lista");

            //Mover imagem para pastas no servidor
            $pastaDestino = "resource/imagens/especies/$novoNome";   //pasta destino
            move_uploaded_file($nomeTemp, $pastaDestino);       //mover o arquivo 
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao alterar espécie</div>",time() + 1,"/");
            header("location: ".URL."especies/altera/$idEspecie");
        }
    }

    //Excluir
    function excluirEspecie($id)
    {
        $idEspecie = $id;

        $cmd = new Especie();
        $cmd->IDESPECIE = $idEspecie;

        $especie = $cmd->buscar();

        if($cmd->excluir())
        {
            unlink("resource/imagens/especies/$especie->IMAGEM"); //Excluir imagem
        }
        else
        {
            setcookie("msgLista","<div class='alert alert-danger'>Erro ao excluir a espécie, é possível que essa espécie possua algum espécime relacionado.</div>",time() + 1,"/");
        }
        header("location: ".URL."especies/lista");
    }
}

?>
