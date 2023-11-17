<?php 

namespace Controllers;

use Email\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        // debug($_SERVER);

        if (RQ_MTH === 'POST') {
            $usuario = new Usuario($_POST);

            $errores = $usuario->getErrorsLogin();

            if (empty($errores)) {

                $usuario->sanitizar('password');

                $query = "SELECT * FROM usuarios WHERE email='{$usuario->attr['email']}' AND confirmado = 1";

                $res = Usuario::query($query,1);

                if ($res->num_rows === 1) {
                    #Verificar Password

                    $dbreg = $res->fetch_assoc();

                    $res->free();
                    
                    $auth = $usuario->checkPassword($dbreg['password']);
                    
                    if ($auth) {
                        
                        session_start();

                        $_SESSION['id'] = $dbreg['id'];
                        $_SESSION['nombre'] = "{$dbreg['nombre']} {$dbreg['apellido']}";
                        $_SESSION['email'] = $dbreg['email'];
                        $_SESSION['login'] = true;

                        if ($dbreg['admin'] === '1') {
                            #Comprobando si es admin

                            $_SESSION['admin'] = true;
                            header('Location: /admin');
                            exit;
                        } else {
                            header('Location: /cita');
                            exit;
                        }

                    } else {
                        $errores[] = 'Credenciales incorrectas';
                    }

                } else {
                    $errores[] = 'Usuario no registrado o sin confirmar';
                }

            }
        }
        
        $router->render('auth/login',[
            'usuario' => $usuario ?? '',
            'errores' => $errores ?? []
        ]);
    }

    public static function logout()
    {
        session_start();

        session_destroy();

        header('Location: /');
        exit;
    }

    public static function olvide(Router $router)
    {

        if (RQ_MTH === 'POST') {
            $usuario = new Usuario($_POST);

            $errores = $usuario->getErrorsOlvide();

            if (empty($errores)) {

                $usuario->sanitizar();

                $query = "SELECT nombre,confirmado FROM usuarios WHERE email = '{$usuario->attr['email']}'";

                $res = Usuario::query($query,1);

                $res = $res->fetch_assoc();
                                
                if (isset($res['confirmado']) && $res['confirmado'] === '1') {

                    $usuario->crearToken();
                    
                    $query = "UPDATE usuarios SET token = '{$usuario->attr['token']}' WHERE email = '{$usuario->attr['email']}'";

                    Usuario::query($query,1);
                    
                    $email = new Email($usuario->attr['email'],$res['nombre'],$usuario->attr['token']);

                    if (!$email->enviarInstrucciones()) {
                        $errores[] = 'Ha ocurrido un error al enviar las instrucciones';
                    }
                    
                }else{
                    $errores[] = 'El correo no existe o no está confirmado';
                }
            }
        }

        $router->render('auth/olvide-password',[
            'errores' => $errores ?? [],
            'alert' => $alert ?? false
        ]);
    }

    public static function recuperar(Router $router)
    {

        if (empty($_GET['token'])) {
            header('Location: /');
            exit;
        }

        $token = $_GET['token'];

        $token = Usuario::sanitizarOne($token);

        $query = "SELECT * FROM usuarios WHERE token = '$token'";

        $res = Usuario::query($query,1);

        if ($res->num_rows !== 1) {
            $alert = 'Token no válido';
        }elseif (RQ_MTH === 'POST') {
             
            $password = new Usuario($_POST);

            $errores = $password->getErrorsRecuperar();

            if (empty($errores)) {

                $password->hashPassword();

                $query = "UPDATE usuarios SET password = '{$password->attr['password']}', token = null WHERE token = '$token'";

                $res = Usuario::query($query,1);

                if ($res) {
                    header('Location: /');
                    exit;
                }else {
                    $errores[] = 'Ocurrió un error reestableciendo la contraseña';
                }
            }
        }

        
        $router->render('auth/recuperar-password',[
            'errores' => $errores ?? [],
            'alert' => $alert ?? false
        ]);
    }

    public static function crear(Router $router)
    {

        if (RQ_MTH === 'POST') {
            $usuario = new Usuario($_POST);
            $errores = $usuario->getErrorsCrear();
            // debug($errores);

            if (empty($errores)) {
                $usuario->sanitizar('password');
                // debug($usuario);
                $res=$usuario->authNewUser();
                
                if (!$res) {
                    $errores[] = 'El usuario ya está registrado';
                }else {
                    $usuario->hashPassword();
                    $usuario->crearToken();
                    
                    $email = new Email($usuario->attr['email'],$usuario->attr['nombre'],$usuario->attr['token']);

                    
                    $email->sendMail();
                    
                    // Crear
                    $usuario->crearUsuario();

                    session_start();

                    $_SESSION['token'] = true;
                    session_write_close();

                    header('Location: /mensaje');
                    exit;
                }
            }
        }

        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario ?? '',
            'errores' => $errores ?? [],
            'success' => $alert ?? false
        ]);
    }

    public static function mensaje(Router $router)
    {

        session_start();
        
        if (isset($_SESSION) && isset($_SESSION['token'])) {

            session_destroy();
    
            unset($_COOKIE['PHPSESSID']);
        }else {
            header('Location: /');
            exit;
        }

        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {

        if (empty($_GET['token'])) {
            header("Location: /");
            exit;
        }

        $token = $_GET['token'];

        $token = Usuario::sanitizarOne($token);
        
        $query = "SELECT * FROM usuarios WHERE token = '$token'";

        $res = Usuario::query($query,1);

        if ($res->num_rows === 1) {
            $error = false;

            $query = "UPDATE usuarios SET confirmado = 1, token = NULL WHERE token = '$token'";

            Usuario::query($query,1);
        } else {
            $error = true;
        }

        $router->render('auth/confirmar-cuenta',[
            'error' => $error
        ]);
    }
}

?>