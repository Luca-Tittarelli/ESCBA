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
	date_default_timezone_set('America/Argentina/Cordoba');

	$fecha = $_POST['fecha'];
	$fecha = date($fecha.' H:i:s');
	// Limpiamos los datos para evitar que el usuario inyecte codigo.
	// Validamos que los datos hayan sido rellenados
	//$niveles_id = $_SESSION['usuario']['nivel'];
	$titulo = limpiarDatos($_POST['titulo']);
	$intro = limpiarDatos($_POST['intro']);
	$detalle = limpiarDatos($_POST['detalle']);
	$fuente = limpiarDatos($_POST['fuente']);
	$destacado = limpiarDatos($_POST['destacado']);
	$orden = limpiarDatos($_POST['orden']);


	//print_r($_POST);die;

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';

	//echo $imagen;die;
	// Comprobamos que ninguno de los campos este vacio.
	if (empty($fecha) or empty($titulo) or empty($intro)) {
		$errores .= '<li>Por favor rellena todos los datos correctamente</li>';
	} 

	if ($errores == '') {
//----------CODIGO PARA INSERTAR imagen
	//Recogemos el imagen enviado por el formulario
	$imagen = $_FILES['imagen']['name'];
	//Si el imagen contiene algo y es diferente de vacio
	if (isset($imagen) && $imagen != "") {
		//Obtenemos algunos datos necesarios sobre el imagen
		$tipo = $_FILES['imagen']['type'];
		$tamano = $_FILES['imagen']['size'];
		$temp = $_FILES['imagen']['tmp_name'];
		//echo $tipo.'-->'.$tamano;die;
		$imagen = time().$imagen;
		//Se comprueba si el imagen a cargar es correcto observando su extensión y tamaño
	if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 3145728))) {
		echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
		- Se permiten archivos .jpg, .png. y de 3 Mb como máximo.</b></div>';
	}
	else {

			//--------------REDIMENSIONAMOS LA IMAGEN VER COMO QUEREMOS HACER, SE PUEDE ASIGANAR ALTO Y ANCHO FIJO PONIENDO LOS VALORES EN NUEVO ALTO Y NUEVO_ANCHO

			$nueva = $temp;
			$porcentaje = 0.5;
			list($ancho, $alto) = getimagesize($nueva);
			$nuevo_ancho = $ancho * $porcentaje;
			$nuevo_alto = $alto * $porcentaje;
			//Redimensionar
			$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);

			if ($tipo == 'image/png' or $tipo == 'image/PNG') {
				$imagenR = imagecreatefrompng($nueva);
			}else{
				$imagenR = imagecreatefromjpeg($nueva);
			}

			imagecopyresampled($imagen_p, $imagenR, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
			// Sobreescribimos la imagen original con la reescalada 
			imagejpeg($imagen_p, $nueva);
			//Actualizo el tamaño al que tiene la imagen reescalada 
			$tamano = filesize($nueva);
			//echo $nueva;die;
			$temp = $nueva;
			///----------------FIN REDIMENSIONA IMAGEN--------------
		
			//Si la imagen es correcta en tamaño y tipo
			//Se intenta subir al servidor
			if (move_uploaded_file($temp, '../img/noticias/'.$imagen) and $errores == '') {
				//Cambiamos los permisos del imagen a 777 para poder modificarlo posteriormente
				//  chmod('uploads/'.$imagen, 0777);
				//Mostramos el mensaje de que se ha subido co éxito
				//  echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
				//Mostramos la imagen subida
				//  echo '<p><img src="uploads/'.$imagen.'"></p>';
			}else {
				//Si no se ha podido subir la imagen, mostramos un mensaje de error
				echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
			}	
		}
	}
//----FIN CODIGO IMAGEN

			$statement = $conexion->prepare('INSERT INTO noticias (id, fecha, titulo, intro, detalle, imagen, fuente, orden, destacado, borrado)
														VALUES  (null, :fecha, :titulo, :intro, :detalle, :imagen, :fuente, :orden, :destacado, 0)');
			//print_r($statement) ;die;
			$statement->execute(array(
				':fecha' => $fecha,
				':titulo' => $titulo,
				':intro' => $intro,
				':detalle' => $detalle,
				':imagen' => $imagen,
				':fuente' => $fuente,
				':orden' => $orden,
				':destacado' => $destacado,
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		
		
		if ($statement) {
			$mensaje = 'e';
		}
		header("Location: " . RUTA . '/admin/noticias.php?e='.$mensaje); //volvemos al editarUsuario 
	}else{
		header("Location: " . RUTA . 'admin/nuevaNoticia.php?errores='.$errores); //volvemos al editarUsuario 

	}
		//fin if errores vacia o sea que todo esta correcto
} //-CIERRE IF METODO POST


require 'views/nuevaNoticia.view.php';

?>