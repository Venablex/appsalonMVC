<?php 

define('DOC_ROOT',$_SERVER["DOCUMENT_ROOT"].'/../');
define('RQ_MTH', $_SERVER['REQUEST_METHOD']);


function debug($var):void {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

function clean($user,$key) : string{
    
    if (RQ_MTH === 'POST' && isset($user->attr[$key]) && strlen($user->attr[$key])<=60) {
        return htmlspecialchars($user->attr[$key]);
    }else {
        return '';
    }
}
?>