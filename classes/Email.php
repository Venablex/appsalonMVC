<?php 

namespace Email;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email,$nombre,$token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function sendMail()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->addAddress('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon','AppSalon.com');

        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = <<<HTML
            <html>
                <p><strong>Hola $this->nombre</strong> Has creado tu cuenta en App Salon, confírmala presionando en el siguiente enlace</p>

                <p>Presiona aquí: <a href="{$_ENV['APP_URL']}/confirmar-cuenta?token={$this->token}">Confirmar Cuenta</a></p>

                <p>Si tu no solicistaste esta cuenta, puedes ignorar el mensaje</p>
            </html>
        HTML;

        $mail->Body = $contenido;

        $mail->send();
    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->addAddress('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon','AppSalon.com');

        $mail->Subject = 'Reestablece tu Contraseña';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = <<<HTML
            <html>
                <p><strong>Hola $this->nombre</strong> Has solicitado reestablecer tu contraseña, presiona en el siguiente enlace para hacerlo</p>

                <p>Presiona aquí: <a href="{$_ENV['APP_URL']}/recuperar?token={$this->token}">Cambiar Contraseña</a></p>

                <p>Si tu no solicistaste este cambio, puedes ignorar el mensaje</p>
            </html>
        HTML;

        $mail->Body = $contenido;

        return $mail->send();
    }
}

?>