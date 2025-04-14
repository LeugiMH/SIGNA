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
            <>
            <style>
            $default
            </style>
            </head>
            <body>
                <div class=\"corpo min-vh-100 h-100\">
                    <div class=\"conteudo bg-secondary h-100 clouds\">
                        <div class=\"container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100\">
                            <section class=\"col-sm-8 col-lg-6 col-xl-4 p-0 my-5\" style=\"z-index: 2;\">
                                <!-- Conteúdo -->
                                <header class=\"display-1 text-center mb-4\">OLÁ \"Nome do usuário\"</header>
                                <article class=\"bg-verde p-3 p-lg-5 rounded-4 text-white m-0\">
                                    <p>Use o código abaixo para recuperar o seu acesso no SIGNA</p>
                                    <h1>$this->codsenha</h1>
                                </article>
                            </section>
                            <img src=\"".$url."resource/ui/bg/bg_nuvem_completo.png\" class=\"nuvem nuvem-mid p-0\" style=\"z-index: 0!important;\">
                        </div>
                    </div>
                    <footer class=\"rodape text-white mt-auto\">
                        <div class=\"align-content-center bg-dark text-center justify-content-center m-0 p-3\">
                            <div class=\"d-flex d-flex-row text-center justify-content-center\">
                                <a href=\"https://www.facebook.com/fatecfrancodarocha/?locale=pt_BR\" target=\"_blank\" class=\"me-3\">
                                    <img src=\"".$url."resource/imagens/icons/facebook.png\" alt=\"Facebook icon\" style=\"width: 64px;\">
                                </a>
                                <a href=\"https://www.instagram.com/fatecfrancodarocha/\" class=\"me-3\">
                                    <img src=\"".$url."resource/imagens/icons/instagram.png\" alt=\"Instragram logo\" target=\"_blank\" style=\"width: 64px;\">
                                </a>
                                <a href=\"https://www.linkedin.com/in/fatec-franco-da-rocha-152720231/?originalSubdomain=br\" target=\"_blank\" class=\"me-3\">
                                <img src=\"".$url."resource/imagens/icons/linkedin.png\" alt=\"Linkedin logo\" style=\"width: 64px;\">
                                </a>
                                <a href=\"https://github.com/LeugiMH/SIGNA\" class=\"me-3\">
                                <img src=\"".$url."resource/imagens/icons/github.png\" alt=\"Github logo\" style=\"width: 64px;\">
                                </a>
                            </div>
                            <p class=\"mt-3\"> Siga a Fatec Franco da Rocha nas redes sociais! </p>
                        </div>
                    </footer>
                </div>
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