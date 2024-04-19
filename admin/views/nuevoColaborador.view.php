<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN COLABORADOR Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeIngresadoColaborador();";
	  echo "</script>";
	}
  }

?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Nuevo Colaborador</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="nuevoColaborador" class="formulario"  method="POST" enctype="multipart/form-data">
				<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
					<label for="razonSocial">Razón Social</label><br>
						<input type="text" class="frmEditUser" name="razonSocial" value="" required><br>
					<label for="sitioWeb">Sitio Web</label><br>
						<input type="url" class="frmEditUser" name="sitioWeb" value="" required><br>
					<label for="fechaAlta">Fecha Alta</label><br>
						<input type="date" class="frmEditUser" name="fechaAlta" value="<?php $hoy=date("Y-m-d"); echo $hoy;?>"  min=<?php $hoy=date("Y-m-d"); echo $hoy;?>  required><br>
					<label for="fechaBaja">Fecha Baja</label><br>
						<input type="date" class="frmEditUser" name="fechaBaja" value="" min=<?php $hoy=date("Y-m-d"); echo $hoy;?> required><br><br>
					<label for="destacado">¿ Destacar Colaborador ?</label><br><br>
						<input type="radio" name="destacado" id="" value="1" class="formulario" checked> NO
						<input type="radio" name="destacado" id="" value="0" class="formulario"> SI<br><br>

						<label for="logo">Suba Imagen Rectangular de 550px * 370px</label>
					<!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
					<input type='file' class="frmEditUser" name='logo' required><br><br>
					
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
