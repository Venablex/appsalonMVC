<?php 

namespace Model;

class CLinit
{
    protected static $db;
    public $attr;

    public function __construct($args = [])
    {
        $this->attr = $args;
    }

    public static function setDB($database) :void
    {
        self::$db = $database;
    }
    
    public static function query($query,$limit=false)
    {   
        if ($limit) {
            $query.= " LIMIT $limit";
        }

        $resultado = self::$db->query($query);
        // debug($resultado);

        return $resultado;

    }

    public function sanitizar($avoid = ''):void
    {
        
        foreach ($this->attr as $key => $value) {

            if ($key === $avoid) {
                continue;
            }

            $this->attr[$key] = self::$db->escape_string($value);
        }
        // debug($this->attr);
    }

    public static function sanitizarOne($value)
    {
        return self::$db->escape_string($value);
    }

}

?>