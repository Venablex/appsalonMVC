<h1 class="nombre-pagina">Panel de Administración</h1>

<?php 
    include_once DOC_ROOT.'/views/templates/barra.php';
?>


<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input
                type="date"
                name="fecha"
                id="fecha"
                value="<?= $fecha ?>"
            >
        </div>
    </form>
</div>

<?php
if (count($citas) === 0):
    
    echo "<h2>No hay Citas en esta fecha</h2>";

else:
?>

<div id="citas-admin">
    <ul class="citas">

        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita):
        ?>

            <?php if ($idCita !== $cita['citaid']):?>

                <li>
                    <p>ID: <span><?= $cita['citaid'] ?></span></p>
                    <p>Hora: <span><?= $cita['hora'] ?></span></p>
                    <p>Cliente: <span><?= $cita['cliente'] ?></span></p>
                    <p>Email: <span><?= $cita['email'] ?></span></p>
                    <p>Teléfono: <span><?= $cita['telefono'] ?></span></p>

                    <h3>Servicios</h3>
            <?php endif;?>

            <p class="servicio"><?= $cita['servicio'].' '.$cita['precio'] ?></p>

            <?php 
                if (isset($cita['total'])) {
                    
                    $text = <<<HTML
                        <p class="total">Total: <span>\${$cita['total']}</span></p>

                        <form action="/api/eliminar" method="post">
                            <input
                            type="hidden"
                            name="id"
                            value ="{$cita['citaid']}">
                            <input type="submit" value="Eliminar" class="boton-eliminar">
                        </form>
                        </li>
                    HTML;

                    echo $text;
                }
            ?>
        <?php
        $idCita = $cita['citaid'];
        endforeach;
        unset($idCita,$text)
        ?>
    </ul>
</div>
<?php
endif;

$script = "<script src='build/js/buscador.js'></script>";

?>