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

        //Tratar URL
        $filtro = [null,"","inicio"];
        $url = explode("/",$url);
        $especime = in_array($url[0],$filtro) && !($url[0] == "especime") ? null : $url[1];


        #Cria objeto da classe espécie e define valores
        $cmd = new Feedback();
        $cmd->IDESPECIME = $especime;
        $cmd->TPUSUARIO = 0;
        $cmd->AVALIACAO = $rating;
        $cmd->IDASSUNTO = $assunto;
        $cmd->TEXTO = $comentario;
        $cmd->EMAIL = $email;
        $cmd->DATACAD = date("Y-m-d h:i:s"); //Data atual de cadastro
        

        if($cmd->sendFeedback())  //Sucesso ao Alterar o Feedback
        {
            echo "<script>alert('Feedback enviado com sucesso');</script>";
            setcookie("msgF","<div class='alert alert-success'>Feedback enviado com sucesso</div>",time() + 1,"/");
        }
        else
        {
            echo "<script>alert('Erro ao enviar feedback');</script>";
            setcookie("msgF","<div class='alert alert-danger'>Erro ao enviar feedback</div>",time() + 1,"/");
        }

        echo("
            <script> 
                history.back();
            </script>
        ");

        if(isset($_COOKIE["msgF"]))
        {echo $_COOKIE["msgF"];}

        //echo'<script>console.log("'.$email.$rating.$assunto.$comentario.'")</script>';
    }

    #Consultar
    function buscar($id)
    {
        $feedback = new Feedback();
        $feedback->IDFEEDBACK = $id;
        echo json_encode($feedback->buscar());
    }

    #Listar
    function listar()
    {
        $cmd = new Feedback();
        return $cmd->listar();
    }

    //Alterar
    function enviarRespostaAdmin()
    {
        $idFeedback = $_POST["inputIdFeedback"];
        $idAdmin =  $_SESSION["sessaoLogada"]->IDADMIN;
        $comentAdmin  =  $_POST["inputResposta"];
        $emailDest = $_POST["inputEmail"];
        
        //Cria objeto da classe espécie e define valores
        $cmd = new Feedback();
        $cmd->IDADMIN = $idAdmin;
        $cmd->COMENT_ADMIN = $comentAdmin;
        $cmd->IDFEEDBACK = $idFeedback;
        $cmd->DATAFECH = date("Y-m-d h:i:s");  //Data atual de fechamento

        if($cmd->enviarRespostaAdmin()) //Sucesso ao Enviar Resposta
        {
            if(isset($emailDest) && $emailDest != "")
            {
                //Envia Email com o código de recuperação
                $email = new Email();
                $email->emailRemetente = Ambiente::EMAIL_FEEDBACK; 
                $email->senhaRemetente = Ambiente::SENHA_FEEDBACK; 
                $email->nomeRemetente = "Resposta de Feedback";
                $email->conteudo = $comentAdmin;
                $email->emailDestinatario = $emailDest;
                $email->enviarRespostaFeedback();
                setcookie("msgFeedback","<div class='alert alert-success'>Resposta cadastrada com sucesso.</div>",time() + 1,"/");
            }
        }
        else
        {
            setcookie("msgFeedback","<div class='alert alert-danger'>Erro ao enviar resposta</div>",time() + 1,"/");
        }
        header("location: ".URL."inicio");
    }
}

if(isset($_POST['envFeedback']))
{
    $feedback = new FeedbackController();
    $feedback->enviarFeedback();
} 

?>
