<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN USUARIO Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeActualiza();";
	  echo "</script>";
	}
  }
?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Editar USUARIO</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="editarUsuario" class="formulario"  method="POST">
				<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
						<input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
						<input type="hidden" name="usuarioControl" value="<?php echo $usuario['usuario']; ?>">
						<input type="hidden" name="emailControl" value="<?php echo $usuario['email']; ?>">
					<label for="Nivel">Nivel Usuario</label><br>
						<select name="nivel" id="nivel">
						<?php 
						//llamamos a la funciones obtener_nivles para llenar el select 
						$niveles = obtener_niveles($conexion);
						
						foreach ($niveles as $nivel) {
							$sel= '';
							if ($nivel['id']== $usuario['niveles_id']) {
								$sel = 'selected="selected"';
							} ?>
							<option value="<?php echo $nivel['id'];?>" <?php echo $sel;?>>
							<?php echo $nivel['nivel'] ;?>
							 </option>
						<?php  } ?>
						</select><br>
						<label for="usuario">Usuario</label><br>
						<input type="text" class="frmEditUser" name="usuario" value="<?php echo $usuario['usuario']; ?>"><br>
					<label for="pass">PassWord</label><br>
						<input type="password" class="frmEditUser" name="password" value="<?php //echo $usuario['pass'] ?>"><br>
					<label for="pass">Reingrese PassWord</label><br>
						<input type="password" class="frmEditUser" name="password2" value="<?php //echo $usuario['pass'] ?>"><br>
					<label for="nombre">Nombre</label><br>
						<input type="text" class="frmEditUser" name="nombre" value="<?php echo $usuario['nombre'] ?>" required><br>
					<label for="apellido">Apellido</label><br>
						<input type="text" class="frmEditUser" name="apellido" value="<?php echo $usuario['apellido'] ?>" required><br>
					<label for="email">E-mail</label><br>
						<input type="email" class="frmEditUser" name="email" value="<?php echo $usuario['email'] ?>" required><br>
					<label for="telefono">Teléfono</label><br>
						<input type="text" class="frmEditUser" name="telefono" value="<?php echo $usuario['telefono'] ?>" required><br>
						
	
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
