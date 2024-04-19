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
# Si se envian por POST significa que el usuario los ha enviado desde el formulario
# por lo que tomamos los datos y los cambiamos en la base de datos.

# De otra forma significa que hay datos enviados por el metodo GET
# es decir, el ID que pasamos por la URL, si es asi entonces traemos los 
# datos de la base de datos a pantalla para que el usuario los pueda modificar.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Limpiamos los datos para evitar que el usuario inyecte codigo.
	// Validamos que los datos hayan sido rellenados
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	//$niveles_id = $_SESSION['usuario']['nivel'];
	$niveles_id = limpiarDatos($_POST['nivel']);
	$nombre = limpiarDatos($_POST['nombre']);
	$apellido = limpiarDatos($_POST['apellido']);
	$email = limpiarDatos($_POST['email']);
	$telefono = limpiarDatos($_POST['telefono']);
	$usuarioControl = limpiarDatos($_POST['usuarioControl']);
	$emailControl = limpiarDatos($_POST['emailControl']);
	$id = limpiarDatos($_POST['id']);
	


	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';
	// Comprobamos que el usuario no exista ya.
	//hacemos la consulta par ver si el usuario ya existe en la db.si esxiste le damos mensaje de error
	$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
	//ejecutamo la consulta
	$statement->execute(array(
						':usuario' => $usuario
					));
	// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
	$resultado = $statement->fetch();
	
	//var_dump($resultado);die;
	//VALIDAMOS QUE SE HAYA CAMBIADO EL USUARIO PARA NO DUPLICARLO EN LA DB
	if ($usuarioControl != $usuario) {

		//var_dump($resultado);
		// Si resultado es diferente a false entonces significa que ya existe el usuario.
		if ($resultado != false) {
			$errores .= '<li>El nombre de usuario ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
	}


	$statementMail = $conexion->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
	//ejecutamo la consulta
	$statementMail->execute(array(
						':email' => $email
					));
	// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
	$resultadoMail = $statementMail->fetch();
	if ($emailControl != $email) {

		//var_dump($resultado);
		// Si resultado es diferente a false entonces significa que ya existe el usuario.
		if ($resultadoMail != false) {
			$errores .= '<li>El email ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
	}

	//var_dump($resultado);die;
	if ($password != '' or $password2 != '') {
		$password = hash('sha512', $password); //sha512 es un tipo de algoritmo de encripatado, existen varios
		//echo $password;
		$password2 = hash('sha512', $password2);
		
		// Comprobamos que las contraseñas sean iguales.
		if ($password != $password2) {
			$errores.= '<li>Las contraseñas no son iguales</li>';
		}
	}else{
		$password = obtener_usuario_por_id($conexion, $id);
		
		$password = $password[0];
		$password = $password['pass'];
		//var_dump ($password);die;
	}
	//var_dump($resultado);die;

/*
	// Comprobamos que ninguno de los campos este vacio.
	if (empty($usuario) or empty($password) or empty($password2)) {
		$errores .= '<li>Por favor rellena todos los datos correctamente</li>';
	} else {
		// Comprobamos que el usuario no exista ya.
		//hacemos la consulta par ver si el usuario ya existe en la db.si esxiste le damos mensaje de error
		$statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
		//ejecutamo la consulta
		$statement->execute(array(':usuario' => $usuario));
		// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
		$resultado = $statement->fetch();
		//var_dump($resultado);
		// Si resultado es diferente a false entonces significa que ya existe el usuario.
		if ($resultado != false) {
			$errores .= '<li>El nombre de usuario ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
		$password = hash('sha512', $password); //sha512 es un tipo de algoritmo de encripatado, existen varios
		//echo $password;
		$password2 = hash('sha512', $password2);

		// Comprobamos que las contraseñas sean iguales.
		if ($password != $password2) {
			$errores.= '<li>Las contraseñas no son iguales</li>';
		}
		
	}//cierre if si los campos tienen algun dato*/

	
	if ($errores == '') {
			$statement = $conexion->prepare('UPDATE db_institucion.usuarios SET  niveles_id = :niveles_id, usuario = :usuario, pass = :pass, nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono WHERE id = :id');
			//echo $errores;
			$statement->execute(array(
				':niveles_id' => $niveles_id,
				':usuario' => $usuario,
				':pass' => $password,
				':nombre' => $nombre,
				':apellido' => $apellido,
				':email' => $email,
				':telefono' => $telefono,
				':id' => $id
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		if ($statement) {
			$mensaje = 'o';
		}
		header("Location: " . RUTA . 'admin/editarUsuario.php?id='.$id.'&e='.$mensaje); //volvemos al editarUsuario 
	}else {
		header("Location: " . RUTA . 'admin/editarUsuario.php?id='.$id.'&errores='.$errores); //volvemos al editarUsuario 
	}//fin if errores vacia o sea que todo esta correcto
} else { //sino  viene request post
			$id_usuario = id_usuario($_GET['id']);

			//si el usuario no esta seteado mandamod a listado de usuarios
			if (empty($id_usuario)) {
				header('Location: ' . RUTA . 'admin/usuarios.php');
			}

			// Obtenemos el usuario por id
			$usuario = obtener_usuario_por_id($conexion, $id_usuario);

			// Si no hay usuario en el ID entonces redirigimos.
			if (!$usuario) {
				header('Location: ' . RUTA . 'admin/index.php');
			}
			
			$usuario = $usuario[0];
			//ECHO '<PRE>';
			//print_R($usuario);
}//fin request method post


require 'views/editarUsuario.view.php';

?>