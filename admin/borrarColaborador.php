<?php session_start();

require 'config.php';
require '../functions.php';

// Comprobamos si la session esta iniciada, sino, redirigimos.
comprobarSession();

// 1.- Conectamos a la base de datos
$conexion = conexion($bd_config);
if(!$conexion){
	header('Location: ../error.php');
}

$id = limpiarDatos($_GET['id']);
$logo = limpiarDatos($_GET['logo']);

// Comprobamos que exista un ID, sino viene id redireccionamos
if (!$id) {
	header('Location:' . RUTA . 'admin');
}

//eliminamos con update para borrado logico 
$statement = $conexion->prepare('UPDATE colaboradores SET logo = "", borrado = 1 WHERE id = :id');
$statement->execute(array('id' => $id));

//comprobamos que venga una imagen con el colaborador
if (!empty($logo) ) {
	//echo $logo;die;
	unlink('../img/colaboradores/'.$logo);//borramos la imagen de la carpeta
}

if ($statement) {
	$mensaje = 'o';
}
//echo pagina_actual();die;
//require 'paginacion_contactos.php';
header('Location: ' . RUTA . 'admin/colaboradores.php?p='.pagina_actual().'&e='.$mensaje);

?>