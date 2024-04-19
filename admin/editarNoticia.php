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
	$orden = limpiarDatos($_POST['orden']);
	$destacado = limpiarDatos($_POST['destacado']);
	$id = limpiarDatos($_POST['id']);

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';


	if ($errores == '') {

	//----------CODIGO PARA INSERTAR imagen
	//Recogemos el archivo enviado por el formulario
	if(!empty($_FILES['imagen'])){
		$imagen = $_FILES['imagen']['name'];
		//$imagen = time().$imagen;
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
				$errores .= '<li>Error. La extensión o el tamaño de los archivos no es correcta - Se permiten archivos  .jpg, .png. y de 3 Mb como máximo.</li>';
			}else {
					//--------------REDIMENSIONAMOS LA IMAGEN VER COMO QUEREMOS HACER, SE PUEDE ASIGANAR ALTO Y ANCHO FIJO PONIENDO LOS VALORES EN NUEVO ALTO Y NUEVO_ANCHO
					/*
					$nueva = $temp;
					$porcentaje = 0.5;
					list($ancho, $alto) = getimagesize($nueva);
					$nuevo_ancho = $ancho * $porcentaje;
					$nuevo_alto = $alto * $porcentaje;
					//Redimensionar
					$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
					$imagen = imagecreatefromjpeg($nueva);
					imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
					// Sobreescribimos la imagen original con la reescalada 
					imagejpeg($imagen_p, $nueva);
					//Actualizo el tamaño al que tiene la imagen reescalada 
					$tamano = filesize($nueva);
					//echo $nueva;die;
					$temp = $nueva;*/
					///----------------FIN REDIMENSIONA IMAGEN--------------
					//--------------REDIMENSIONAMOS LA IMAGEN VER COMO QUEREMOS HACER, SE PUEDE ASIGANAR ALTO Y ANCHO FIJO PONIENDO LOS VALORES EN NUEVO ALTO Y NUEVO_ANCHO
					
					$nueva = $temp;
					$porcentaje = 0.5;
					list($ancho, $alto) = getimagesize($nueva);
					$nuevo_ancho = $ancho * $porcentaje;
					$nuevo_alto = $alto * $porcentaje;
					//Redimensionar
					$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
					//echo $tipo;die;
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

				if (move_uploaded_file($temp, '../img/noticias/'.$imagen)) {
					$concatena = ',imagen = "'.$imagen.'"'; //Esta variable se utiliza para que si el usuario no cambie la imagen, no se interte ni modifique anda en la base de datos
					//echo $concatena;die;
					//Cambiamos los permisos del imagen a 777 para poder modificarlo posteriormente
					//  chmod('../img/noticias/'.$imagen, 0777);
					//Mostramos el mensaje de que se ha subido co éxito
					//  $errores .= '<li>Se ha subido correctamente la imagen.</li>';
					//Mostramos la imagen subida
					//  echo '<p><img src="../img/noticias/'.$imagen.'"></p>';
			
				}
				else {
					//Si no se ha podido subir la imagen, mostramos un mensaje de error
					$errores .='<li>Ocurrió algún error al subir el fichero. No pudo guardarse.</li>';
				}
			}
		}
	}else {
		$concatena=''; //Esta variable se utiliza para que si el usuario no cambie la imagen, no se interte ni modifique anda en la base de datos
	}
	//----FIN CODIGO IMAGEN

			$statement = $conexion->prepare('UPDATE noticias SET titulo = :titulo, 
																	fecha = :fecha, 
																	intro = :intro, 
																	detalle = :detalle,
																	fuente = :fuente,
																	orden = :orden,
																	destacado = :destacado  
																	'.$concatena.'
																	WHERE id = :id');
			//echo $errores;
			$statement->execute(array(
				':titulo' => $titulo,
				':fecha' => $fecha,
				':intro' => $intro,
				':detalle' => $detalle,
				':fuente' => $fuente,
				':orden' => $orden,
				':destacado' => $destacado,
				':id' => $id
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		if ($statement) {
			$mensaje = 'o';
		}
		header("Location: " . RUTA . 'admin/editarNoticia.php?id='.$id.'&e='.$mensaje); //volvemos al editarUsuario 
	}else {
		header("Location: " . RUTA . 'admin/editarNoticia.php?id='.$id.'&errores='.$errores); //volvemos al editarUsuario 
	}//fin if errores vacia o sea que todo esta correcto
} else { //sino  viene request post
			$id_noticia = id_noticia($_GET['id']);

			//si el usuario no esta seteado mandamod a listado de usuarios
			if (empty($id_noticia)) {
				header('Location: ' . RUTA . 'admin/noticias.php');
			}

			// Obtenemos el usuario por id
			$noticia = obtener_noticia_por_id($conexion, $id_noticia);

			// Si no hay contacto en el ID entonces redirigimos.
			if (!$noticia) {
				header('Location: ' . RUTA . 'admin/index.php');
			}


			$noticia = $noticia[0];
			//ECHO '<PRE>';
			//print_R($noticia);
			//IMAGENES DE GALERIA
			$imagenesGal = obtener_imagenes_por_id_noticias($conexion, $id_noticia);
			//ECHO '<PRE>';
			//print_R($imagenesGal);
}//fin request method post


require 'views/editarNoticia.view.php';

?>