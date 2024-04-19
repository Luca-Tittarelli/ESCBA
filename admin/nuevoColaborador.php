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
	//$fechaAlta = $_POST['fechaAlta'];
	//$fechaAlta = converToLatinDate($fechaAlta);
	//echo "<br>".$fecha;
	//$fechaAlta = converToLatinDateString($fechaAlta);
	//echo "<br>".$fecha;
	//$fechaAlta = converToEnglishDate($fechaAlta);
	//echo "<br>".$fecha;
  
	$fechaBaja = $_POST['fechaBaja'];
  	$fechaBaja = converToLatinDate($fechaBaja);
	//echo "<br>".$fecha;
	$fechaBaja = converToLatinDateString($fechaBaja);
	//echo "<br>".$fecha;
	$fechaBaja = converToEnglishDate($fechaBaja);


	//$fechaAlta = NOW();
	$fechaBaja = date($fechaBaja.' H:i:s');
	// Limpiamos los datos para evitar que el usuario inyecte codigo.
	// Validamos que los datos hayan sido rellenados
	//$niveles_id = $_SESSION['usuario']['nivel'];
	$razonSocial = limpiarDatos($_POST['razonSocial']);
	$sitioWeb = filter_var(strtolower($_POST['sitioWeb']), FILTER_SANITIZE_STRING);
	$destacado = limpiarDatos($_POST['destacado']);


	//declaramos la variable errores para decirle al usuario si algo esta mal
	$errores = '';

	//echo $logo;die;
	// Comprobamos que ninguno de los campos este vacio.
	if (empty($fechaBaja) or empty($sitioWeb) or empty($razonSocial)) {
		$errores .= '<li>Por favor rellena todos los datos correctamente</li>';
	} else {

		// Comprobamos que el usuario no exista ya.
		//hacemos la consulta par ver si el usuario ya existe en la db.si esxiste le damos mensaje de error
		$statement = $conexion->prepare('SELECT * FROM colaboradores WHERE sitioWeb = :sitioWeb AND borrado = 0 LIMIT 1');
		//ejecutamo la consulta
		$statement->execute(array(
							':sitioWeb' => $sitioWeb
						));
			// El metodo fetch nos va a devolver el resultado o false en caso de que no haya resultado.
		$resultado = $statement->fetch();
	
		//var_dump($resultado);
		//VALIDAMOS QUE SE HAYA CAMBIADO EL USUARIO PARA NO DUPLICARLO EN LA DB

		//var_dump($resultado);
		// Si el sitioWeb que se envia es igual al de la DB entonces significa que ya existe el sitioWeb.
		
			//var_dump($resultado);
			// Si resultado es diferente a false entonces significa que ya existe el EMAIL.
			if ($resultado != false) {
				$errores .= '<li>El Sitio Web ya existe</li>';
			}
			// Hasheamos nuestra contraseña para protegerla un poco.
			# OJO: La seguridad es un tema muy complejo, aqui solo estamos haciendo un hash de la contraseña,
			# pero esto no asegura por completo la informacion encriptada.
		
	
	}//cierre ir si los campos tienen algun dato

	if ($errores == '') {
//----------CODIGO PARA INSERTAR imagen
	//Recogemos el logo enviado por el formulario
	$logo = $_FILES['logo']['name'];
	//Si el logo contiene algo y es diferente de vacio
	if (isset($logo) && $logo != "") {
		//Obtenemos algunos datos necesarios sobre el logo
		$tipo = $_FILES['logo']['type'];
		$tamano = $_FILES['logo']['size'];
		$temp = $_FILES['logo']['tmp_name'];
		//echo $tipo.'-->'.$tamano;
		$logo = time().$logo;
		//Se comprueba si el logo a cargar es correcto observando su extensión y tamaño
	if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 3145728))) {
		echo '<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
		- Se permiten archivos .jpg, .png. y de 3 Mb como máximo.</b></div>';
	}
	else {

			//--------------REDIMENSIONAMOS LA IMAGEN VER COMO QUEREMOS HACER, SE PUEDE ASIGANAR ALTO Y ANCHO FIJO PONIENDO LOS VALORES EN NUEVO ALTO Y NUEVO_ANCHO

			$nueva = $temp;
			$porcentaje = 0.5;
			list($ancho, $alto) = getimagesize($nueva);
			$nuevo_ancho = 550;
			$nuevo_alto = 370;
			//Redimensionar
			$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);

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
		
			//Si la imagen es correcta en tamaño y tipo
			//Se intenta subir al servidor
			if (move_uploaded_file($temp, '../img/colaboradores/'.$logo) and $errores == '') {
				//Cambiamos los permisos del logo a 777 para poder modificarlo posteriormente
				//  chmod('uploads/'.$logo, 0777);
				//Mostramos el mensaje de que se ha subido co éxito
				//  echo '<div><b>Se ha subido correctamente la imagen.</b></div>';
				//Mostramos la imagen subida
				//  echo '<p><img src="uploads/'.$logo.'"></p>';
			}else {
				//Si no se ha podido subir la imagen, mostramos un mensaje de error
				echo '<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
			}	
		}
	}
//----FIN CODIGO IMAGEN

			$statement = $conexion->prepare('INSERT INTO colaboradores (id, razonSocial, logo, sitioWeb, fechaAlta, fechaBaja, destacado, borrado)
														VALUES  (null, :razonSocial, :logo, :sitioWeb, NOW(), :fechaBaja, :destacado, 0)');
			//print_r($statement) ;die;
			$statement->execute(array(
				':razonSocial' => $razonSocial,
				':sitioWeb' => $sitioWeb,
				':logo' => $logo,
				':fechaBaja' => $fechaBaja,
				':destacado' => $destacado
			));
		//echo 'Hola Mundo'; //este mensaje es para detectar errores, si el codigo llego hasta aca, quiere decir que todo esta correcto
		//die;// Despues de registrar al usuario redirigimos para que inicie sesion.
		
		
		if ($statement) {
			$mensaje = 'e';
		}
		header("Location: " . RUTA . '/admin/colaboradores.php?e='.$mensaje); //volvemos al editarUsuario 
	}else{
		header("Location: " . RUTA . 'admin/nuevoColaborador.php?errores='.$errores); //volvemos al editarUsuario 

	}
		//fin if errores vacia o sea que todo esta correcto
} //-CIERRE IF METODO POST


require 'views/nuevoColaborador.view.php';

?>