<?php
require_once('config.php');

$session = $auth0->getCredentials();

if(!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/aasana/panel/');
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
                <li class="nav-item"><a href="index.php" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="crearpregunta.php" class="nav-link">Crear Pregunta</a></li>
                <li class="nav-item"><a href="listapreguntas.php" class="nav-link">Listado de Preguntas</a></li>
                <li class="nav-item"><a href="agregarcontenido.php" class="nav-link">Agregar contenido explicativo</a>
                </li>
                <li class="nav-item"><a href="listacontenido.php" class="nav-link active">Listado de contenido</a></li>
            </ul>
        </div>
        <div class="col border-primary p-3">
            <h2>Listado de Contenido Explicativo</h2>
            <table id="listadocontenido" class="table table-striped">
                <thead>
                    <th>Descripci&oacute;n:</th>
                    <th>Enlace:</th>
                    <th>Opciones:</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="BorrarContenido" tabindex="-1" aria-labelledby="BorrarContenido" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="BorrarContenido">Borrar contenido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    El contenido fue borrado exitosamente
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {

    $.ajax({
        type: "GET",
        url: "api/listacontenido.php",
        dataType: "json",
        success: function(data) {

            if (data.status == true) {
                $.each(data.datos, function(id, elemento) {
                    $('#listadocontenido').append('<tr id="' + elemento.id + '"><td>' +
                        elemento.descripcion + '</td><td>' + elemento.enlace +
                        '</td><td><a href="editarcontenido.php?contenido=' + elemento
                        .id +
                        '">Editar</a> - <a class="borrarcontenido" href="#" data-contenidoid="' +
                        elemento.id + '">Borrar</a></td></tr>');
                });
            }

        }
    });

    $(document).on('click', '.borrarcontenido', function(e) {
        e.preventDefault();

        let idcontenido = $(this).data('contenidoid');

        $.ajax({
            type: "GET",
            url: "api/borrarcontenido.php",
            data: {
                "id": idcontenido
            },
            dataType: "json",
            success: function(data) {

                if (data.status == true) {

                    $('#BorrarContenido').modal('show');
                    $('#' + idcontenido).fadeOut('slow');

                }

            }
        });

    });

});
</script>

<?php include('app/theme/footer.php');?>