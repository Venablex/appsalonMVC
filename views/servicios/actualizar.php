<h1 class="nombre-servicios">Actualizar Servicio</h1>

<p class="descripcion-pagina">Modifica los valores del formulario</p>

<?php 
    include_once DOC_ROOT . '/views/templates/barra.php';
?>

<form method="POST" class="formulario">

    <?php include_once __DIR__.'/formulario.php';?>

    <input type="submit" value="Actualizar" class="boton">
</form>