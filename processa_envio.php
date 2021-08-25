<?php

    require './bibliotecas/PHPmailer/Exception.php';
    require './bibliotecas/PHPmailer/OAuth.php';
    require './bibliotecas/PHPmailer/PHPMailer.php';
    require './bibliotecas/PHPmailer/POP3.php';
    require './bibliotecas/PHPmailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
   

    class Mensagem{
        private $para;
        private $assunto;
        private $mensagem;
        public $status = array('codigo_status'=>null,'descricao_status'=>'');

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo ,$valor){
            $this->$atributo = $valor;
        }

        public function mensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }
            return true;


        }
    }

    $mensagem = new Mensagem();
    $mensagem->__set('para',$_POST['para']);
    $mensagem->__set('assunto', $_POST['assunto']);
    $mensagem->__set('mensagem', $_POST['mensagem']);

   
    if(! $mensagem->mensagemValida()){
        echo 'Mensagem  não e Válida';
        header('location:index.php');
    }

    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug =false;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host= 'smtp.gmail.com '    ;              //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '
    sendtesteemail2021@gmail.com
    ';                     //SMTP username
    $mail->Password   = 'sendemail2021';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('sendtesteemail2021@gmail.com', 'Send Email');
    $mail->addAddress($mensagem->__get('para'));     //Add a recipient
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = 'E necessario utlizar um client que utilize HTML para ter acesso total ao conteúdo dessa mensagem';

    $mail->send();
    $mensagem->status['codigo_status']= 1;
    $mensagem->status['descricao_status']= 'E-mail Enviado com sucesso!';
    
} catch (Exception $e) {
    $mensagem->status['codigo_status']= 2;
    $mensagem->status['descricao_status']= 'Não foi possivel enviar esse E-mail tente mais tarde!';
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Mail Send</title>

    <!-- CSS Bootsrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
   <div class="container">
        <div class="py-3 text-center">
			<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
			<h2>Send Mail</h2>
			<p class="lead">Seu app de envio de e-mails particular!</p>
		</div>

        <div class="row">
            <div class="col-md-12">
                <?php
                    if($mensagem->status['codigo_status']==1){
                ?>
                    <div class="container">
                        <h1 class="display-4 text-success">Sucesso</h1>
                        <p class="">Mensagem enviada com sucesso!</p>
                        <a href="index.php" class="btn btn-success mt-5 text-white">Voltar</a>


                    </div>


                <?php } ?>

                <?php
                    if($mensagem->status['codigo_status']==2){
                ?>
                    <div class="container">
                        <h1 class="display-4 text-danger">Ops!</h1>
                        <p>Não foi possivel enviar esse E-mail tente mais tarde!</p>
                        <a href="index.php" class="btn btn-success mt-5 text-white">Voltar</a>


                    </div>
                

                <?php } ?>


            </div>

        </div>


   </div>
    
</body>
</html>