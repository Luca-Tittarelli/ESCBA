<?php

# Funcion para conectarnos a la base de datos.
# Return: la conexion o false si hubo un problema.
function conexion($bd_config){
	try {
	$conexion = new PDO('mysql:host=localhost;dbname='.$bd_config['basedatos'], $bd_config['usuario'], $bd_config['pass']);
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $conexion;

	} catch (PDOException $e) {
		return false;		
	}
}

# Funcion para limpiar y convertir datos como espacios en blanco, barras y caracteres especiales en entidades HTML.
# Return: los datos limpios y convertidos en entidades HTML.
function limpiarDatos($datos){
	// Eliminamos los espacios en blanco al inicio y final de la cadena
	$datos = trim($datos);

	// Quitamos las barras / escapandolas con comillas
	$datos = stripslashes($datos);

	// Convertimos caracteres especiales en entidades HTML (&, "", '', <, >)
	$datos = htmlspecialchars($datos);
	return $datos;
}




# Funcion para obtener la pagina actual
# Return: El numero de la pagina si esta seteado, sino entonces retorna 1.
function pagina_actual(){
	return isset($_GET['p']) ? (int)$_GET['p']: 1; 
}


//-------------------INICIO FUNCIONES PARA USUARIOS--------------------------------

# Funcion para obtener los USUARIOS determinando cuantos queremos traer por pagina.
# Return: Los USUARIOS dependiendo de la pagina que estemos y cuantos USUARIOS por pagina establecimos.
function obtener_usuarios($usuario_por_pagina, $conexion){
	//1.- Obtenemos la pagina actual
	// $pagina_actual = isset($_GET['p']) ? (int)$_GET['p']: 1;
	// Para reutilizar el codigo creamos una funcion que nos dice la pagina actual.

	//2.- Determinamos desde que post se mostrara en pantalla
	$inicio = (pagina_actual() > 1) ? (pagina_actual() * $usuario_por_pagina - $usuario_por_pagina) : 0;

	//3.- Preparamos nuestra consulta trayendo la informacion e indicandole desde donde y cuantas filas.
	// Ademas le pedimos que nos cuente cuantas filas tenemos.
	//$sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT {$inicio}, {$usuario_por_pagina}");
	$sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE borrado = 0 LIMIT {$inicio}, {$usuario_por_pagina}");

	$sentencia->execute();
	return $sentencia->fetchAll();
}

# Funcion para calcular el numero de paginas que tendra la paginacion.
# Return: El numero de paginas
function numero_paginas($usuario_por_pagina, $conexion){
	//4.- Calculamos el numero de filas / articulos que nos devuelve nuestra consulta
	$total_post = $conexion->prepare('SELECT COUNT(id) as total FROM usuarios WHERE borrado = 0');
	$total_post->execute();
	$total_post = $total_post->fetch()['total'];

	//5. Calculamos el numero de paginas que habra en la paginacion
	$numero_paginas = ceil($total_post / $usuario_por_pagina);
	return $numero_paginas;
}

