<?php
// procesar.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $dni = htmlspecialchars($_POST['dni']);
    $anio = htmlspecialchars($_POST['anio']);
    $seccion = htmlspecialchars($_POST['seccion']);
    $propuesta = htmlspecialchars($_POST['propuesta']);
    $bday = htmlspecialchars($_POST['bday']);
} else {
    echo "No se han enviado datos.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Recibidos</title>
    <!-- Incluir jsPDF para generar el PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        function generarPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.setFont('Times', '', 12); // Fuente con un tamaño legible
            doc.setLineHeightFactor(1.5); // Factor de altura de línea para mayor espaciado
            const margenIzquierdo = 10;    // Margen izquierdo
            const margenSuperior = 20;     // Margen superior
            const anchoMaximo = 190;       // Ancho máximo para el texto (respetando el margen)

            // Título del PDF
            doc.setFontSize(16);

            // Título del PDF
            doc.setFontSize(16);
            doc.text('Anexo III', margenIzquierdo, margenSuperior);

            // Posición inicial para el primer párrafo
            let yPosition = margenSuperior + 10; // Ajustamos para el título
            const lineHeight = 10; // Altura de cada línea

            // Función para agregar párrafos con ajuste de texto
            function agregarParrafo(texto) {
                // Dividir el texto en varias líneas si es necesario
                const lineas = doc.splitTextToSize(texto, anchoMaximo);

                // Imprimir cada línea dentro de los márgenes
                for (let i = 0; i < lineas.length; i++) {
                    doc.text(lineas[i], margenIzquierdo, yPosition);
                    yPosition += lineHeight;
                    
                    // Verificar si se supera el límite inferior de la página
                    if (yPosition > 270) {  // 270 es la posición aproximada en Y del margen inferior
                        doc.addPage();  // Si el texto sobrepasa la página, agregamos una nueva
                        yPosition = margenSuperior;  // Resetear la posición Y
                    }
                }
            }

            // Datos del formulario
            agregarParrafo('Salida Educativa/ Representación Institucional para alumnos/as menores de edad.');
            agregarParrafo('Autorización general para actividades en la Localidad');
            agregarParrafo('Por la presente autorizo a <?php echo $nombre; ?>, DNI <?php echo $dni; ?> estudiante de <?php echo $anio; ?> Año, sección <?php echo $seccion; ?>. Propuesta Educativa <?php echo $propuesta; ?> a participar de Salidas Educativas que se lleven a cabo en la ciudad o distrito, sin necesidad de utilizar un medio de transporte, y siempre acompañado/a de docentes responsables. ');
            agregarParrafo('Fecha: <?php echo $bday; ?>');
            agregarParrafo('Firma, aclaración y DNI (padre, madre o adulto responsable): …………………………………………………………………………………………………………………………………………………………………………………………………….');
            agregarParrafo('Aclaración: El presente anexo se debe completar y firmar por única vez, tendrá validez para cada ocasión en la que se requiera durante el presente ciclo lectivo y será archivado en el Legajo de cada Estudiante.');
            agregarParrafo('El mismo puede ser completado de forma digital, pero debe ser impreso y llevar la firma en original del adulto responsable. ');

            // Añadir un espacio adicional para separación antes de finalizar
            yPosition += 10;

            // Generar el PDF
            doc.save('formulario.pdf');
        }
    </script>
</head>
<body>
    <h1>ANEXO III</h1>
    <p>Salida Educativa/ Representación Institucional para alumnos/as menores de edad.</p>
        <p>Autorización general para actividades en la Localidad</p>
        
        <p>Por la presente autorizo a <?php echo $nombre; ?>. DNI <?php echo $dni; ?>.  estudiante de <?php echo $anio; ?> Año, sección <?php echo $seccion; ?>. Propuesta Educativa <?php echo $propuesta; ?> a participar de Salidas Educativas que se lleven a cabo en la ciudad o distrito, sin necesidad de utilizar un medio de transporte, y siempre acompañado/a de docentes responsables. </p>
        <p>La presente autorización es válida para actividades académicas, deportivas, culturales o comunitarias que se realicen durante el actual ciclo lectivo.</p>

        <p>Fecha: <?php echo $bday; ?></p>
        <p>Firma, aclaración y DNI (padre, madre o adulto responsable): ………………………………………………….
        ………………………………………………………………………………………………………………………………………………….</p>
        <p><strong>Aclaración:</strong> El presente anexo se debe completar y firmar por única vez, tendrá validez para cada ocasión en la que se requiera durante el presente ciclo lectivo y será archivado en el Legajo de cada Estudiante.</p> 
    <p>El mismo puede ser completado de forma digital, pero debe ser impreso y llevar la firma en original del adulto responsable. </p>

    <br>
    <button onclick="generarPDF()">Descargar PDF</button>
</body>
</html>