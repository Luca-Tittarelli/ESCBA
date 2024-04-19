<?php 
session_start();
require 'config.php';
require '../functions.php';
require 'views/header.php'; 

//print_r($_SESSION['usuario']);
$conexion = conexion($bd_config);
// Obtenemos los usuarios
$contactos = obtener_contactos($admin_config['usuario_por_pagina'], $conexion);
//echo '<pre>';
//print_r($usuarios);

//-------------SI ELIMINA UN USUARIO Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
  $mensaje = $_GET['e'];
  if ($mensaje==='o') {
    echo "<script>";
      echo "mensajeEliminaContacto();";
    echo "</script>";
  }

  if ($mensaje==='e') {
    echo "<script>";
      echo "mensajeIngresadoContacto();";
    echo "</script>";
  }
}

?>

<div class="contenedor-menu">

	<a href="nuevoContacto.php" class="btn">Nuevo Contacto</a>
	<!-- <a href="cerrar.php" class="btn">Cerrar Sesion</a>-->
	<h2 class="titulo">Listado de Contactos</h2>
	<section class="post">
	<table class="tablaContactos">
        <tr>
          <th scope="col">N&ordm;</th>
          <th scope="col">Fecha</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">E-mail</th>
          <th scope="col">Teléfono</th>
          <th width="100" scope="col">Acción</th>
        </tr>

	<?php 
  $i = 1;
  foreach($contactos as $contacto): ?>
		<tr>
              <th scope="col"><?php echo $i;?></th>
              <th scope="col"><?php echo $contacto['fecha'];?></th>
              <th scope="col"><?php echo $contacto['nombre'];?></th>
              <th scope="col"><?php echo $contacto['apellido'];?></th>
              <th scope="col"><?php echo $contacto['email'];?></th>
              <th scope="col"><?php echo $contacto['telefono'];?></th>
              <th  scope="col" class="tableCol">
              <a href='editarContacto.php?id=<?php echo $contacto['id']?>'><img src="../img/editar.png" class="imgTabla"></a>
              <a onclick="return confirm('Seguro desea eliminar el Contacto?');" href="borrarContacto.php?id=<?php echo $contacto['id']?>&p=<?php echo pagina_actual();?>"><img src="../img/borrar.png" class="imgTabla"></a>
          
              </th>
            </tr>
	
	</section>
	<?php 
  $i++;
  endforeach; ?>
	</table>
</div>

<?php require 'paginacion_contactos.php'; ?>
</html>
<?php require 'views/footer.php'; ?>
</body>
