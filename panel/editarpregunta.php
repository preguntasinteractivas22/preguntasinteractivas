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
                <li class="nav-item"><a href="index.php" class="nav-link" id="">Inicio</a></li>
                <li class="nav-item"><a href="editarpregunta.php" class="nav-link">Crear Pregunta</a></li>
                <li class="nav-item"><a href="listapreguntas.php" class="nav-link">Listado de Preguntas</a></li>
                <li class="nav-item"><a href="agregarcontenido.php" class="nav-link">Agregar contenido explicativo</a>
                </li>
                <li class="nav-item"><a href="listacontenido.php" class="nav-link">Listado de contenido</a></li>
            </ul>
        </div>
        <div class="col border-primary p-3">
            <h2>Editar Pregunta</h2>
            <form id="formeditarpregunta">
                <div class="mb-3">
                    <label for="pregunta">Pregunta</label>
                    <input type="text" class="form-control" id="pregunta" name="pregunta"
                        aria-describedby="preguntaHelp" />
                    <div id="preguntaHelp" class="form-text">Texto de pregunta a mostrar</div>
                </div>
                <hr />
                <h3>Posibles respuestas</h3>
                <div class="mb-3">
                    <label for="pregunta">Respuesta Vata: </label>
                    <input type="text" class="form-control" id="respuesta1" name="respuesta1"
                        aria-describedby="preguntaHelp" />
                    <div id="preguntaHelp" class="form-text">Respuesta de tipo Vata</div>
                </div>
                <div class="mb-3">
                    <label for="pregunta">Respuesta Pitta: </label>
                    <input type="text" class="form-control" id="respuesta2" name="respuesta2"
                        aria-describedby="preguntaHelp" />
                    <div id="preguntaHelp" class="form-text">Respuesta de tipo Pitta</div>
                </div>
                <div class="mb-3">
                    <label for="pregunta">Respuesta Kapha: </label>
                    <input type="text" class="form-control" id="respuesta3" name="respuesta3"
                        aria-describedby="preguntaHelp" />
                    <div id="preguntaHelp" class="form-text">Respuesta de tipo Kapha</div>
                </div>

                <div class="mb-3">
                    <input type="hidden" id="idpregunta" name="id" value="" />
                    <input id="editarpregunta" type="submit" class="btn btn-primary" value="Editar Pregunta" />
                </div>
            </form>
        </div>


        <div class="modal fade" id="EditarPreguntaModal" tabindex="-1" aria-labelledby="EditarPreguntaModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditarPreguntaModal">Editar Pregunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        La pregunta fue modificada exitosamente
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

    let idpregunta = new URLSearchParams(window.location.search).get("pregunta");
    if (idpregunta == null) {
        //Error
    }

    $.ajax({
        type: "POST",
        url: "api/obtenerpregunta.php",
        method: "GET",
        data: {
            "id": idpregunta
        },
        dataType: "json",
        success: function(data) {

            if (data.status == true) {

                $('#idpregunta').val(idpregunta);
                $('#pregunta').val(data.datos[0].pregunta);
                $('#respuesta1').val(data.datos[0].respuestas[0].respuesta);
                $('#respuesta2').val(data.datos[0].respuestas[1].respuesta);
                $('#respuesta3').val(data.datos[0].respuestas[2].respuesta);

            } else {
                //Error
            }

        }
    });

    $('#editarpregunta').on('click', function(e) {

        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "api/editarpregunta.php",
            data: $('#formeditarpregunta').serialize(),
            dataType: "json",
            success: function(data) {

                if (data.status == true) {
                    $('#EditarPreguntaModal').modal('show');
                }

            }
        });

    });

});
</script>
<?php include('app/theme/footer.php');?>