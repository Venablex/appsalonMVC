<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function index(Router $router)
    {
        session_start();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
            exit;
        }

        $query = "SELECT * FROM servicios";

        $servicios = Servicio::query($query);

        $servicios = $servicios->fetch_all(1);

        $router->render('servicios/index',[
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
            exit;
        }

        $servicio = new Servicio;
        
        if (RQ_MTH === 'POST') {

            $servicio = new Servicio($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();

                header('Location: /servicios');
                exit;
            }
        }

        $router->render('servicios/crear',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas ?? []
        ]);

    }
    
    public static function actualizar(Router $router)
    {
        session_start();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
            exit;
        }

        $id = is_numeric($_GET['id']);

        if (!$id) {
            return;
        }

        $query = "SELECT * FROM servicios WHERE id={$_GET['id']}";

        $servicio = Servicio::query($query);

        $servicio = $servicio->fetch_assoc();

        $servicio = new Servicio($servicio);

        if (RQ_MTH === 'POST') {

            $servicio = new Servicio($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->actualizar();

                header('Location: /servicios');
                exit;
            }
        }

        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas ?? [],
            'servicio' => $servicio
        ]);
    }

    public static function eliminar()
    {
        session_start();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
            exit;
        }

        if (RQ_MTH === 'POST') {
            $id = is_numeric($_POST['id']);

            if (!$id) {
                return;
            }

            $query = "DELETE FROM servicios WHERE id = {$_POST['id']}";

            Servicio::query($query);

            header('Location: /servicios');
        }
    }

}