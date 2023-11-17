<?php 

namespace Model;

class Cita extends CLinit
{
    public function guardar()
    {
        $sql = "INSERT INTO citas (fecha,hora,usuarioid) VALUES ('{$this->attr['fecha']}','{$this->attr['hora']}','{$_SESSION['id']}')";

        $res = self::query($sql);

        return [
            'respuesta' => $res,
            'idCita' => self::$db->insert_id
        ];
    }
}

?>