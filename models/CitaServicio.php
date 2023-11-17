<?php 

namespace Model;


class CitaServicio extends CLinit
{
    
    public function guardar()
    {
        
        $sql = "INSERT INTO citas_servicios (citaid,servicioid) VALUES ('{$this->attr['idCita']}','{$this->attr['idServicio']}')";

        $res = self::query($sql);

        return $res;

    }
    
}

?>