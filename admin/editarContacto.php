<?php session_start();
require 'config.php';
require '../functions.php';

// 1.- Conectamos a la base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

// Comprobamos si la session esta iniciada, sino, redirigimos.
comprobarSession();

// Determinamos si se estan enviado datos por el metodo POST o GET
# Si se envian por POST significa que el contacto los ha enviado desde el formulario
# por lo que tomamos los datos y los cambiamos en la base de datos.

# De otra forma significa que hay datos enviados por el metodo GET
# es decir, el ID que pasamos por la URL, si es asi entonces traemos los 
# datos de la base de datos a pantalla para que el contacto los pueda modificar.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Limpiamos los datos para evitar que el contacto inyecte codigo.
	// Validamos que los datos hayan sido rellenados

	$nombre = limpiarDatos($_POST['nombre']);
	$apellido = limpiarDatos($_POST['apellido']);
	$email = filter_var(strtolower($_POST['email']), FILTER_SANITIZE_STRING);
	$email = limpiarDatos($email);
	$emailControl = limpiarDatos($_POST['emailControl']);
	$telControl = limpiarDatos($_POST['telControl']);
	$telefono = limpiarDatos($_POST['telefono']);
	$mensaje = limpiarDatos($_POST['mensaje']);

	$id = limpiarDatos($_POST['id']);
	

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';
	// Comprobamos que el usuario no exista ya.
	//hacemos la consulta par ver si el usuario ya existe en la db.si esxiste le damos mensaje de error
	$statement = $conexion->prepare('SELECT * FROM contactos WHERE email = :email AND borrado = 0 LIMIT 1');
	//ejecutamo la consulta
	$statement->execute(array(
						':email' => $email
					));
	// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
	$resultado = $statement->fetch();
	
	//var_dump($resultado);die;
	//VALIDAMOS QUE SE HAYA CAMBIADO EL EMAIL PARA NO DUPLICARLO EN LA DB
	if ($emailControl != $email) {

		//var_dump($resultado);
		// Si resultado es diferente a false entonces significa que ya existe el EMAIL.
		if ($resultado != false) {
			$errores .= '<li>El email ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
	}

	$statementTel = $conexion->prepare('SELECT * FROM contactos WHERE telefono = :telefono AND borrado = 0 LIMIT 1');
	//ejecutamo la consulta
	$statementTel->execute(array(
						':telefono' => $telefono
					));
	// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
	$resultadoTel = $statementTel->fetch();
	if ($telControl != $telefono) {

		//var_dump($resultadoTel);die;
		// Si resultado es diferente a false entonces significa que ya existe el usuario.
		if ($resultadoTel != false) {
			$errores .= '<li>El teléfono ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
	}



	if ($errores == '') {
			$statement = $conexion->prepare('UPDATE db_institucion.contactos SET  nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, mensaje = :mensaje WHERE id = :id');
			//echo $errores;
			$statement->execute(array(
				':nombre' => $nombre,
				':apellido' => $apellido,
				':email' => $email,
				':telefono' => $telefono,
				':mensaje' => $mensaje,
				':id' => $id
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		if ($statement) {
			$mensaje = 'o';
		}
		header("Location: " . RUTA . 'admin/editarContacto.php?id='.$id.'&e='.$mensaje); //volvemos al editarUsuario 
	}else {
		header("Location: " . RUTA . 'admin/editarContacto.php?id='.$id.'&errores='.$errores); //volvemos al editarUsuario 
	}//fin if errores vacia o sea que todo esta correcto
} else { //sino  viene request post
			$id_contacto = id_contacto($_GET['id']);

			//si el usuario no esta seteado mandamod a listado de usuarios
			if (empty($id_contacto)) {
				header('Location: ' . RUTA . 'admin/contactos.php');
			}

			// Obtenemos el usuario por id
			$contacto = obtener_contacto_por_id($conexion, $id_contacto);

			// Si no hay contacto en el ID entonces redirigimos.
			if (!$contacto) {
				header('Location: ' . RUTA . 'admin/index.php');
			}
			
			$contacto = $contacto[0];
			//ECHO '<PRE>';
			//print_R($contacto);
}//fin request method post


require 'views/editarContacto.view.php';

?>