<?php 
session_start();
require 'config.php';
require '../functions.php';


//print_r($_SESSION['usuario']);
// 1.- Conectamos a la base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES)) {
	
	$errores = '';

	$id_noticia = limpiarDatos($_POST['id']);
	//print_r($_POST);die;
	// La funcion getimagesize nos retorna un arreglo de propiedades de la imagen y si no es una imagen retorna false y un error notice.
	// Podemos utilizar el @ antes de la funcion para omitir el notice si no es una imagen.
	$check = @getimagesize($_FILES['imagen']['tmp_name']);
	//print_R($check);die;
	if ($check !== false){
		$imagen = $_FILES['imagen']['name'];

		
		if (isset($imagen) && $imagen != "") {
			
			//Obtenemos algunos datos necesarios sobre el imagen
			$tipo = $_FILES['imagen']['type'];
			$tamano = $_FILES['imagen']['size'];
			$temp = $_FILES['imagen']['tmp_name'];
			//echo $tipo.'-->'.$tamano;die;
			$imagen = time().$imagen;
			//Se comprueba si el imagen a cargar es correcto observando su extensión y tamaño
			if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 3145728))) {
				$errores.= '<li>Error. La extensión o el tamaño de los archivos no es correcta - Se permiten archivos  .jpg, .png. y de 3 Mb como máximo.</li>';
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
					//$concatena = ',imagen = "'.$imagen.'"'; //Esta variable se utiliza para que si el usuario no cambie la imagen, no se interte ni modifique anda en la base de datos
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

		$statement = $conexion->prepare('UPDATE noticias SET imagen = :imagen WHERE id = :id_noticia');
		$statement->execute(array(
					':id_noticia' => $id_noticia,
					':imagen' => $imagen));

		if ($statement) {
			$mensaje = 'ep';
		}

		header('Location: editarNoticia.php?id='.$id_noticia.'&e='.$mensaje);
	} else {
		$errores.= "El archivo no es una imagen o el archivo es muy pesado";
		header("Location: " . RUTA . 'admin/editarNoticia.php?id='.$id_noticia.'&errores='.$errores); //volvemos al editarUsuario 

	}
}

require 'views/subirImagenesNoticiaEdita.view.php';

?>