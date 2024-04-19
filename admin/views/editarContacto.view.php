<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN contacto Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeIngresadoActualiza();";
	  echo "</script>";
	}
  }
?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Editar Contacto</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="editarContacto" class="formulario"  method="POST">
				<?php  	if (isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
						<input type="hidden" name="id" value="<?php echo $contacto['id']; ?>">
						<input type="hidden" name="emailControl" value="<?php echo $contacto['email']; ?>">
						<input type="hidden" name="telControl" value="<?php echo $contacto['telefono']; ?>">
					<label for="nombre">Nombre</label><br>
						<input type="text" class="frmEditUser" name="nombre" value="<?php echo $contacto['nombre'] ?>" required><br>
					<label for="apellido">Apellido</label><br>
						<input type="text" class="frmEditUser" name="apellido" value="<?php echo $contacto['apellido'] ?>" required><br>
					<label for="email">E-mail</label><br>
						<input type="email" class="frmEditUser" name="email" value="<?php echo $contacto['email'] ?>" required><br>
					<label for="telefono">Teléfono</label><br>
						<input type="text" class="frmEditUser" name="telefono" value="<?php echo $contacto['telefono'] ?>" required><br>
					<label for="mensaje">Último Mensaje </label><br>
						<textarea name="mensaje" class="frmEditUser" cols="30" rows="10"><?php echo $contacto['mensaje'] ?></textarea>
	
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
