<?php session_start(); //iniciamos la sesion ya que vamos a trabajar con sesiones

// Comprobamos si ya tiene una sesion
# Si ya tiene una sesion redirigimos al contenido, para que no pueda volver a registrar un usuario.
if (isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}

// Comprobamos si ya han sido enviado los datos
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Validamos que los datos hayan sido rellenados
	$usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

// // Tambien podemos limpiar mediante las funciones
// 	# El problema es que si lo hacemos de esta forma no estamos eliminando caracteres especiales, solo los transformamos.
	
// 	// La funcion htmlspecialchars() convierte caracteres especiales en entidades HTML, (&, "", '', <, >)
// 	$usuario = htmlspecialchars($_POST['usuario']);
// 	// La funcion trim() elimina espacio en blanco al inicio y final de la cadena de texo
// 	$usuario = trim($usuario);
// 	// stripslashes() quita las barras de un string con comillas escapadas, los \ los convierte en \'
// 	$usuario = stripslashes($usuario);

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';

	// Comprobamos que ninguno de los campos este vacio.
	if (empty($usuario) or empty($password) or empty($password2)) {
		$errores .= '<li>Por favor rellena todos los datos correctamente</li>';
	} else {

		// Comprobamos que el usuario no exista ya.
		try {
			$conexion = new PDO('mysql:host=localhost;dbname=creandoLogin', 'root', '');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage();
		}

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
	}//cierre ir si los campos tienen algun dato

	// Comprobamos si hay errores, sino entonces agregamos el usuario y redirigimos.
	//sino hay errores, registramos el usuario y lo redirigimos al login
	if ($errores == '') {
		//hacemmos el insert
		$statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, pass) VALUES (null, :usuario, :pass)');
		//reemplazamo los placeholder con el siguiente array
		$statement->execute(array(
				':usuario' => $usuario,
				':pass' => $password
			));

		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		// Despues de registrar al usuario redirigimos para que inicie sesion.
		header('Location: login.php');
	}


}// cierre if request methid

require 'views/registrate.view.php';
//ESTE ARCHIVO SE PODRAI MODIFICAR MUCHISIMO MAS QUEDA A CRITERIO DE CADA UNO 
?>