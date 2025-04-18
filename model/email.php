<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "resource/PHPMailer/src/Exception.php";
require_once "resource/PHPMailer/src/PHPMailer.php";
require_once "resource/PHPMailer/src/SMTP.php";

class Email
{
        //Atributos
        private $host = "smtp.titan.email";                 //servidor do protocolo de envio de email     
        private $emailRemetente;                            //email do remetente
        private $senhaRemetente;                            //senha do remetente
        private $nomeRemetente;                             //nome do remetente
        private $porta = Ambiente::PORTA_EMAIL;             //porta do servidor TLS/STARTTLS/SSL 465 ou 587
        private $emailDestinatario;                         //email a ser enviado
        private $conteudo;
        private $codsenha;

        //Método get
        function __get($atributo)
        {
            return $this->$atributo;
        }
    
        //Método set
        function __set($atributo, $valor)
        {
            $this->$atributo = $valor;
        }

        function enviarCodigo()
        {
            $url = $_SERVER["HTTP_HOST"] == "localhost" ? "https://signa.eco.br/" : URL;
            $default = file_get_contents($url."resource/css/defaultEmail.css");
            $default = str_replace("{{url}}", $url, $default);
            //Conteúdo da mensagem enviada
            $Conteudo = 
            "
            <head>
            <style type=\"text/css\">
                body
                {
                    height: 100vh;
                    width: 100%;
                }
                .text-center
                {
                    text-align: center;
                }
                .m-0
                {
                    margin: 0;
                }
                .my
                {
                    margin-top: 1.5rem !important;
                    margin-bottom: 1.5rem !important;
                }
                .p-0
                {
                    padding: 0;
                }
                .bg-secondary
                {
                    background-color: #6c757d!important;
                }
                .bg-verdee
                {
                    background-color: #007bff!important;
                }
                .bg-dark
                {
                    background-color: rgb(33, 37, 41)!important;
                }
                .text-white
                {
                    color: #fff!important;
                }
                .h-100
                {
                    height: 100%!important;
                }
                .d-flex
                {
                    display: flex!important;
                }
                .display-1
                {
                    font-size: 3rem;
                    font-weight: 300;
                    line-height: 1.2;
                }
                h1
                {
                    font-size: 3.5rem;
                    font-weight: 300;
                    line-height: 1.2;
                }
                h2
                {
                    font-size: 3rem;
                    font-weight: 300;
                    line-height: 1.2;
                }
                .align-content-center
                {
                    align-content: center!important;
                }
                .justify-content-center
                {
                    justify-content: center!important;
                }
                .me-3
                {
                    margin-right: 1rem!important;
                }
                .mt-3
                {
                    margin-top: 1rem!important;
                }
                .my-5
                {
                    margin-top: 3rem!important;
                    margin-bottom: 3rem!important;
                }
                .p-3
                {
                    padding: 1rem!important;
                }
                .mb-4
                {
                    margin-bottom: 1.5rem!important;
                }
                .mt-auto
                {
                    margin-top: auto!important;
                }
                .position-relative
                {
                    position: relative!important;
                }
                .container-fluid
                {
                    width: 100%;
                }
                .rounded-3
                {
                    border-radius: 0.3rem !important;
                }

                /* CSS do email */
                $default
            </style>
            </head>
            <body>
            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr class=\"folhas\">
                    <th style=\"text-center align-content-center justify-content-center\">
                        <h1 class=\"display-1 text-center mb-4\">Recuperação de senha</h1>
                        <div class=\"p-0 my-5 text-center align-content-center justify-content-center rounded-3\" style=\"z-index: 2; width:70%; margin:auto;\">
                            <!-- Conteúdo -->
                            <center>
                                <div class=\"bg-verde text-center text-white rounded-3 m-0 p-3\">
                                    <h3>Use o código abaixo para recuperar o seu acesso no SIGNA</h3>
                                    <h2>$this->codsenha</h2>
                                </div>
                            </center>
                        </div>
                    </th>
                </tr>
                <tr class=\"text-center justify-content-center align-content-center\">
                    <td class=\"rodape text-white mt-auto bg-dark text-center justify-content-center align-content-center m-0 p-3\">
                        <div class=\"text-center justify-content-center align-content-center\" style=\"margin:auto;\">
                            <a href=\"https://www.facebook.com/fatecfrancodarocha/?locale=pt_BR\" target=\"_blank\" class=\"me-3\">
                                <img src=\"".$url."resource/imagens/icons/facebook.png\" alt=\"Facebook icon\" style=\"width: 64px;\">
                            </a>
                            <a href=\"https://www.instagram.com/fatecfrancodarocha/\" class=\"me-3\">
                                <img src=\"".$url."resource/imagens/icons/instagram.png\" alt=\"Instragram logo\" target=\"_blank\" style=\"width: 64px;\">
                            </a>
                            <a href=\"https://www.linkedin.com/in/fatec-franco-da-rocha-152720231/?originalSubdomain=br\" target=\"_blank\" class=\"me-3\">
                                <img src=\"".$url."resource/imagens/icons/linkedin.png\" alt=\"Linkedin logo\" style=\"width: 64px;\">
                            </a>
                            <a href=\"https://github.com/LeugiMH/SIGNA\" class=\"\">
                                <img src=\"".$url."resource/imagens/icons/github.png\" alt=\"Github logo\" style=\"width: 64px;\">
                            </a>
                        </div>
                        <p class=\"mt-3\"> Siga a Fatec Franco da Rocha nas redes sociais! </p>
                    </td>
                </tr>
            </table>
            </body>
            ";

            $email = new PHPMailer(true);
            
            try{

                //Configurações
                $email->isSMTP();
                $email->Host = $this->host;
                $email->SMTPAuth = true;
                $email->Username = $this->emailRemetente;
                $email->Password = $this->senhaRemetente;
                $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //criptografia do email
                $email->Port = $this->porta;
                $email->CharSet = "UTF-8";
                $email->isHTML(true);
                $email->setLanguage('pt_br');

                //Informações de quem enviou
                $email->setFrom($this->emailRemetente, $this->nomeRemetente); 
                $email->addReplyTo($this->emailRemetente);

                //endereço para qual será enviado o email
                $email->addAddress($this->emailDestinatario);

                //Corpo do e-mail
                $email->Subject = "Redefinição de senha";//Assunto
                
                //conteúdo
                $email->Body = $Conteudo;

                //texto alternativo caso não possua suporte a HTML
                $email->AltBody = "Foi soliciatada a recuperação da senha na sua conta \n\nCódigo de recuperação: $this->codsenha";
                    
                //envia
                $email->send();
                echo "<script>alert('Email de recuperação enviado com sucesso!');</script>";
            }
            catch(Exception $e)
            {
                echo "<script>alert('Mensagem não foi enviada. Error: {$email->ErrorInfo}');</script>";
            }
        }

