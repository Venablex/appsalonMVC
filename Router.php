<?php 

namespace MVC;

class Router
{
    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url,$func,$priv=false)
    {
        $func[] = $priv;

        $this->rutasGET[$url] = $func;
    }

    public function post($url,$func)
    {
        if (!isset($func[2])) {
            $func[] = false;
        }

        $this->rutasPOST[$url] = $func;
    }

    public function checkurl()
    {
        $actualURL = $_SERVER['PATH_INFO'] ?? '/';
        $reqmethod = $_SERVER['REQUEST_METHOD'];

        if ($reqmethod === 'GET') {
            $func = $this->rutasGET[$actualURL] ?? null;
        }else {
            $func = $this->rutasPOST[$actualURL] ?? null;
        }

        if ($func) {

            if ($func[2]) {
                session_start();

                $auth = $_SESSION['auth'] ?? false;

                if (!$auth) {
                    header('Location: /');
                    exit;
                }
            }

            $func = [$func[0],$func[1]];

            call_user_func($func,$this);
        }else {
            // header('Location: /');
            exit;
        }
    }

    public function render($view,$data=[])
    {

        foreach ($data as $key => $value) {
            $$key = $value;
        }
        // debug($data);

        ob_start();
        include_once __DIR__."/views/$view.php";

        $contenido = ob_get_clean();

        include_once __DIR__.'/views/layout.php';
    }
}

?>