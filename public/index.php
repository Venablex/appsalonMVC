<?php 

require __DIR__.'/../tools/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router;

// Iniciar sesion

$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);

//Cerrar sesion
$router->get('/logout',[LoginController::class,'logout']);


// Cambiar contraseña
$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);
$router->get('/recuperar',[LoginController::class,'recuperar']);
$router->post('/recuperar',[LoginController::class,'recuperar']);

// Crear Cuenta
$router->get('/crear-cuenta',[LoginController::class,'crear']);
$router->post('/crear-cuenta',[LoginController::class,'crear']);
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);

$router->get('/mensaje',[LoginController::class,'mensaje']);

// Area Privada
$router->get('/cita',[CitaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);

// API citas
$router->get('/api/servicios',[APIController::class,'index']);

$router->post('/api/citas',[APIController::class,'guardar']);

$router->post('/api/eliminar',[APIController::class,'eliminar']);

// Servicios CRUD
$router->get('/servicios',[ServicioController::class,'index']);

$router->get('/servicios/crear',[ServicioController::class,'crear']);
$router->post('/servicios/crear',[ServicioController::class,'crear']);


$router->get('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class,'actualizar']);

$router->post('/servicios/eliminar',[ServicioController::class,'eliminar']);
// $router->get()

// debug($router);
$router->checkurl();
?>