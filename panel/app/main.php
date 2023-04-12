<div class="container mb-5">

    <h1>Sistema de Preguntas Interactivas</h1>
    <hr />
    <div class="row">
        <div class="col-md-2 p-1">
            <ul class="nav nav-pills flex-column bg-light">
                <li class="nav-item"><a href="index.php" class="nav-link active">Inicio</a></li>
                <li class="nav-item"><a href="crearpregunta.php" class="nav-link">Crear Pregunta</a></li>
                <li class="nav-item"><a href="listapreguntas.php" class="nav-link">Listado de Preguntas</a></li>
                <li class="nav-item"><a href="agregarcontenido.php" class="nav-link">Agregar contenido explicativo</a>
                </li>
                <li class="nav-item"><a href="listacontenido.php" class="nav-link">Listado de contenido</a></li>
            </ul>
        </div>



        <script>
        <?php
    $estadisticapregunta = file_get_contents('app/json/estadistica-pregunta.json');

	echo 'var estadisticapregunta = JSON.parse(`' . $estadisticapregunta .'`);';

	$estadisticatipo = file_get_contents('app/json/estadistica-tipo.json');

	echo 'var estadisticatipo = JSON.parse(`' . $estadisticatipo .'`)[0];';

	$preguntas = file_get_contents('app/json/preguntas.json');

	echo 'var preguntas2 = JSON.parse(`' . $preguntas .'`);';

	?>

        var preguntas = [];
        preguntas2.map((element, key) => (preguntas[element.id] = element.pregunta));

        google.charts.load('current', {
            'packages': ['corechart', 'bar']
        });
        google.charts.setOnLoadCallback(graficaestadisticatipo);
        google.charts.setOnLoadCallback(graficaestadisticapregunta);

        function graficaestadisticatipo() {
            var data = google.visualization.arrayToDataTable([
                ['Tipo de Dosha', 'Energias'],
                ['Vata', estadisticatipo.tipo1],
                ['Pitta', estadisticatipo.tipo2],
                ['Kapha', estadisticatipo.tipo3]
            ]);

            var options = {
                title: 'Distribución de Tipo de Dosha en base a ' + estadisticatipo.hits + ' tests',
                backgroundColor: '#f7f8fc',
                colors: ['#6f9ca4', '#da7100', '#38a600'],
                is3D: true,
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('grafico-tipo'));

            chart.draw(data, options);
        }

        function graficaestadisticapregunta() {

            var chart2 = new google.charts.Bar(document.getElementById('graficopreguntas'));

            var dataTable = new google.visualization.DataTable();

            dataTable.addColumn('string', 'Pregunta');
            dataTable.addColumn('number', 'Vata');
            dataTable.addColumn('number', 'Pitta');
            dataTable.addColumn('number', 'Kapha');

            var dataArray = [];

            //estadisticapregunta.map((element,key) => dataArray.push([(parseInt(key)+1),element.tipo1,element.tipo2,element.tipo3]));
            estadisticapregunta.map((element, key) => dataArray.push([preguntas[element.id], element.tipo1, element
                .tipo2, element.tipo3
            ]));

            dataTable.addRows(dataArray);

            var options2 = {
                title: 'Preguntas en base a ' + estadisticatipo.hits + ' tests',
                backgroundColor: '#f7f8fc',
                colors: ['#6f9ca4', '#da7100', '#38a600'],
                is3D: true,
                legend: {
                    position: 'none'
                },
                hAxis: {
                    textStyle: {
                        color: '#f7f8fc'
                    }
                }
            };



            chart2.draw(dataTable, google.charts.Bar.convertOptions(options2));
        }
        </script>

        <div class="col border-primary">
            <h2>Estadisticas</h2>
            <div id="grafico-tipo" class="p-1"></div>
            <div id="graficopreguntas" class="p-1"></div>
        </div>

    </div>

</div>