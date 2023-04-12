<?php
require_once('config.php');

$session = $auth0->getCredentials();

if(!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/panel/');
    exit;
}

include('app/theme/head.php');
include('app/theme/sidebar.php');
?>
<div class="container mb-5">

    <h1>Sistema de Preguntas Interactivas</h1>
    <hr />
    <div class="row">
        <div class="col-md-2 p-1">
            <ul class="nav nav-pills flex-column bg-light">
                <li class="nav-item"><a href="index.php" class="nav-link" id="">Inicio</a></li>
                <li class="nav-item"><a href="crearpregunta.php" class="nav-link">Crear Pregunta</a></li>
                <li class="nav-item"><a href="listapreguntas.php" class="nav-link">Listado de Preguntas</a></li>
                <li class="nav-item"><a href="agregarcontenido.php" class="nav-link active">Agregar contenido
                        explicativo</a></li>
                <li class="nav-item"><a href="listacontenido.php" class="nav-link">Listado de contenido</a></li>
            </ul>
        </div>
        <div class="col border-primary p-3">
            <h2>Subir contenido explicativo</h2>
            <form id="formsubircontenido">
                <div class="mb-3">
                    <label for="tipocontenido">Seleccione tipo de contenido</label>
                    <select name="tipocontenido" class="form-select" aria-label="Seleccione tipo de contenido">
                        <option disabled selected>Seleccione una opci&oacute;n</option>
                        <option value="1">Enlace a video</option>
                        <option value="2">Enlace a contenido</option>
                    </select>
                </div>
                <hr />
                <div class="mb-3">
                    <label for="descripcion">Descripci&oacute;n</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion"
                        aria-describedby="descripcion" />
                    <div id="descripcioncontenido" class="form-text">Descripci&oacute;n de contenido a mostrar</div>
                </div>
                <div class="mb-3">
                    <label for="pregunta">Inserte en enlace del contenido a mostrar</label>
                    <input type="text" class="form-control" id="enlacecontenido" name="enlacecontenido"
                        aria-describedby="enlace" />
                    <div id="enlacescontenido" class="form-text">Enlace de contenido</div>
                </div>

                <div class="mb-3">
                    <input id="subircontenido" type="submit" class="btn btn-primary" value="Subir contenido" />
                </div>
            </form>
        </div>

        <div class="modal fade" id="SubirContenido" tabindex="-1" aria-labelledby="SubirContenido" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="SubirContenido">Subir contenido</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        El contenido fue subido exitosamente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>


    </div>

</div>

<script>
$(document).ready(function() {

    $('#subircontenido').on('click', function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "api/agregarcontenido.php",
            data: $('#formsubircontenido').serialize(),
            dataType: "json",
            success: function(data) {

                if (data.status == true) {
                    $('#SubirContenido').modal('show');
                }

            }
        });

    });

});
</script>
<?php include('app/theme/footer.php');?>