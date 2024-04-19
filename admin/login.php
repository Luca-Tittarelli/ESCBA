<?php 
session_start(); //iniciamos session
require 'config.php';
require '../functions.php';
// Comprobamos si ya tiene una sesion
# Si ya tiene una sesion redirigimos al contenido, para que no pueda acceder al formulario
//ESTE CODIGO LO PODEMOS METER EN UN ARCHIVO EXTERNO Y CREAR UNA FUNCION PARA LUEGO REUTILIZAR, YA LO VEREMOS MAS ADELANTE
//comprobarSession(); //llamado a la funcion, no usada en este momento
if (isset($_SESSION['usuario'])) {
	header('Location: index.php');
	die();
}


// Comprobamos si ya han sido enviado los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$usuario = limpiarDatos($_POST['usuario']);
	$password = limpiarDatos($_POST['password']);

	$password = hash('sha512', $password);
	//echo $password;
	// Nos conectamos a la base de datos
	try {
		$conexion = conexion($bd_config);
	} catch (PDOException $e) {
		echo "Error:" . $e->getMessage();
	}

	$statement = $conexion->prepare('SELECT t1.id, t1.niveles_id, t1.nombre, t1.apellido, t1.pass, t1.email, t1.telefono, t1.borrado,
								 			t2.id as idNivel, t2.nivel 
								 	FROM usuarios t1 
									INNER JOIN niveles t2 ON (t2.id = t1.niveles_id)
										WHERE t1.usuario = :usuario AND t1.pass = :password');
	$statement->execute(array(
			':usuario' => $usuario,
			':password' => $password
		));
	
	$resultado = $statement->fetch();
	//print_r($resultado);die();
	//var_dump($resultado);die;
	//si resultado es distinto de false o sea que los datos son correctos, nos manda al index. sino error
	if ($resultado !== false) {
		//CARGAMOS LOS DATOS EN LA SESION
		$_SESSION['usuario']['usuario'] = $usuario;
		$_SESSION['usuario']['nombre'] = $resultado['nombre'];
		$_SESSION['usuario']['apellido'] = $resultado['apellido'];
		$_SESSION['usuario']['email'] = $resultado['email'];
		$_SESSION['usuario']['telefono'] = $resultado['telefono'];
		$_SESSION['usuario']['nivel'] = $resultado['idNivel'];
		//echo '<pre>';
		//print_r($_SESSION);die();
		//header('Location: index.php');
		header('Location: '. RUTA . '/admin');
	} else {
		$errores = '<li>Datos incorrectos</li>';
	}
} //CIERRE IF METODO POST

require 'views/login.view.php';

?>