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
            //Conteúdo da mensagem enviada
            $Conteudo = 
            "
            <p><b>Recuperação de senha</b><br/>
            Foi solicitada a recuperação da senha na sua conta</p>
            
            <p>Codigo de Confirmação: <b>$this->codsenha</b></p>

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
    }
?>