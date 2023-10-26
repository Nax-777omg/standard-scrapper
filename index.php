<h1>STANDARD SCRAPER vr 0.1</h1>

<br>
<hr>
<br>


<?php

function probarMatricula($matricula) {
    // URL del formulario donde se prueba la matrícula
    $url = 'https://www.cvt.edu.mx/SiteBoletasPrepa/BoletaPrepa.php';

    // Datos a enviar al formulario (nombre del campo del input y valor de la matrícula)
    $data = [
        'matricula' => $matricula
    ];

    // Configurar opciones de la solicitud
    $options = [
        'http' => [
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    // Crear el contexto de la solicitud
    $context = stream_context_create($options);

    // Realizar la solicitud POST al formulario y obtener la respuesta
    $response = file_get_contents($url, false, $context);

    // Devolver tanto el estado de la matrícula como el HTML de la respuesta
    return [
        'matricula_valida' => strpos($response, 'Matrícula válida') !== false,
        'html' => $response
    ];
}



$matriculaInicial =0;
$matriculaFinal = 9999;

// Bucle para probar todas las matrículas en el rango
for ($matricula = $matriculaInicial; $matricula <= $matriculaFinal; $matricula++) {
    // Formatear la matrícula con ceros a la izquierda si es necesario (para que sea de 6 dígitos)
    $matriculaFormateada = $matricula;
    
    $result = probarMatricula('01' . $matriculaFormateada); // Agregar '011' al principio de la matrícula
    $htmlObtenido = $result['html'];
    
    $cadenaEspecifica = '<p align="center" class="Estilo27"><span class="Estilo27 Estilo45">NO SE ENCONTRO INFORMACI&Oacute;N. <br />';
    
    if (strpos($htmlObtenido, $cadenaEspecifica) === false) {
        file_put_contents('01'.$matriculaFormateada.'.html', $htmlObtenido);
        echo 'El HTML obtenido para la matrícula ' . '01' . $matriculaFormateada . ' ha sido guardado.' . PHP_EOL;
    }
}

echo "<br><br><br><br><h1>Terminado.<h1>";

?>





