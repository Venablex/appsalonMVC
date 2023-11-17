<?php 

namespace Model;

class Usuario extends CLinit
{

    public function getErrorsCrear()
    {
        $errores = [];

        if (empty($this->attr['nombre'])) {
            $errores[] = 'El nombre es obligatorio';
        }
        if (empty($this->attr['apellido'])) {
            $errores[] = 'El apellido es obligatorio';
        }
        if (empty($this->attr['telefono'])) {
            $errores[] = 'El teléfono es obligatorio';
        }
        if (empty($this->attr['email'])) {
            $errores[] = 'El email es obligatorio';
        }
        elseif (!filter_var($this->attr['email'],FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El email es inválido';
        }
        if (empty($this->attr['password'])) {
            $errores[] = 'La contraseña es obligatoria';
        }
        elseif (strlen($this->attr['password']) < 6) {
            $errores[] = 'La contraseña debe contener al menos 6 caracteres';
        }

        return $errores;
    }

    public function getErrorsLogin()
    {
        if (empty($this->attr['email'])) {
            $errores[] = 'El email es obligatorio';
        }
        elseif (!filter_var($this->attr['email'],FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El email es inválido';
        }
        if (empty($this->attr['password'])) {
            $errores[] = 'La contraseña es obligatoria';
        }
        elseif (strlen($this->attr['password']) < 6) {
            $errores[] = 'La contraseña debe contener al menos 6 caracteres';
        }

        return $errores ?? [];
    }

    public function getErrorsRecuperar()
    {
        if (empty($this->attr['password'])) {
            $errores[] = 'La contraseña es obligatoria';
        }
        elseif (strlen($this->attr['password']) < 6) {
            $errores[] = 'La contraseña debe contener al menos 6 caracteres';
        }

        return $errores ?? [];
    }

    public function getErrorsOlvide()
    {
        if (empty($this->attr['email'])) {
            $errores[] = 'El email es obligatorio';
        }
        elseif (!filter_var($this->attr['email'],FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El email es inválido';
        }

        return $errores ?? [];
    }

    public function authNewUser()
    {
        $query = "SELECT * FROM usuarios WHERE email = '{$this->attr['email']}'";

        $res = self::query($query,1);

        if ($res->num_rows === 1) {
            return false;
        }elseif ($res->num_rows === 0) {
            return true;
        }

    }

    public function hashPassword()
    {
        $this->attr['password'] = password_hash($this->attr['password'], PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->attr['token'] = uniqid();
    }

    public function crearUsuario()
    {
        $query = 'INSERT INTO usuarios (';
        $query .= join(',',array_keys($this->attr));
        $query .= ') VALUES (\'';
        $query .= join("','",array_values($this->attr));
        $query .= '\')';

        // debug($query);

        self::query($query);
    }

    public function checkPassword($hash)
    {
        $auth = password_verify($this->attr['password'],$hash);

        return $auth;
    }
}

?>