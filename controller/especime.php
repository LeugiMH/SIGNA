<?php
include_once "model/especime.php";

class EspecimeController
{
    //Cadastrar
    function cadastrarEspecime()
    {
        $idEspecie          =  $_POST["inputEspecie"];
        $coord              =  $_POST["inputCoord"];
        $status             =  $_POST["inputStatus"];
        $DAP                =  $_POST["inputDAP"];
        $inputDatPlant      =  date("Y-m-d",strtotime($_POST["inputDatPlant"]));
        $ImgDesc            =  $_POST["inputImgDesc"];

        //Cria objeto da classe espécime e define valores
        $cmd = new Especime();
        $cmd->IDESPECIE     = $idEspecie;
        $cmd->COORD         = $coord;
        $cmd->ESTADO        = $status;
        $cmd->DAP           = $DAP;
        $cmd->DATPLANT      = $inputDatPlant;
        $cmd->DESCRICAOIMG  = $ImgDesc;
        $cmd->DATACAD       = date("Y-m-d H:i:s"); //Data atual de cadastro
        $cmd->IDCADADM      = $_SESSION["sessaoLogada"]->IDADMIN; //Id do administrador logado
        
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
                setcookie("coord",$coord,time() + 1,"/");
                header("location: ".URL."especimes/cadastro");
                return;
            }
            //gerar novo nome
            $novoNome = md5(microtime()) . ".$extensao";
            
            //enviando para o banco de dados
            $cmd->IMAGEM = $novoNome;
        }

        if($cmd->cadastrar())  //Sucesso ao cadastrar espécime
        {
            //Mover imagem para pastas no servidor
            $pastaDestino = "resource/imagens/especimes/$novoNome";   //pasta destino
            move_uploaded_file($nomeTemp, $pastaDestino);       //mover o arquivo 

            header("location: ".URL."inicio");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao cadastrar espécime</div>",time() + 1,"/");
            setcookie("coord",$coord,time() + 1,"/");
            header("location: ".URL."especimes/cadastro");
        }
    }

    //Consultar
    function buscar($id)
    {
        $especime = new Especime();
        $especime->IDESPECIME = $id;
        return $especime->buscar();
    }
    function buscarTudo($id)
    {
        $especime = new Especime();
        $especime->IDESPECIME = $id;
        return $especime->buscarTudo();
    }

    //Listar
    function listarAdm()
    {
        $especimes = new Especime();
        return $especimes->listarAdm();
    }
    function listarUsu()
    {
        $especimes = new Especime();
        return $especimes->listarUsu();
    }

    //Alterar
    function alterarEspecime()
    {
        $idEspecime =  $_POST["inputEspecime"];
        $idEspecie =  $_POST["inputEspecie"];
        $coord =  $_POST["inputCoord"];
        $status =  $_POST["inputStatus"];
        $DAP =  $_POST["inputDAP"];
        $inputDatPlant  =  date("Y-m-d",strtotime($_POST["inputDatPlant"]));
        $ImgDesc =  $_POST["inputImgDesc"];
        
        //Cria objeto da classe espécime e define valores
        $cmd = new Especime();
        $cmd->IDESPECIME    = $idEspecime;
        $cmd->IDESPECIE     = $idEspecie;
        $cmd->COORD         = $coord;
        $cmd->ESTADO        = $status;
        $cmd->DAP           = $DAP;
        $cmd->DATPLANT      = $inputDatPlant;
        $cmd->DESCRICAOIMG  = $ImgDesc;
        
        $busca = new Especime();
        $busca->IDESPECIME = $idEspecime;
        $dadosEspecime = $busca->buscar();

        $nomeTemp = "";
        $novoNome = "";
        //Caso imagem seja enviada sem erros
        if($_FILES["inputImagem"]["error"] == 0)
        {
            //espécime já possuia uma imagem
            if(isset($dadosEspecime->IMAGEM))
            {
                unlink("resource/imagens/especimes/$dadosEspecime->IMAGEM"); //excluir a imagem
            }
            $nomeArquivo = $_FILES["inputImagem"]["name"];       //Nome do arquivo
            $nomeTemp =    $_FILES["inputImagem"]["tmp_name"];      //nome temporário
            
            //pegar a extensão do arquivo
            $info = new SplFileInfo($nomeArquivo);
            $extensao = $info->getExtension();
            
            if($extensao != "jpg" && $extensao != "png" && $extensao != "jpeg" && $extensao != "webp")
            {
                setcookie("msg","<div class='alert alert-danger'>Imagem deve ter a extensão .JPG, .JPEG, .PNG, ou .WEBP.</div>",time() + 1,"/");
                header("location: ".URL."especimes/altera/$dadosEspecime->IDESPECIME");
                return;
            }
            //gerar novo nome
            $novoNome = md5(microtime()) . ".$extensao";
            
            //enviando para o banco
            $cmd->IMAGEM = $novoNome;
        }
        else //Caso não seja enviada mantém imagem original
        {
            $cmd->IMAGEM = $dadosEspecime->IMAGEM;
        }

        if($cmd->alterar()) //Sucesso ao alterar espécime
        {
            //Mover imagem para pastas no servidor
            $pastaDestino = "resource/imagens/especimes/$novoNome";   //pasta destino
            move_uploaded_file($nomeTemp, $pastaDestino);       //mover o arquivo 
            header("location: ".URL."inicio");
        }
        else
        {
            setcookie("msg","<div class='alert alert-danger'>Erro ao alterar espécime</div>",time() + 1,"/");
            header("location: ".URL."especimes/altera/$idEspecime");
        }
    }
}

?>
