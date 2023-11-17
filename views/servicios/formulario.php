
<?php 

foreach ($alertas as $alerta) {
    echo <<<HTML
        <div class="alerta error">$alerta</div>
    HTML;
}

?>

<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre Servicio"
    value="<?= $servicio->attr['nombre'] ?? '' ?>">
</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input type="number" name="precio" id="precio" placeholder="Precio Servicio"
    value="<?= $servicio->attr['precio'] ?? '' ?>">
</div>