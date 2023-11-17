<h1 class="nombre-pagina">Confirmar cuenta</h1>
<?php 

if ($error) {
    echo <<<HTML
        <div class="alerta error">Token No Válido</div>
    HTML;
} else {
    echo <<<HTML
        <div class="alerta success">Token Válido, confirmando usuario...</div>
    HTML;
}
?>

<div class="acciones">
    <a href="/">Volver a Iniciar Sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>
