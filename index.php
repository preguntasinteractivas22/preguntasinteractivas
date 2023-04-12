<?php

require('panel/config.php');
use Jajo\JSONDB;
session_start();

$json_db = new JSONDB(__DIR__);

$datos = $json_db->select('*')
	->from('panel/app/json/preguntas.json')
	->get();

$contenido = $json_db->select('*')
	->from('panel/app/json/contenido.json')
	->get();

?><html>

<head>
    <link rel="stylesheet" href="stylesheet.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description"
        content="Conoce tu biotipo a partir de Preguntas Interactivas  » || Vata || Pitta || Kapha || » AASANA » Asociación Argentina de Salud Natural y Ayurveda" />
    <meta name="keywords" content="aasana, ayurbeda, salud natural" />
    <meta name="author" content="AASANA" />
    <meta name="city" content="Rosario" />
    <meta name="country" content="Argentina" />
    <meta name="robots" content="all" />
    <link rel="canonical" href="https://test.aasana.org" />
    <link rel="alternate" hreflang="es-ar" href="https://test.aasana.org" />
    <link rel="icon" type="image/png" href="aasana-logo-web.jpg" sizes="16x16" />
    <link rel="icon" type="image/png" href="aasana-logo-web.jpg" sizes="32x32" />

    <meta property="og:title"
        content="Preguntas Interactivas » AASANA » Asociación Argentina de Salud Natural y Ayurveda" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://test.aasana.org" />
    <meta property="og:image" content="https://test.aasana.org/aasana-logo-web.jpg" />
    <meta property="og:description"
        content="Conoce tu biotipo a partir de Preguntas Interactivas  » || Vata || Pitta || Kapha || » AASANA » Asociación Argentina de Salud Natural y Ayurveda" />
    <meta property="og:site_name"
        content="Preguntas Interactivas » AASANA » Asociación Argentina de Salud Natural y Ayurveda">

    <title>Preguntas Interactivas » AASANA » Asociación Argentina de Salud Natural y Ayurveda</title>

</head>

