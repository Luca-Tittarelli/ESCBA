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
	//$niveles_id = $_SESSION['usuario']['nivel'];
	$nombre = limpiarDatos($_POST['nombre']);
	$apellido = limpiarDatos($_POST['apellido']);
	$email = limpiarDatos($_POST['email']);
	$telefono = limpiarDatos($_POST['telefono']);
	$mensaje = limpiarDatos($_POST['mensaje']);
	


	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';

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
		$resultado = $statement->fetch();
	
		//var_dump($resultado);
		//VALIDAMOS QUE SE HAYA CAMBIADO EL USUARIO PARA NO DUPLICARLO EN LA DB

		//var_dump($resultado);
		// Si el usuario que se envia es igual al de la DB entonces significa que ya existe el usuario.
		if ($resultado['telefono'] == $telefono) {
			$errores .= '<li>El Teléfono ya existe</li>';
		}

		// Si el email que se envia es igual al de la DB entonces significa que ya existe el usuario.
		if ($resultado['email'] == $email) {
			$errores .= '<li>El email ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
	
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
				':mensaje' => $mensaje
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		if ($statement) {
			$mensaje = 'e';
		}
		header("Location: " . RUTA . '/admin/contactos.php?e='.$mensaje); //volvemos al editarUsuario 
	}else{
		header("Location: " . RUTA . 'admin/nuevoContacto.php?errores='.$errores); //volvemos al editarUsuario 

	}
		//fin if errores vacia o sea que todo esta correcto
} //-CIERRE IF METODO POST


require 'views/nuevoContacto.view.php';

?>