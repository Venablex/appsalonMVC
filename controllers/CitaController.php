<?php 

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        // debug($_SERVER);

        session_start();
        
        if (!$_SESSION['login']) {
            header('Location: /');
            exit;
        }

        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre']
        ]);
    }
}

?>