<body>

    <div class="container">

        <form id="preguntainteractiva" class="quiz">
            <div class="quiz__inner"><?php
    
    $i = 1;
    $current = ' quiz__step--current';

    $biotipo = array(
      1 => 'vata',
      2 => 'pitta',
      3 => 'kapha'
    );

    foreach($datos as $indice => $pregunta){

      echo '<div data-question="'.$i.'" class="quiz__step--'.$i.$current.' quiz__step">
      <div class="question__emoji"><img src="logoweb.png" /></div>
      <h1 class="quiz__question">'.$pregunta['pregunta'].'</h1>
	  <input type="hidden" name="preg'.$i.'_checksum" value="'. $pregunta['id'] .'" />';

      $tipopregunta = 1;
		
      foreach($pregunta['respuestas'] as $respuesta){

		echo '<div class="answer">
		<label class="answerlabel" for="preg'.$i.'_tipo'.$tipopregunta.'">'.$respuesta['respuesta'].'</label>
		<input name="preg'.$i.'_tipo'.$tipopregunta.'" class="' . $biotipo[$tipopregunta] . '" type="number" placeholder="0" onkeyup="this.value = parseInt(this.value);" />
        </div>';
		
		++$tipopregunta;
		  
      }
	  


      echo '
      <hr /><div class="separador"><span>Puede omitir esta pregunta presionando el boton de Siguiente.</span><br />
      <span>La puntuación es sobre un rango de <b>0 a 6</b>. <br /> El total no puede ser superior a <b>6</b>.<br /><br /></span>
      <span><strong>Medios de contacto: info@aasana.org / contacto@aasana.org</strong>.</span></div>
      </div>';
		
      $current = null;
		
      ++$i;

    }
	
	$_SESSION['cantidadpreguntas'] = $i;

    ?><div data-question="<?php echo $i;?>" class="quiz__step--<?php echo $i?> quiz__step quiz__summary">

                    <h1 class="quiz__question">Resumen</h1>
                    <div id="summary"></div>
                    <div class="submit__container">
                        <a href="#" class="submit">Enviar</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <footer id="botones-barra" class="bottom">
        <section class="bottom__container">
            <div class="progress">
                <div class="progress__inner"></div>
            </div>
            <div class="navigation">
                <div class="navigation__btn navigation__btn--left"><svg width="40" height="40" viewBox="0 0 24 24">
                        <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                    </svg></div>
                <div class="navigation__btn navigation__btn--right"><svg width="40" height="40" viewBox="0 0 24 24">
                        <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                    </svg></div>
            </div>
        </section>
    </footer>


    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
    const numberSteps = $('.quiz__step').length - 1;
    let disableButtons = false;
    const tick =
        '<div class="answer__tick"><svg width="14" height="14" viewBox="0 0 24 24"><path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path></svg></div>';

    const resultadoview = new URLSearchParams(window.location.search);

    window.tipo1 = 0;
    window.tipo2 = 0;
    window.tipo3 = 0;

    if (resultadoview.get("preview") == 1) {

        window.tipo1 = Number(resultadoview.get("vata") || 0);
        window.tipo2 = Number(resultadoview.get("pitta") || 0);
        window.tipo3 = Number(resultadoview.get("kapha") || 0);

        setTimeout(function() {
            $('.submit').click();
        }, 350);

    }


    $('.answer__input').on('change', function(e) {

        if ($(this).next().children('.answer__tick').length > 0) {
            return false
        }
        $(this).next().append(tick)
    });


    $('.navigation__btn--right').click(function(e) {
        let currentIndex = Number($('.quiz__step--current').attr('data-question'));

        if (currentIndex == numberSteps) {
            $('.summary__item').remove();

            $('.vata').each(function(index, item) {
                window.tipo1 += Number($(this).val());
            });

            $('.pitta').each(function(index, item) {
                window.tipo2 += Number($(this).val());
            });

            $('.kapha').each(function(index, item) {
                window.tipo3 += Number($(this).val());
            });

            setTimeout(function() {
                $('.submit').click();
            }, 200);

        } else {

            if ((Number($('.quiz__step--current .vata').val()) + Number($('.quiz__step--current .pitta')
                .val()) + Number($('.quiz__step--current .kapha').val())) > 6) {

                $('.quiz__step--current input').css('border', '1px solid #FF3333');

                return false;


            } else {

                $('.quiz__step--current input').css('border', '1px solid #A7AACB');

            }

        }

        const percentage = (currentIndex * 100) / numberSteps;
        $('.progress__inner').width(percentage + '%');
        $('.quiz__step--current').hide('300');
        $('.quiz__step--current').removeClass('quiz__step--current');
        $('.quiz__step--' + (currentIndex + 1)).show('300').addClass('quiz__step--current');

        currentIndex = Number($('.quiz__step--current').attr('data-question'));
        if (currentIndex > 1) {
            $('.navigation__btn--left').removeClass('navigation__btn--disabled');
        }
    });


    $('.navigation__btn--left').click(function(e) {
        let currentIndex = Number($('.quiz__step--current').attr('data-question'));

        if (currentIndex == 1 || disableButtons == true) {
            $(this).addClass('navigation__btn--disabled');
            return false;
        }


        $('.quiz__step--current').hide('300');
        $('.quiz__step--current').removeClass('quiz__step--current');
        $('.quiz__step--' + (currentIndex - 1)).show('300').addClass('quiz__step--current');
        currentIndex = Number($('.quiz__step--current').attr('data-question'));
        if (currentIndex == 1) {
            $(this).addClass('navigation__btn--disabled');
        }
        const percentage = ((currentIndex - 1) * 100) / numberSteps + 1;
        $('.progress__inner').width(percentage + '%');
    });

    $('.submit').click(function(e) {

        e.preventDefault();
        $('.quiz').css('display', 'none');

        var imagen = '';

        var coldosha = 1;

        if (window.tipo1 > window.tipo2 && window.tipo1 > window.tipo3) {
            imagen = '<ul><li><img src="wind.png" /><h2>Vata</h2></li></ul>';
        } else
        if (window.tipo2 > window.tipo1 && window.tipo2 > window.tipo3) {
            imagen = '<ul><li><img src="fire.png" /><h2>Pitta</h2></li></ul>';
        } else
        if (window.tipo3 > window.tipo1 && window.tipo3 > window.tipo2) {
            imagen = '<ul><li><img src="earth.png" /><h2>Kapha</h2></li></ul>';
        }

        if (imagen == '') {
            if (window.tipo1 == window.tipo2 && window.tipo2 == window.tipo3) {
                imagen =
                    '<ul><li><img src="wind.png" /><h2>Vata</h2></li><li><img src="fire.png" /><h2>Pitta</h2></li><li><img src="earth.png" /><br /><h2>Kapha</h2></li></ul>';
                coldosha = 3;
            } else
            if (window.tipo1 == window.tipo2) {
                imagen =
                    '<ul><li><img src="wind.png" /><h2>Vata</h2></li><li><img src="fire.png" /><h2>Pitta</h2></li></ul>';
                coldosha = 2;
            } else
            if (window.tipo1 == window.tipo3) {
                imagen =
                    '<ul><li><img src="wind.png" /><h2>Vata</h2></li><li><img src="earth.png" /><h2>Kapha</h2></li></ul>';
                coldosha = 2;
            } else
            if (window.tipo2 == window.tipo3) {
                imagen =
                    '<ul><li><img src="fire.png" /><h2>Pitta</h2></li><li><img src="earth.png" /><h2>Kapha</h2></li></ul>';
                coldosha = 2;
            }
        }

        const puntaje_total = window.tipo1 + window.tipo2 + window.tipo3;
        const porcentaje = puntaje_total / 3;

        const predominante_vata = window.tipo1 > window.tipo2 && window.tipo1 > window.tipo3;
        const sub_pitta = window.tipo2 > window.tipo3 && window.tipo2 >= porcentaje;
        const sub_kapha = window.tipo2 < window.tipo3 && window.tipo3 >= porcentaje;

        const predominante_pitta = window.tipo2 > window.tipo1 && window.tipo2 > window.tipo3;
        const sub_2_vata = window.tipo1 > window.tipo3 && window.tipo1 >= porcentaje;
        const sub_2_kapha = window.tipo1 < window.tipo3 && window.tipo3 >= porcentaje;

        const predominante_kapha = window.tipo3 > window.tipo1 && window.tipo3 > window.tipo2;
        const sub_3_vata = window.tipo1 > window.tipo2 && window.tipo1 >= porcentaje;
        const sub_3_pitta = window.tipo1 < window.tipo2 && window.tipo2 >= porcentaje;

        if (predominante_vata && sub_pitta) {
            imagen =
                '<ul><li><img src="wind.png" /><h1>Vata</h1></li><li><img class="imgSecundaria" src="fire.png" /><h1>Pitta</h1></li></ul>';
            coldosha = 2;
        } else if (predominante_vata && sub_kapha) {
            imagen =
                '<ul><li><img src="wind.png" /><h1>Vata</h1></li><li><img class="imgSecundaria" src="earth.png" /><h1>Kapha</h1></li></ul>';
            coldosha = 2;
        } else if (predominante_vata) {
            imagen = '<ul><li><img src="wind.png" /><h1>Vata</h1></li></ul>';
            coldosha = 1;
        }

        if (predominante_pitta && sub_2_vata) {
            imagen =
                '<ul><li><img src="fire.png" /><h1>Pitta</h1></li><li><img class="imgSecundaria" src="wind.png" /><h1>Vata</h1></li></ul>';
            coldosha = 2;
        } else if (predominante_pitta && sub_2_kapha) {
            imagen =
                '<ul><li><img src="fire.png" /><h1>Pitta</h1></li><li><img class="imgSecundaria" src="earth.png" /><h1>Kapha</h1></li></ul>';
            coldosha = 2;
        } else if (predominante_pitta) {
            imagen = '<ul><li><img src="fire.png" /><h1>Pitta</h1></li></ul>';
            coldosha = 1;
        }

        if (predominante_kapha && sub_3_vata) {
            imagen =
                '<ul><li><img src="earth.png" /><h1>Kapha</h1></li><li><img class="imgSecundaria" src="wind.png" /><h1>Vata</h1></li></ul>';
            coldosha = 2;
        } else if (predominante_kapha && sub_3_pitta) {
            imagen =
                '<ul><li><img src="earth.png" /><h1>Kapha</h1></li><li><img class="imgSecundaria" src="fire.png" /><h1>Pitta</h1></li></ul>';
            coldosha = 2;
        } else if (predominante_kapha) {
            imagen = '<ul><li><img src="earth.png" alt="Kapha" title="Kapha" /><h1>Kapha</h1></li></ul>';
            coldosha = 1;
        }

        var url = window.location.protocol + '//' + window.location.hostname + window.location.pathname +
            encodeURIComponent('?preview=1&vata=' + window.tipo1 + '&pitta=' + window.tipo2 + '&kapha=' + window
                .tipo3);

        var resultado = '<div class="cresultado"><div class="creset"><a href="' + window.location.protocol +
            '//' + window.location.hostname + window.location.pathname +
            '">Reiniciar Test</a></div><img src="logoweb.png" alt="AASANA Logotipo" /><h1>Mis resultados</h1><br /><div class="resultado"><div class="tipodosha col-' +
            coldosha + '"><div class="tituloresultado"><h1>Mi tipo de Dosha:</h1></div>' + imagen +
            '</div><div class="tipodosha grafico"><div id="piechart"></div></div></div><br /><div class="share"><div class="text-share">¿Le gustar&iacute;a compartir los resultados con un amigo?</div><br /><div class="media-share"><a title="Compartir en Facebook" href="https://www.facebook.com/sharer.php?u=' +
            url +
            '"><img src="images/media/facebook.png" alt="Compartir en Facebook" /></a></div><div class="media-share"><a title="Twitter" href="https://twitter.com/intent/tweet?text=' +
            url +
            '"><img src="images/media/twitter.png" alt="Twitter" /></a></div><div class="media-share"><a title="WhatsApp" href="https://api.whatsapp.com/send?text=' +
            url +
            '"><img src="images/media/whatsapp.png" alt="WhatsApp" /></a></div></div><br /><div class="responsabilidad">El siguiente test es sólo a nivel informativo y no intenta diagnosticar ni tratar enfermedades, motivos por los cuales debe consultar al profesional correspondiente.</div><br /><div><h2>Informaci&oacute;n que podria interesarte:</h2><br /><div class="miniaturas">';

        <?php

foreach ($contenido as $index => $articulo) {

  echo 'resultado += \'<div class="miniatura-padre"><div class="miniatura-thumb"><a href=" ' . $articulo['enlace'] . '" target="_blank"><img src=" ' . $articulo['opengraph']['images'] . '" class="miniatura-thumb" /></a></div><div class="miniatura-titulo"><a href=" ' . $articulo['enlace'] . '" target="_blank">' . $articulo['opengraph']['title'] . '</a></div><div class="miniatura-texto"><a href=" ' . $articulo['enlace'] . '" target="_blank">' . $articulo['opengraph']['description'] . '</a></div></div>\';
  ';

}

?>

        resultado += '</div></div></div>';

        $.post("feedback.php", $('#preguntainteractiva').serialize());


        $(resultado).appendTo('.container');

        $('#botones-barra').fadeOut('slow');
        $('.container').css('height', '100%');

        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);


        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Tipo de Dosha', 'Energias'],
                ['Vata', window.tipo1],
                ['Pitta', window.tipo2],
                ['Kapha', window.tipo3]
            ]);

            var options = {
                title: 'Distribución de Dosha',
                backgroundColor: '#f7f8fc',
                colors: ['#6f9ca4', '#da7100', '#38a600'],
                is3D: true,
                legend: {
                    position: 'bottom'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);

        }

        disableButtons = true;
        $('.navigation__btn').addClass('navigation__btn--disabled')
    })
    </script>
</body>

</html>