        function enviarRespostaFeedback()
        {
            //Conteúdo da mensagem enviada
            $ConteudoMensagem = 
            "
            <p><b>Obrigado pelo feedback! </b><br/>
            </p>
            
            <p>$this->conteudo</b></p>

            ";

            $email = new PHPMailer(true);
            
            try{

                //Configurações
                $email->isSMTP();
                $email->Host = $this->host;
                $email->SMTPAuth = true;
                $email->Username = $this->emailRemetente;
                $email->Password = $this->senhaRemetente;
                $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           //criptografia do email
                $email->Port = $this->porta;
                $email->CharSet = "UTF-8";
                $email->setLanguage('pt_br');

                //Informações de quem enviou
                $email->setFrom($this->emailRemetente, $this->nomeRemetente); 
                $email->addReplyTo($this->emailRemetente);

                //endereço para qual será enviado o email
                $email->addAddress($this->emailDestinatario);

                //define se é html
                $email->isHTML(true);

                //Corpo do e-mail
                $email->Subject = "Feedback SIGNA";//Assunto
                
                //conteúdo
                $email->Body = $ConteudoMensagem;

                //texto alternativo caso não possua suporte a HTML
                $email->AltBody = "Muito obrigado pelo seu feedback SIGNA\n\n$this->conteudo";
                    
                //envia
                $email->send();
                echo "<script>alert('Email enviado com sucesso!');</script>";
            }
            catch(Exception $e)
            {
                echo "<script>alert('Mensagem não foi enviada. Error: {$email->ErrorInfo}');</script>";
            }
        }
    }
?>