# Funcion para obtener un usuario por ID
# Return: El usuario, o false si no se encontro ningun usuario con ese ID.
function obtener_usuario_por_id($conexion, $id){
	$resultado = $conexion->query("SELECT * FROM usuarios WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}


function id_usuario($id){
	return (int)limpiarDatos($id);
}

//----------------------FIN FUNCIONES  USUARIOS ------------------------


//funcion para obtener NIVEKES DE LA DB---------------------
function obtener_niveles($conexion){
	$resultado = $conexion->query("SELECT * FROM niveles");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}

//-------FIN FUNCION OBTENER NIVELES-----


//-----------------------INICIO FUNCIONES PARA OBTENER CONTACTOS------------------------

# Funcion para obtener los USUARIOS determinando cuantos queremos traer por pagina.
# Return: Los USUARIOS dependiendo de la pagina que estemos y cuantos USUARIOS por pagina establecimos.
function obtener_contactos($usuario_por_pagina, $conexion){
	//1.- Obtenemos la pagina actual
	// $pagina_actual = isset($_GET['p']) ? (int)$_GET['p']: 1;
	// Para reutilizar el codigo creamos una funcion que nos dice la pagina actual.

	//2.- Determinamos desde que post se mostrara en pantalla
	$inicio = (pagina_actual() > 1) ? (pagina_actual() * $usuario_por_pagina - $usuario_por_pagina) : 0;

	//3.- Preparamos nuestra consulta trayendo la informacion e indicandole desde donde y cuantas filas.
	// Ademas le pedimos que nos cuente cuantas filas tenemos.
	//$sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT {$inicio}, {$usuario_por_pagina}");
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM contactos WHERE borrado = 0 ORDER BY fecha DESC LIMIT {$inicio}, {$usuario_por_pagina}");

	$sentencia->execute();
	return $sentencia->fetchAll();
}

# Funcion para calcular el numero de paginas que tendra la paginacion.
# Return: El numero de paginas
function numero_paginasContactos($usuario_por_pagina, $conexion){
	//4.- Calculamos el numero de filas / articulos que nos devuelve nuestra consulta
	$total_post = $conexion->prepare('SELECT COUNT(id) as total FROM contactos WHERE borrado = 0');
	$total_post->execute();
	$total_post = $total_post->fetch()['total'];

	//5. Calculamos el numero de paginas que habra en la paginacion
	$numero_paginas = ceil($total_post / $usuario_por_pagina);
	return $numero_paginas;
}

# Funcion para obtener un usuario por ID
# Return: El usuario, o false si no se encontro ningun usuario con ese ID.
function obtener_contacto_por_id($conexion, $id){
	$resultado = $conexion->query("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM contactos WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}


function id_contacto($id){
	return (int)limpiarDatos($id);
}


//----------------------FIN FUNCIONES PARA CONTACTOS---------------------------------


//-----------------------INICIO FUNCIONES PARA OBTENER COLABORADORES------------------------

# Funcion para obtener los USUARIOS determinando cuantos queremos traer por pagina.
# Return: Los USUARIOS dependiendo de la pagina que estemos y cuantos USUARIOS por pagina establecimos.
function obtener_colaboradores($usuario_por_pagina, $conexion){
	//1.- Obtenemos la pagina actual
	// $pagina_actual = isset($_GET['p']) ? (int)$_GET['p']: 1;
	// Para reutilizar el codigo creamos una funcion que nos dice la pagina actual.

	//2.- Determinamos desde que post se mostrara en pantalla
	$inicio = (pagina_actual() > 1) ? (pagina_actual() * $usuario_por_pagina - $usuario_por_pagina) : 0;

	//3.- Preparamos nuestra consulta trayendo la informacion e indicandole desde donde y cuantas filas.
	// Ademas le pedimos que nos cuente cuantas filas tenemos.
	//$sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT {$inicio}, {$usuario_por_pagina}");
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fechaAlta, '%d-%m-%Y') as fechaAlta, DATE_FORMAT(fechaBaja, '%d-%m-%Y') as fechaBaja  FROM colaboradores WHERE borrado = 0 ORDER BY destacado ASC, fechaBaja ASC LIMIT {$inicio}, {$usuario_por_pagina}");

	$sentencia->execute();
	return $sentencia->fetchAll();
}

# Funcion para calcular el numero de paginas que tendra la paginacion.
# Return: El numero de paginas
function numero_paginasColaboradores($usuario_por_pagina, $conexion){
	//4.- Calculamos el numero de filas / articulos que nos devuelve nuestra consulta
	$total_post = $conexion->prepare('SELECT COUNT(id) as total FROM colaboradores WHERE borrado = 0');
	$total_post->execute();
	$total_post = $total_post->fetch()['total'];

	//5. Calculamos el numero de paginas que habra en la paginacion
	$numero_paginas = ceil($total_post / $usuario_por_pagina);
	return $numero_paginas;
}

# Funcion para obtener un usuario por ID
# Return: El usuario, o false si no se encontro ningun usuario con ese ID.
function obtener_colaborador_por_id($conexion, $id){
	$resultado = $conexion->query("SELECT *, DATE_FORMAT(fechaAlta, '%d-%m-%Y') as fechaAlta, DATE_FORMAT(fechaBaja, '%d-%m-%Y') as fechaBaja  FROM colaboradores WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}


function id_colaborador($id){
	return (int)limpiarDatos($id);
}


//----------------------FIN FUNCIONES PARA COLABORADORES---------------------------------

//-----------------------INICIO FUNCIONES PARA OBTENER NOTICIAS------------------------

# Funcion para obtener los USUARIOS determinando cuantos queremos traer por pagina.
# Return: Los USUARIOS dependiendo de la pagina que estemos y cuantos USUARIOS por pagina establecimos.
function obtener_noticias($usuario_por_pagina, $conexion){
	//1.- Obtenemos la pagina actual
	// $pagina_actual = isset($_GET['p']) ? (int)$_GET['p']: 1;
	// Para reutilizar el codigo creamos una funcion que nos dice la pagina actual.

	//2.- Determinamos desde que post se mostrara en pantalla
	$inicio = (pagina_actual() > 1) ? (pagina_actual() * $usuario_por_pagina - $usuario_por_pagina) : 0;

	//3.- Preparamos nuestra consulta trayendo la informacion e indicandole desde donde y cuantas filas.
	// Ademas le pedimos que nos cuente cuantas filas tenemos.
	//$sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT {$inicio}, {$usuario_por_pagina}");
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM noticias WHERE borrado = 0 ORDER BY orden ASC, id ASC, fecha DESC LIMIT {$inicio}, {$usuario_por_pagina}");

	$sentencia->execute();
	return $sentencia->fetchAll();
}

# Funcion para calcular el numero de paginas que tendra la paginacion.
# Return: El numero de paginas
function numero_paginasNoticias($usuario_por_pagina, $conexion){
	//4.- Calculamos el numero de filas / articulos que nos devuelve nuestra consulta
	$total_post = $conexion->prepare('SELECT COUNT(id) as total FROM noticias WHERE borrado = 0');
	$total_post->execute();
	$total_post = $total_post->fetch()['total'];

	//5. Calculamos el numero de paginas que habra en la paginacion
	$numero_paginas = ceil($total_post / $usuario_por_pagina);
	return $numero_paginas;
}

# Funcion para obtener un usuario por ID
# Return: El usuario, o false si no se encontro ningun usuario con ese ID.
function obtener_noticia_por_id($conexion, $id){
	$resultado = $conexion->query("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM noticias WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}


function id_noticia($id){
	return (int)limpiarDatos($id);
}

//----------------------FIN FUNCIONES PARA NOTICIAS---------------------------------

//---------------------------FUNCIONES IMAGENES PARA LA GALERIA DE LAS NOTICIAS-------------------------
function obtener_imagenes_por_id_noticias($conexion, $id_noticia){
	$resultado = $conexion->query("SELECT * FROM imagenes WHERE noticias_id = $id_noticia AND borrado = 0");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}

function obtener_imagen_por_id($conexion, $id){
	$resultado = $conexion->query("SELECT * FROM imagenes WHERE id = $id LIMIT 1");
	$resultado = $resultado->fetchAll();
	return ($resultado) ? $resultado : false;
}


function id_imagen($id){
	return (int)limpiarDatos($id);
}

//---------------------------FIN FUNCIONES IMAGENES PARA LA GALERIA DE LAS NOTICIAS---------------------




//-------------------------FUNCION PARA CONVERTIR FECHA---------------------------


function converToLatinDate($var) {
    if ($var == "") $var = "0000-00-00"; else {
    $var = date("Ymd", strtotime($var));
    }  
  return($var); 
 }
 
  function converToLatinDateString($var) {
    if ($var == "") $var = ""; else {    
    $var = date("d-m-Y", strtotime($var));
    }  
  return($var); 
 }

   function converToEnglishDate($var) {
    if ($var == "") $var = ""; else {    
    $var = date("Y-m-d", strtotime($var));
    }  
  return($var); 
 }
//-------------------------FIN FUNCION PARA CONVERTIR FECHA---------------------------


//----------------------INICIO FUNCION PARA COMPROBAR SI EXISTE SESSION------------------
# Funcion para comprobar la session del admins
function comprobarSession(){
	// Comprobamos si la session NO esta iniciada
	if (!isset($_SESSION['usuario'])) {
		header('Location: index.php');
		die();
	}
}
//----------------------FIN FUNCION PARA COMPROBAR SI EXISTE SESSION------------------


///////////----------------FIN FUNCIONES BACKEND-/////////////////////////////---------------------








//--/////////////////////////////////--------------INICION FUNCIONES FRONT END////////////////-------------------------



//-----------------------INICIO FUNCIONES PARA OBTENER COLABORADORES------------------------

# Funcion para obtener los USUARIOS determinando cuantos queremos traer por pagina.
# Return: Los USUARIOS dependiendo de la pagina que estemos y cuantos USUARIOS por pagina establecimos.
function obtener_colaboradores_front($colaboradores_por_pagina, $conexion){
	//1.- Obtenemos la pagina actual
	// $pagina_actual = isset($_GET['p']) ? (int)$_GET['p']: 1;
	// Para reutilizar el codigo creamos una funcion que nos dice la pagina actual.

	//2.- Determinamos desde que post se mostrara en pantalla
	$inicio = (pagina_actual() > 1) ? (pagina_actual() * $colaboradores_por_pagina - $colaboradores_por_pagina) : 0;

	//3.- Preparamos nuestra consulta trayendo la informacion e indicandole desde donde y cuantas filas.
	// Ademas le pedimos que nos cuente cuantas filas tenemos.
	//$sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT {$inicio}, {$usuario_por_pagina}");
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fechaAlta, '%d-%m-%Y') as fechaAlta, DATE_FORMAT(fechaBaja, '%d-%m-%Y') as fechaBaja  FROM colaboradores WHERE borrado = 0 ORDER BY destacado ASC, fechaBaja ASC, id ASC LIMIT {$inicio}, {$colaboradores_por_pagina}");

	$sentencia->execute();
	return $sentencia->fetchAll();
}

# Funcion para calcular el numero de paginas que tendra la paginacion.
# Return: El numero de paginas
function numero_paginasColaboradores_front($colaboradores_por_pagina, $conexion){
	//4.- Calculamos el numero de filas / articulos que nos devuelve nuestra consulta
	$total_post = $conexion->prepare('SELECT COUNT(id) as total FROM colaboradores WHERE borrado = 0 AND destacado = 0');
	$total_post->execute();
	$total_post = $total_post->fetch()['total'];

	//5. Calculamos el numero de paginas que habra en la paginacion
	$numero_paginas = ceil($total_post / $colaboradores_por_pagina);
	return $numero_paginas;
}

//----------------------FIN FUNCIONES PARA COLABORADORES---------------------------------

//-------------FUNCIONES NOTICIAS FRONT--------------------------
function obtener_noticias_front($conexion){
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM noticias WHERE borrado = 0 AND destacado = 0  ORDER BY  orden ASC, fecha DESC, id ASC LIMIT 4");

	$sentencia->execute();
	return $sentencia->fetchAll();
}



function noticias_front_segundaSec($conexion){
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM noticias WHERE borrado = 0 AND destacado = 0 ORDER BY destacado ASC, orden ASC, fecha DESC, id ASC LIMIT 4,4");

	$sentencia->execute();
	return $sentencia->fetchAll();
}


function obtener_noticias_anteriores($usuario_por_pagina, $conexion){
	//1.- Obtenemos la pagina actual
	// $pagina_actual = isset($_GET['p']) ? (int)$_GET['p']: 1;
	// Para reutilizar el codigo creamos una funcion que nos dice la pagina actual.

	//2.- Determinamos desde que post se mostrara en pantalla
	$inicio = (pagina_actual() > 1) ? (pagina_actual() * $usuario_por_pagina - $usuario_por_pagina) : 0;
	$inicio = $inicio + 8;
	//3.- Preparamos nuestra consulta trayendo la informacion e indicandole desde donde y cuantas filas.
	// Ademas le pedimos que nos cuente cuantas filas tenemos.
	//$sentencia = $conexion->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM articulos LIMIT {$inicio}, {$usuario_por_pagina}");
	$sentencia = $conexion->prepare("SELECT *, DATE_FORMAT(fecha, '%d-%m-%Y') as fecha FROM noticias WHERE borrado = 0  ORDER BY orden ASC, id ASC, fecha DESC LIMIT {$inicio}, {$usuario_por_pagina}");

	$sentencia->execute();
	return $sentencia->fetchAll();
}

# Return: El numero de paginas
function numero_paginasNoticias_anteriores($usuario_por_pagina, $conexion){
	//4.- Calculamos el numero de filas / articulos que nos devuelve nuestra consulta
	$total_post = $conexion->prepare('SELECT COUNT(id) - 8 as total FROM noticias WHERE borrado = 0');
	$total_post->execute();
	$total_post = $total_post->fetch()['total'];

	//5. Calculamos el numero de paginas que habra en la paginacion
	$numero_paginas = ceil($total_post / $usuario_por_pagina);
	return $numero_paginas;
}
//---------FN FUNCIONES NOTICIAS FRONT---------------------------

////////////////////FIM FUNCIONES FRONT ////////////////////////////////////////////////////



?>