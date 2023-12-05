Este es el código fuente de una aplicación web de Preguntas Interactivas desarrollada en PHP. La aplicación permite a los usuarios responder preguntas para determinar su biotipo (Vata, Pitta, Kapha) según la medicina ayurvédica. A continuación, se proporciona una guía rápida sobre la estructura y funcionamiento de la aplicación.

## Estructura de Archivos

- `index.php`: Este archivo contiene el código principal de la aplicación, incluyendo la lógica de preguntas y respuestas, así como la presentación de los resultados.
- `stylesheet.css`: Archivo de estilo para dar formato a la interfaz de usuario.
- `feedback.php`: Maneja la retroalimentación del usuario después de completar las preguntas.
- `panel/config.php`: Archivo de configuración utilizado por la aplicación.
- `panel/app/json/preguntas.json`: Contiene las preguntas en formato JSON.
- `panel/app/json/contenido.json`: Contiene información adicional en formato JSON, como enlaces y descripciones de artículos relacionados.

## Requisitos

La aplicación se basa en PHP y utiliza la librería `Jajo\JSONDB` para manejar datos en formato JSON. Asegúrate de tener un entorno PHP configurado con el soporte de JSON y la librería mencionada.

## Configuración

1. Asegúrate de tener el archivo `config.php` correctamente configurado con la información necesaria.
2. Las preguntas se almacenan en `preguntas.json`, y el contenido adicional en `contenido.json`. Puedes personalizar estos archivos según tus necesidades.

## Uso

1. Accede a la aplicación a través de un servidor web.
2. Responde las preguntas proporcionadas para determinar tu biotipo.
3. Después de completar las preguntas, se mostrará un resumen con los resultados y enlaces relacionados.

## Notas Importantes

- La aplicación recopila información a través de formularios y utiliza sesiones para rastrear el progreso del usuario.
- Asegúrate de cumplir con las normativas de privacidad y las leyes de protección de datos al utilizar esta aplicación.

---
