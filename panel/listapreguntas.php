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
                <li class="nav-item"><a href="listapreguntas.php" class="nav-link active">Listado de Preguntas</a></li>
                <li class="nav-item"><a href="agregarcontenido.php" class="nav-link">Agregar contenido explicativo</a>
                </li>
                <li class="nav-item"><a href="listacontenido.php" class="nav-link">Listado de contenido</a></li>
            </ul>
        </div>
        <div class="col border-primary p-3">
            <h2>Listado de Preguntas</h2>
            <table id="listadopreguntas" class="table table-striped">
                <thead>
                    <th>Pregunta:</th>
                    <th>Opciones:</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>

    <div class="modal fade" id="BorrarPregunta" tabindex="-1" aria-labelledby="BorrarPregunta" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="CrearPregunta">Borrar pregunta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    La pregunta fue borrada exitosamente.
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
        url: "api/listapreguntas.php",
        dataType: "json",
        success: function(data) {

            if (data.status == true) {
                $.each(data.datos, function(id, elemento) {
                    $('#listadopreguntas').append('<tr id="' + elemento.id + '"><td>' +
                        elemento.pregunta +
                        '</td><td><a href="editarpregunta.php?pregunta=' + elemento.id +
                        '">Editar</a> - <a class="borrarpregunta" href="#" data-preguntaid="' +
                        elemento.id + '">Borrar</a></td></tr>');
                });
            }

        }
    });

    $(document).on('click', '.borrarpregunta', function(e) {
        e.preventDefault();

        let idpregunta = $(this).data('preguntaid');

        $.ajax({
            type: "GET",
            url: "api/borrarpregunta.php",
            data: {
                "id": idpregunta
            },
            dataType: "json",
            success: function(data) {

                if (data.status == true) {

                    $('#BorrarPregunta').modal('show');
                    $('#' + idpregunta).fadeOut('slow');

                }

            }
        });

    });

});
</script>

<?php include('app/theme/footer.php');?>