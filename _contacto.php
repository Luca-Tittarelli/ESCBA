<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'admin/config.php';
require 'functions.php';

$conexion = conexion($bd_config);

if (!$conexion) {
	header('Location: error.php');
}

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';
    $enviado = '';
	

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
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
        //die;// Despues de registrar al usuario redirigimos para que inicie sesion.
        //sino hay errores enviamos el mail
        $enviar_a = 'gregorioboglione@gmail.com';
        $asunto = 'Correo enviado desde mi Web';
        $mensaje_preparado = "De: $nombre \n";
        $mensaje_preparado.= "Correo: $email \n";
        $mensaje_preparado.= "Teléfono: $telefono \n";
        $mensaje_preparado .= "Mensaje: " .$mensajeTexto;

        //funcion mail de php para el envio de correo mail sino funciona es porque no esta en un servidoer el stio
       
       mail($enviar_a, $asunto, $mensaje_preparado);
       $enviado = true;

    }elseif (isset($resultadoM['email']) == $email or isset($resultadoT['telefono']) == $telefono) {
		$errores = '';

	
			$statement = $conexion->prepare('UPDATE contactos SET  mensaje = :mensaje WHERE id = :id');
			//echo $errores;
			$statement->execute(array(
				':mensaje' => $mensajeTexto,
				':id' => $idCon
			));
			$errores .= '<li>El email o Teléfono ya existen. SE ENVIÓ SU CONSULTA</li>';
			
			$enviar_a = 'gregorioboglione@gmail.com';
			$asunto = 'Correo enviado desde mi Web';
			$mensaje_preparado = "De: $nombre \n";
			$mensaje_preparado.= "Correo: $email \n";
			$mensaje_preparado.= "Teléfono: $telefono \n";
			$mensaje_preparado .= "Mensaje: " .$mensajeTexto;
	
			//funcion mail de php para el envio de correo mail sino funciona es porque no esta en un servidoer el stio
		   
			mail($enviar_a, $asunto, $mensaje_preparado);
			

	}
		//fin if errores vacia o sea que todo esta correcto
} //-CIERRE IF METODO POST

 require 'view/contacto-view.php'; 


?>
