<?php 
session_start();
require 'config.php';
require '../functions.php';
require 'views/header.php'; 

//print_r($_SESSION['usuario']);
$conexion = conexion($bd_config);
// Obtenemos los usuarios
$usuarios = obtener_usuarios($admin_config['usuario_por_pagina'], $conexion);
//echo '<pre>';
//print_r($usuarios);

//-------------SI ELIMINA UN USUARIO Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
  $mensaje = $_GET['e'];
  if ($mensaje==='o') {
    echo "<script>";
      echo "mensajeElimina();";
    echo "</script>";
  }

  if ($mensaje==='e') {
    echo "<script>";
      echo "mensajeIngresado();";
    echo "</script>";
  }
}

?>

<div class="contenedor-menu">

	<a href="nuevoUsuario.php" class="btn">Nuevo Usuario</a>
	<!-- <a href="cerrar.php" class="btn">Cerrar Sesion</a>-->
	<h2 class="titulo">Listado de Usuarios</h2>
	<section class="post">
	<table class="tablaUsuarios">
        <tr>
          <th scope="col">N&ordm;</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellido</th>
          <th scope="col">Usuario</th>
          <th scope="col">Nivel</th>
          <th scope="col">E-mail</th>
          <th scope="col">Teléfono</th>
          <th width="100" scope="col">Acción</th>
        </tr>

	<?php 
  $i = 1;
  foreach($usuarios as $usuario): ?>
		<tr>
              <th scope="col"><?php echo $usuario['id'];?></th>
              <th scope="col"><?php echo $usuario['nombre'];?></th>
              <th scope="col"><?php echo $usuario['apellido'];?></th>
              <th scope="col"><?php echo $usuario['usuario'];?></th>
              <th scope="col"><?php echo $usuario['niveles_id'];?></th>
              <th scope="col"><?php echo $usuario['email'];?></th>
              <th scope="col"><?php echo $usuario['telefono'];?></th>
              <th width="100" scope="col" class="tableCol">
                <a href='editarUsuario.php?id=<?php echo $usuario['id']?>'><img src="../img/editar.png" class="imgTabla"></a>
              <?php
                //------------SI VIENE SESSIONE NIVEL ROOT MUESTRA EL BOTON ELIMINAR-------
                if($_SESSION['usuario']['nivel']=='R'){?>
                       <a onclick="return confirm('Seguro desea eliminar el USUARIO?');" href="borrarUsuario.php?id=<?php echo $usuario['id']?>&p=<?php echo pagina_actual();?>"><img src="../img/borrar.png" class="imgTabla"></a>
              <?php } ?>
              </th>
            </tr>
	
			<!--<section class="post">
		<article>
			<h2 class="titulo"><?php echo $usuario['id'] . ' ------ ' . $usuario['nombre']. ' ' . $usuario['apellido']. ' / ' . $usuario['email']. ' / ' . $usuario['telefono']; ?></h2>
			<a href="editar.php?id=<?php echo $usuario['id']; ?>">Editar</a>
			<a href="../single.php?id=<?php echo $usuario['id']; ?>">Ver</a>
			<a href="borrar.php?id=<?php echo $usuario['id']; ?>">Borrar</a>
		</article>-->
	</section>
	<?php 
  $i++;
  endforeach; ?>
	</table>
</div>

<?php require 'paginacion_usuarios.php'; ?>
<?php require 'views/footer.php'; ?>
</body>
</html>
