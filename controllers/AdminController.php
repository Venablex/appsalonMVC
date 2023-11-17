<?php 

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {

        session_start();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
            exit;
        }

        if (isset($_GET['fecha'])) {

            $fecha = $_GET['fecha'];
            $fechas = explode('-',$fecha);
            if (!checkdate($fechas[1],$fechas[2],$fechas[0])) {
                header('Location: /admin');
                exit;
            }

        }


        $query = "SELECT citas.id AS citaid,citas.fecha,citas.hora,usuarios.id AS usuarioid,CONCAT(usuarios.nombre,' ',usuarios.apellido) AS cliente,usuarios.email,usuarios.telefono,servicios.nombre AS servicio,servicios.precio FROM citas";
        $query .= " LEFT JOIN usuarios ON citas.usuarioid = usuarios.id";
        $query .= " LEFT JOIN citas_servicios ON citas.id = citas_servicios.citaid";
        $query .= " LEFT JOIN servicios ON citas_servicios.servicioid = servicios.id";

        if (isset($fecha)) {
            $query .= " WHERE citas.fecha = '$fecha'";
        }

        // debug($query);

        $result = AdminCita::query($query);

        $citas = $result->fetch_all(1);

        $result->free();

        // debug($result);
        // debug($citas);

        $total = 0;

        foreach ($citas as $key => $cita) {
            
            if (!isset($citas[$key+1])) {
                $total += floatval($cita['precio']);
                $citas[$key]['total'] = $total;
                unset($total);
                break;
            }

            $total += floatval($cita['precio']);

            if ($cita['citaid'] !== $citas[$key+1]['citaid']) {
                $citas[$key]['total'] = $total;
                $total = 0;
                continue;
            }
        }

        // debug($citas);
        
        $router->render('admin/index',[
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha ?? ''
        ]);
    }

}


?>