<h1 class="nombre-pagina">Olvidé Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuación</p>

<?php 

foreach ($errores as $error) {
    echo <<<HTML
        <div class="alerta error">$error</div>
    HTML;
}

if (RQ_MTH === 'POST' && empty($errores)) {
    echo <<<HTML
        <div class="alerta success">Hemos enviado las instrucciones a tu correo</div>
    HTML;
}

?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu Email"
        >
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
</div>