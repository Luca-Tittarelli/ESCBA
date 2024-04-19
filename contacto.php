<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'admin/config.php';
require 'functions.php';

// agrego la libreria de swift mailer
//require_once 'vendors/swiftmailer/lib/swift_required.php';
require_once 'vendor/autoload.php';
// Use de los espacios de nombres (namespaces) de PHPMailer
// Los use se colocan en la parte superior del script de PHP
// Estos son los use de las claes más importantes que puedes necesitar con PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//incluimos la clase PHPMailer
// Una vez declarados los namespaces simplemente tenemos que instanciar las clases por su nombre
$mail = new PHPMailer(true);

$conexion = conexion($bd_config);

if (!$conexion) {
	header('Location: error.php');
}

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';
   
	

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

	// Limpiamos los datos para evitar que el usuario inyecte codigo.
	// Validamos que los datos hayan sido rellenados
	//$niveles_id = $_SESSION['usuario']['nivel'];
	$nombre = limpiarDatos($_POST['nombre']);
	$apellido = limpiarDatos($_POST['apellido']);
	$telefono = limpiarDatos($_POST['telefono']);
    $email = limpiarDatos($_POST['email']);
	$mensajeTexto = limpiarDatos($_POST['mensajeTexto']);
	




	// Comprobamos que ninguno de los campos este vacio.
	if (empty($nombre) or empty($apellido) or empty($email) or empty($telefono)) {
		$errores .= '<li>Por favor rellena todos los datos correctamente</li>';
	} else {
	
		// Comprobamos que el usuario no exista ya.
		//hacemos la consulta par ver si el usuario ya existe en la db.si esxiste le damos mensaje de error
		$statement = $conexion->prepare('SELECT * FROM contactos WHERE  email = :email AND borrado = 0 LIMIT 1');
		//ejecutamo la consulta
		$statement->execute(array(
							'email' => $email
						));
		// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
		$resultadoM = $statement->fetch();

		$statement = $conexion->prepare('SELECT * FROM contactos WHERE  telefono = :telefono AND borrado = 0 LIMIT 1');
		//ejecutamo la consulta
		$statement->execute(array(
							'telefono' => $telefono
						));
		// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
		$resultadoT = $statement->fetch();

		//var_dump($resultado);
		//var_dump($_POST);die;


		//var_dump($resultado);
		// Si el usuario que se envia es igual al de la DB entonces significa que ya existe el usuario.
		if (isset($resultadoT['telefono']) == $telefono) {
			$errores .= '<li>El Teléfono ya existe</li>';
			$idCon = $resultadoT['id'];
		}

		// Si el email que se envia es igual al de la DB entonces significa que ya existe el usuario.
		if (isset($resultadoM['email']) == $email) {
			$errores .= '<li>El email ya existe</li>';
			$idCon = $resultadoM['id'];
		}

	
	}//cierre ir si los campos tienen algun dato

	if ($errores == '') {
			$statement = $conexion->prepare('INSERT INTO contactos (id, nombre, apellido, email, telefono, fecha, mensaje, borrado)
														VALUES  (null, :nombre, :apellido, :email, :telefono, NOW(), :mensaje, 0)');
			//print_r($statement) ;die;
			$statement->execute(array(
				':nombre' => $nombre,
				':apellido' => $apellido,
				':email' => $email,
				':telefono' => $telefono,
				':mensaje' => $mensajeTexto
			));

					//----------------PHPMAILER--------------
			//instancio un objeto de la clase PHPMailer
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->IsSMTP();
			$mail->SMTPAuth = false;
			$mail->Host = IP_HOST;
			$mail->Port = PORT_HOST;
			$mail->SMTPAutoTLS = false;
			
			//defino el cuerpo del mensaje en una variable $body
			//se trae el contenido de un archivo de texto
			//también podríamos hacer $body="contenido...";
			$body = 'Nombre: ' . $nombre . '<br>';
			$body .= 'Apellido: ' . $apellido . '<br>';
			$body .= 'Teléfono: ' . $telefono . '<br>';
			$body .= 'Email: ' . $email . '<br><br>';
			$body .= 'Mensaje: <br>' . utf8_decode($mensajeTexto);
			
			
			$html = file_get_contents('acuse/mail.html');
			$html = str_replace('{FECHA}',date('d/m/Y H:s'), $html);
			$html = str_replace('{ASUNTO}', 'Contacto',$html);
			$html = str_replace('{BODY}', $body, $html);

			$mail->Username = SMTP_USER;
			$mail->Password = SMTP_PASS;
			//defino el email y nombre del remitente del mensaje
			$mail->SetFrom(SMTP_USER, PROJECT_NAME);
			$mail->AddReplyTo(SMTP_USER, PROJECT_NAME);
			$address = $email;
			
			//la añado a la clase, indicando el nombre de la persona destinatario
			$mail->AddAddress($address, PROJECT_NAME);
			//Añado un asunto al mensaje
			$mail->Subject = PROJECT_NAME.' :: Contacto de ' .$nombre.' '.$apellido;
			//Puedo definir un cuerpo alternativo del mensaje, que contenga solo texto
			//$mail->AltBody = "Cuerpo alternativo del mensaje";
			
			//inserto el texto del mensaje en formato HTML
			$mail->MsgHTML($html);
			//var_dump($mail);die;
			//envío el mensaje, comprobando si se envió correctamente
			if(!$mail->Send()) {
				$e = 'Error al Enviar n1';
			} else {
				$e = 'ok';
			}
			header('Location: contacto.php?send=' . $e);
			exit;

    }elseif (isset($resultadoM['email']) == $email or isset($resultadoT['telefono']) == $telefono) {
		$errores = '';

	
			$statement = $conexion->prepare('UPDATE contactos SET  mensaje = :mensaje WHERE id = :id');
			//echo $errores;
			$statement->execute(array(
				':mensaje' => $mensajeTexto,
				':id' => $idCon
			));
			$errores .= '<li>El email o Teléfono ya existen. SE ENVIÓ SU CONSULTA</li>';
			
			//----------------PHPMAILER--------------
			//instancio un objeto de la clase PHPMailer
			$mail = new PHPMailer(); // defaults to using php "mail()"
			$mail->IsSMTP();
			$mail->SMTPAuth = false;
			$mail->Host = IP_HOST;
			$mail->Port = PORT_HOST;
			$mail->SMTPAutoTLS = false;
			
			//defino el cuerpo del mensaje en una variable $body
			//se trae el contenido de un archivo de texto
			//también podríamos hacer $body="contenido...";
			$body = 'Nombre: ' . $nombre . '<br>';
			$body .= 'Apellido: ' . $apellido . '<br>';
			$body .= 'Teléfono: ' . $telefono . '<br>';
			$body .= 'Email: ' . $email . '<br><br>';
			$body .= 'Mensaje: <br>' . utf8_decode($mensajeTexto);
			

			$html = file_get_contents('acuse/mail.html');
			$html = str_replace('{FECHA}',date('d/m/Y H:s'), $html);
			$html = str_replace('{ASUNTO}', 'Contacto',$html);
			$html = str_replace('{BODY}', $body, $html);

			$mail->Username = SMTP_USER;
			$mail->Password = SMTP_PASS;
			//defino el email y nombre del remitente del mensaje
			$mail->SetFrom(SMTP_USER, PROJECT_NAME);
			$mail->AddReplyTo(SMTP_USER, PROJECT_NAME);
			$address = $email;
			
			//la añado a la clase, indicando el nombre de la persona destinatario
			$mail->AddAddress($address, PROJECT_NAME);
			//Añado un asunto al mensaje
			$mail->Subject = PROJECT_NAME.' :: Contacto de ' .$nombre.' '.$apellido;
			//Puedo definir un cuerpo alternativo del mensaje, que contenga solo texto
			//$mail->AltBody = "Cuerpo alternativo del mensaje";
			
			//inserto el texto del mensaje en formato HTML
			$mail->MsgHTML($html);
			//var_dump($mail);die;
			//envío el mensaje, comprobando si se envió correctamente
			if(!$mail->Send()) {
				$e = 'Error al Enviar n1';
			} else {
				$e = 'ok';
			}
			header('Location: contacto.php?send=' . $e);
			exit;
			

	}
		//fin if errores vacia o sea que todo esta correcto
} //-CIERRE IF METODO POST

 require 'view/contacto-view.php'; 


?>
