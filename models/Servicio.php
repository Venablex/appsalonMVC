<?php 

namespace Model;

class Servicio extends CLinit
{
    #Base de datos

    public function validar()
    {
        if (!$this->attr['nombre']) {
            $alertas[] = 'El nombre del servicio es obligatorio';
        }
        
        if (!$this->attr['precio']) {
            $alertas[] = 'El precio del servicio es obligatorio';
        }
        elseif (!is_numeric($this->attr['precio'])) {
            $alertas[] = 'El precio no es valido';
        }

        return $alertas ?? [];
    }

    public function guardar()
    {
        $query = "INSERT INTO servicios (nombre,precio) VALUES ('{$this->attr['nombre']}',{$this->attr['precio']})";

        // debug($query);

        Servicio::query($query);
    }

    public function actualizar()
    {
        $query = "UPDATE servicios SET nombre='{$_POST['nombre']}',precio={$_POST['precio']} WHERE id={$_GET['id']}";

        // debug($query);

        Servicio::query($query);

    }
}

?>