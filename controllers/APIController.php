<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController
{
    public static function index()
    {
        $query = "SELECT * FROM servicios";

        $servicios = Servicio::query($query);

        $servicios=$servicios->fetch_all(MYSQLI_ASSOC);

        // debug($servicios);

        echo json_encode($servicios);
    }

    public static function guardar()
    {
        session_start();

        $cita = new Cita($_POST);

        $res_Cita = $cita->guardar();

        if (!$res_Cita['respuesta']) {
            echo json_encode(false);
            session_abort();
            exit;
        }

        $idServicios = explode(',',$_POST['servicios']);

        $args['idCita'] = $res_Cita['idCita'];

        foreach ($idServicios as $idServicio) {
            
            $args['idServicio'] = $idServicio;

            $citaServicio = new CitaServicio($args);

            $res_citaServicio = $citaServicio->guardar();

            if (!$res_citaServicio) {
                echo json_encode(false);
                session_abort();
                exit;
            }

        }

        echo json_encode(true);

        session_abort();
    }

    public static function eliminar()
    {
        if (RQ_MTH === 'POST') {
            $id = $_POST['id'];

            $query = "DELETE FROM citas WHERE id = $id";

            Cita::query($query);

            header('Location:'.$_SERVER["HTTP_REFERER"]);
        }
    }
}
?>