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

// Comprobamos que exista un ID, sino viene id redireccionamos
if (!$id) {
	header('Location:' . RUTA . 'admin');
}

//eliminamos con update para borrado logico 
$statement = $conexion->prepare('UPDATE colaboradores SET logo = "" WHERE id = :id');
$statement->execute(array('id' => $id));

if ($statement) {
	$logo = limpiarDatos($_REQUEST['logo']); //asigamos a foto el nombre de la imagen que viene por url
	//echo $logo;die;
	unlink('../img/colaboradores/'.$logo);//borramos la imagen de la carpeta
}

//echo pagina_actual();die;
//require 'paginacion_contactos.php';
header('Location: ' . RUTA . 'admin/editarColaborador.php?id='.$id);

?>