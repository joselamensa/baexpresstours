<?php
/**
 * @version 1.0
 */

// Deshabilitar el caché
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Iniciar o reanudar la sesión
session_start();

// Regenerar el ID de sesión
session_regenerate_id(true);

require("class.phpmailer.php");
require("class.smtp.php");

// Valores enviados desde el formulario
if ( !isset($_POST["nombre"]) || !isset($_POST["email"]) || !isset($_POST["fecha"]) || !isset($_POST["origen"]) || !isset($_POST["destino"]) || !isset($_POST["pasajeros"]) || !isset($_POST["equipaje"]) || !isset($_POST["celular"]) || !isset($_POST["idioma"]) ) {
    die ("Es necesario completar todos los datos del formulario");
}
$nombre = $_POST["nombre"];
$email = $_POST["email"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];
$origen = $_POST["origen"];
$destino = $_POST["destino"];
$numero_vuelo = $_POST["numero_vuelo"];
$pasajeros = $_POST["pasajeros"];
$equipaje = $_POST["equipaje"];
$celular = $_POST["celular"];
$idioma = $_POST["idioma"];

// Datos de la cuenta de correo utilizada para enviar vía SMTP
$smtpHost = "c2651292.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "donweb@baexpresstours.com.ar";  // Mi cuenta de correo
$smtpClave = "Baexpress12@";  // Mi contraseña

// Email donde se enviaran los datos cargados en el formulario de contacto
$emailDestino = "baexpresstours@gmail.com";

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'baexpresstours@gmail.com';
$mail->Password = 'tu_contraseña_de_aplicación';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;

$mail->setFrom('baexpresstours@gmail.com', 'BA Express Tours');
$mail->addAddress($emailDestino);

// VALORES A MODIFICAR //
$mail->Host = $smtpHost; 
$mail->Username = $smtpUsuario; 
$mail->Password = $smtpClave;

$mail->From = $email; // Email desde donde envío el correo.
$mail->FromName = $nombre;
$mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario

$mail->Subject = "Solicitud de traslado - BA Express Tours";
$mensajeHtml = "
<h2>Datos del viaje:</h2>
<p><strong>Fecha:</strong> {$fecha}</p>
<p><strong>Hora:</strong> {$hora}</p>
<p><strong>Origen:</strong> {$origen}</p>
<p><strong>Destino:</strong> {$destino}</p>
<p><strong>Número de vuelo:</strong> {$numero_vuelo}</p>
<p><strong>Pasajeros:</strong> {$pasajeros}</p>
<p><strong>Equipaje:</strong> {$equipaje}</p>

<h2>Datos de contacto:</h2>
<p><strong>Nombre:</strong> {$nombre}</p>
<p><strong>Celular:</strong> {$celular}</p>
<p><strong>Email:</strong> {$email}</p>
<p><strong>Idioma:</strong> {$idioma}</p>
";
$mail->Body = $mensajeHtml;
$mail->AltBody = "Fecha: {$fecha}\nOrigen: {$origen}\nDestino: {$destino}\nPasajeros: {$pasajeros}\nEquipaje: {$equipaje}\nNombre: {$nombre}\nCelular: {$celular}\nEmail: {$email}\nIdioma: {$idioma}";

// FIN - VALORES A MODIFICAR //

$estadoEnvio = $mail->Send(); 
if($estadoEnvio){
    echo json_encode(['success' => true, 'message' => 'El correo fue enviado correctamente.']);
} else {
    $errorMessage = $mail->ErrorInfo;
    error_log("Error al enviar email: " . $errorMessage);
    echo json_encode(['success' => false, 'message' => 'Ocurrió un error al enviar el correo: ' . $errorMessage]);
}