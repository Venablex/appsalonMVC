<h1 class="nombre-pagina">Recuperar Password</h1>

<?php
if ($alert){
    echo <<<HTML
        <div class="alerta error">$alert</div>
    HTML;
    return;
}
?>

<p class="descripcion-pagina">Escribe tu nuevo password a continuación</p>
<?php 

foreach ($errores as $error) {
    echo <<<HTML
        <div class="alerta error">$error</div>
    HTML;
}

?>


<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
            <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu Nuevo Password"
            >
    </div>
    <input type="submit" value="Guardar Nuevo Password" class="boton">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
</div>

