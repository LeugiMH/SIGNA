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
        $conserv  =  $_POST["inputConserv"];
        $ImgDesc =  $_POST["inputImgDesc"];
        $atributos = $_POST["atributo"];

        //Cria objeto da classe espécie e define valores
        $cmd = new Especie();
        $cmd->NOMECIE      = $nomeCie;
        $cmd->NOMEPOP      = $nomePop;
        $cmd->FAMILIA      = $Familia;
        $cmd->HABITAT      = $habitat;
        $cmd->CONSERV      = $conserv;
        $cmd->ALTURA       = $altura;
        $cmd->DESCRICAOIMG = $ImgDesc;
        $cmd->DATACAD      = date("Y-m-d H:i:s"); //Data atual de cadastro
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

        $lastId = $cmd->cadastrar();
        if($lastId)  //Sucesso ao cadastrar espécie
        {
            setcookie("msg","<div class='alert alert-success'>Espécie cadastrada com sucesso</div>",time() + 1,"/");

            //Mover imagem para pastas no servidor
            $pastaDestino = "resource/imagens/especies/$novoNome";   //pasta destino
            move_uploaded_file($nomeTemp, $pastaDestino);       //mover o arquivo 

            //Cadastra os atributos
            $atr = new Especie();
            $atr->IDESPECIE = $lastId;
            foreach ($atributos as $atrId=>$atrDesc)
            {
                if(!empty($atrDesc))
                {
                    $atr->IDATRIBUTO = $atrId;
                    $atr->DESCRICAO = $atrDesc;
                    $atr->associarAtributo();
                }
            }
        }
        else
        {
            //setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar espécie</div>",time() + 1,"/");
        }
        //var_dump($_POST);
        header("location: ".URL."especies/cadastro");
    }

    //Consultar
    function buscar($id)
    {
        $especie = new Especie();
        $especie->IDESPECIE = $id;
        return $especie->buscar();
    }

    function buscarAtrAssoc($id)
    {
        $atributos = new Especie();
        $atributos->IDESPECIE = $id;
        return $atributos->buscarAtrAssoc();
    }

    //Listar
    function listar()
    {
        $cmd = new Especie();
        return $cmd->listar();
    }
    function listarUsu()
    {
        $cmd = new Especie();
        return $cmd->listarUsu();
    }

    //Alterar
    function alterarEspecie()
    {
        $idEspecie =  $_POST["inputId"];
        $nomeCie =  $_POST["inputNomeCie"];
        $nomePop =  $_POST["inputNomePop"];
        $Familia =  $_POST["inputFamilia"];
        $habitat =  $_POST["inputHabitat"];
        $conserv  =  $_POST["inputConserv"];
        $altura  =  $_POST["inputAltura"];
        $ImgDesc =  $_POST["inputImgDesc"];
        $atributos = $_POST["atributo"];
        
        //Cria objeto da classe espécie e define valores
        $cmd = new Especie();
        $cmd->IDESPECIE    = $idEspecie;
        $cmd->NOMECIE      = $nomeCie;
        $cmd->NOMEPOP      = $nomePop;
        $cmd->FAMILIA      = $Familia;
        $cmd->HABITAT      = $habitat;
        $cmd->CONSERV       = $conserv;
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
            //Mover imagem para pastas no servidor
            $pastaDestino = "resource/imagens/especies/$novoNome";   //pasta destino
            move_uploaded_file($nomeTemp, $pastaDestino);       //mover o arquivo 

            header("location: ".URL."especies/lista");

            //Atualiza os atributos
            $atr = new Especie();
            $atr->IDESPECIE = $idEspecie;
            $atr->desAssociarAtributo();
            foreach ($atributos as $atrId=>$atrDesc)
            {
                if(!empty($atrDesc))
                {
                    $atr->IDATRIBUTO = $atrId;
                    $atr->DESCRICAO = $atrDesc;
                    $atr->associarAtributo();
                }
            }
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
