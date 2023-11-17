<h1 class="nombre-servicios">Servicios</h1>

<p class="descripcion-pagina">Administracion de Servicios</p>

<?php 
    include_once DOC_ROOT . '/views/templates/barra.php';
?>

<ul class="servicios">

    <?php foreach ($servicios as $servicio) {
        
        echo <<<HTML
        <li>
            <p>Nombre: <span>{$servicio['nombre']}</span></p>
            <p>Precio: \$<span>{$servicio['precio']}</span></p>
            <div class="acciones">
                <a
                href="/servicios/actualizar?id={$servicio['id']}"
                class="boton">
                Actualizar</a>

                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="{$servicio['id']}">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>
        HTML;
    }?>

</ul>