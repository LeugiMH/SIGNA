<?php
include_once "model/feedback.php";

class FeedbackController
{
    //Cadastrar
    function enviarFeedback()
    {
        $email =  $_POST["inputEmail"];
        $rating =  $_POST["rating"];
        $assunto =  $_POST["inputAssunto"];
        $comentario =  $_POST["inputMessage"];
        $url =  $_POST["url"];
        #$usuario = $_POST["inputUsuario"];


        #Cria objeto da classe espécie e define valores
        $cmd = new Feedback();
        $cmd->IDESPECIME      = null;
        $cmd->TPUSUARIO      = 0;
        $cmd->AVALIACAO      = $rating;
        $cmd->IDASSUNTO      = $assunto;
        $cmd->TEXTO       = $comentario;
        $cmd->EMAIL = $email;
        $cmd->DATACAD      = date("d-m-Y h:i:s"); //Data atual de cadastro
        

        if($cmd->sendFeedback())  //Sucesso ao cadastrar espécie
        {
            setcookie("msgF","<div class='alert alert-success'>Feedback enviado com sucesso</div>",time() + 1,"/");
        }
        else
        {
            setcookie("msgF","<div class='alert alert-danger'>Erro ao enviar feedback</div>",time() + 1,"/");
        }

        echo("
                <script> 

                history.back();
                
            </script>
        ");
        echo 'hmmmmmmmm';

        if(isset($_COOKIE["msgF"]))
        {echo $_COOKIE["msgF"];}

        //echo'<script>console.log("'.$email.$rating.$assunto.$comentario.'")</script>';
    }

    #Consultar
    function buscar($id)
    {
        $feedback = new Feedback();
        $feedback->IDFEEDBACK = $id;
        return $feedback->buscar();
    }

    #Listar
    function listar()
    {
        $cmd = new Feedback();
        return $cmd->listar();
    }

    //Alterar
    function responderFeedback()
    {
        $idFeedback = $_POST["inputIdFeedback"];
        $email =  $_POST["inputEmail"];
        $rating =  $_POST["rating"];
        $assunto =  $_POST["inputAssunto"];
        $comentario =  $_POST["inputMessage"];
        $idAdmin =  $_SESSION["sessaoLogada"]->IDADMIN;
        $comentAdmin  =  $_POST["inputAltura"];
        
        //Cria objeto da classe espécie e define valores
        $cmd = new Feedback();
        $cmd->IDESPECIME      = null;
        $cmd->TPUSUARIO      = 0;
        $cmd->AVALIACAO      = $rating;
        $cmd->IDASSUNTO      = $assunto;
        $cmd->TEXTO       = $comentario;
        $cmd->IDADMIN = $idAdmin;
        $cmd->COMENT_ADMIN = $comentAdmin;
        $cmd->EMAIL = $email;
        $cmd->DATACAD      = date("d-m-Y h:i:s"); //Data atual de cadastro
        
        $busca = new Feedback();
        $busca->IDFEEDBACK = $idFeedback;
        $dadosFeedback = $busca->buscar();


        if($cmd->enviarComentario()) //Sucesso ao alterar espécie
        {
            setcookie("msgFeedback","<div class='alert alert-success'>Resposta cadastrada com sucesso.</div>",time() + 1,"/");
            header("location: ".URL."inicio");
        }
        else
        {
            setcookie("msgFeedback","<div class='alert alert-danger'>Erro ao alterar espécie</div>",time() + 1,"/");
            header("location: ".URL."inicio");
        }
    }

    //Excluir
    /*function excluirEspecie($id)
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
    }*/
}

if(isset($_POST['envFeedback']))
{
    $feedback = new FeedbackController();
    $feedback->enviarFeedback();
} 

?>
