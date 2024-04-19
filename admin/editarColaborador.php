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
	// Limpiamos los datos para evitar que el contacto inyecte codigo.
	// Validamos que los datos hayan sido rellenados
	$razonSocial = limpiarDatos($_POST['razonSocial']);
	$fechaAlta = limpiarDatos($_POST['fechaAlta']);
	$fechaBaja = limpiarDatos($_POST['fechaBaja']);
	$sitioWeb = filter_var(strtolower($_POST['sitioWeb']), FILTER_SANITIZE_STRING);
	$sitioWebControl = filter_var(strtolower($_POST['sitioWebControl']), FILTER_SANITIZE_STRING);
	
	$id = limpiarDatos($_POST['id']);
	$fechaAlta = date($fechaAlta.' H:i:s');
	$fechaBaja = date($fechaBaja.' H:i:s');
	$destacado = limpiarDatos($_POST['destacado']);

	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';



	//echo $fechaAlta ;die;

	// Comprobamos que el usuario no exista ya.
	//hacemos la consulta par ver si el usuario ya existe en la db.si esxiste le damos mensaje de error
	$statement = $conexion->prepare('SELECT * FROM colaboradores WHERE sitioWeb = :sitioWeb AND borrado = 0 LIMIT 1');
	//ejecutamo la consulta
	$statement->execute(array(
						':sitioWeb' => $sitioWeb
					));
	// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
	$resultado = $statement->fetch();
;
	//var_dump($resultado);die;
	//VALIDAMOS QUE SE HAYA CAMBIADO EL EMAIL PARA NO DUPLICARLO EN LA DB
	if ($sitioWebControl != $sitioWeb) {

		//var_dump($resultado);
		// Si resultado es diferente a false entonces significa que ya existe el EMAIL.
		if ($resultado != false) {
			$errores .= '<li>El Sitio Web ya existe</li>';
		}
		// Hasheamos nuestra contraseña para protegerla un poco.
		# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
		# pero esto no asegura por completo la informacion encriptada.
	}

	//----------------CONTORL QUE LA FECHA DE ALTA SEA MENOR A LA FECHA DE BAJA-----------------
	if ($fechaAlta > $fechaBaja) {
		$errores .= '<li>La fecha de Alta debe ser Menor a la Fecha de Baja</li>';
	}

	//---------------FIN CONTROL FECHA DE ALTA MAOYR A LA FECHABAJA-----------------------------

	if ($errores == '') {

	//----------CODIGO PARA INSERTAR imagen
	//Recogemos el archivo enviado por el formulario
	if(!empty($_FILES['logo'])){
		$logo = $_FILES['logo']['name'];
		//$logo = time().$logo;
		//Si el logo contiene algo y es diferente de vacio
		if (isset($logo) && $logo != "") {
			
			//Obtenemos algunos datos necesarios sobre el logo
			$tipo = $_FILES['logo']['type'];
			$tamano = $_FILES['logo']['size'];
			$temp = $_FILES['logo']['tmp_name'];
			//echo $tipo.'-->'.$tamano;die;
			$logo = time().$logo;
			//Se comprueba si el logo a cargar es correcto observando su extensión y tamaño
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
					$nuevo_ancho = 550;
					$nuevo_alto = 370;
					//Redimensionar
					$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
					//echo $tipo;die;
					if ($tipo == 'image/png' or $tipo == 'image/PNG') {
						$imagen = imagecreatefrompng($nueva);
					}else{
						$imagen = imagecreatefromjpeg($nueva);
					}
					imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
					// Sobreescribimos la imagen original con la reescalada 
					imagejpeg($imagen_p, $nueva);
					//Actualizo el tamaño al que tiene la imagen reescalada 
					$tamano = filesize($nueva);
					//echo $nueva;die;
					$temp = $nueva;
					///----------------FIN REDIMENSIONA IMAGEN--------------

				if (move_uploaded_file($temp, '../img/colaboradores/'.$logo)) {
					$concatena = ',logo = "'.$logo.'"'; //Esta variable se utiliza para que si el usuario no cambie la imagen, no se interte ni modifique anda en la base de datos
					//echo $concatena;
					//Cambiamos los permisos del logo a 777 para poder modificarlo posteriormente
					//  chmod('../img/colaboradores/'.$logo, 0777);
					//Mostramos el mensaje de que se ha subido co éxito
					//  $errores .= '<li>Se ha subido correctamente la imagen.</li>';
					//Mostramos la imagen subida
					//  echo '<p><img src="../img/colaboradores/'.$logo.'"></p>';
			
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

			$statement = $conexion->prepare('UPDATE colaboradores SET razonSocial = :razonSocial, 
																	fechaAlta = :fechaAlta, 
																	fechaBaja = :fechaBaja, 
																	sitioWeb = :sitioWeb,
																	destacado = :destacado  
																	'.$concatena.'
																	WHERE id = :id');
			//echo $errores;
			$statement->execute(array(
				':razonSocial' => $razonSocial,
				':fechaAlta' => $fechaAlta,
				':fechaBaja' => $fechaBaja,
				':sitioWeb' => $sitioWeb,
				':destacado' => $destacado,
				':id' => $id
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		if ($statement) {
			$mensaje = 'o';
		}
		header("Location: " . RUTA . 'admin/editarColaborador.php?id='.$id.'&e='.$mensaje); //volvemos al editarUsuario 
	}else {
		header("Location: " . RUTA . 'admin/editarColaborador.php?id='.$id.'&errores='.$errores); //volvemos al editarUsuario 
	}//fin if errores vacia o sea que todo esta correcto
} else { //sino  viene request post
			$id_colaborador = id_colaborador($_GET['id']);

			//si el usuario no esta seteado mandamod a listado de usuarios
			if (empty($id_colaborador)) {
				header('Location: ' . RUTA . 'admin/colaboradores.php');
			}

			// Obtenemos el usuario por id
			$colaborador = obtener_colaborador_por_id($conexion, $id_colaborador);

			// Si no hay contacto en el ID entonces redirigimos.
			if (!$colaborador) {
				header('Location: ' . RUTA . 'admin/index.php');
			}
			
			$colaborador = $colaborador[0];
			//ECHO '<PRE>';
			//print_R($colaborador);
}//fin request method post


require 'views/editarColaborador.view.php';

?>