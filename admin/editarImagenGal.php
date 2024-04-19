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

	$epigrafe = limpiarDatos($_POST['epigrafe']);
	$id = limpiarDatos($_POST['id']);
	$id_imagen = limpiarDatos($_POST['id_imagen']);
	

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';


	if ($errores == '') {
			$statement = $conexion->prepare('UPDATE imagenes SET  epigrafe = :epigrafe WHERE id = :id_imagen');
			//print_r($statement);die;
			$statement->execute(array(
				':epigrafe' => $epigrafe,
				':id_imagen' => $id_imagen
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		if ($statement) {
			$mensaje = 'epi';
		}
		header("Location: " . RUTA . 'admin/editarNoticia.php?id='.$id.'&e='.$mensaje); //volvemos al editarUsuario 
	}else {
		header("Location: " . RUTA . 'admin/editarNoticia.php?id='.$id.'&errores='.$errores); //volvemos al editarUsuario 
	}//fin if errores vacia o sea que todo esta correcto
} else { //sino  viene request post
			$id_imagen = id_imagen($_GET['id_imagen']);

			//si el usuario no esta seteado mandamod a listado de usuarios
			if (empty($id_imagen)) {
				header('Location: ' . RUTA . 'admin/noticias.php');
			}

			// Obtenemos el usuario por id
			$imagen = obtener_imagen_por_id($conexion, $id_imagen);

			// Si no hay contacto en el ID entonces redirigimos.
			if (!$imagen) {
				header('Location: ' . RUTA . 'admin/index.php');
			}
			
			$imagen = $imagen[0];
			//ECHO '<PRE>';
			//print_R($contacto);
}//fin request method post


require 'views/editarImagenGal.view.php';

?>