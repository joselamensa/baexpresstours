<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "baexpresstours@gmail.com";
    $subject = "Nuevo formulario de traslado aeroportuario";

    // Recoger los datos del formulario
    $fecha = $_POST['fecha'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $pasajeros = $_POST['pasajeros'];
    $equipaje = $_POST['equipaje'];
    $nombre = $_POST['nombre'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $idioma = $_POST['idioma'];

    // Construir el mensaje
    $message = "Nuevo formulario de traslado aeroportuario:\n\n";
    $message .= "Datos del viaje:\n";
    $message .= "Fecha: $fecha\n";
    $message .= "Origen: $origen\n";
    $message .= "Destino: $destino\n";
    $message .= "Pasajeros: $pasajeros\n";
    $message .= "Equipaje: $equipaje\n\n";
    $message .= "Datos de contacto:\n";
    $message .= "Nombre y apellido: $nombre\n";
    $message .= "Celular: $celular\n";
    $message .= "E-Mail: $email\n";
    $message .= "Idioma: $idioma\n";

    // Cabeceras del correo
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Enviar el correo
    if (mail($to, $subject, $message, $headers)) {
        echo "<p>Gracias por su solicitud. Nos pondremos en contacto con usted pronto.</p>";
    } else {
        echo "<p>Lo sentimos, hubo un problema al enviar su solicitud. Por favor, inténtelo de nuevo más tarde.</p>";
    }
} else {
    // Si alguien intenta acceder directamente a este archivo, redirigir a la página principal
    header("Location: index.html");
    exit();
}
?>