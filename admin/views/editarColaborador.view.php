<?php require 'views/header.php';
$conexion = conexion($bd_config);

//-------------SI ELIMINA UN COLABORADOR Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
	$mensaje = $_GET['e'];
	if ($mensaje==='o') {
	  echo "<script>";
		echo "mensajeIngresadoActualizaCol();";
	  echo "</script>";
	}
  }


  $fechaAlta = $colaborador['fechaAlta'];

  $fechaAlta = converToLatinDate($fechaAlta);
  //echo "<br>".$fecha;
  $fechaAlta = converToLatinDateString($fechaAlta);
  //echo "<br>".$fecha;
  $fechaAlta = converToEnglishDate($fechaAlta);
  //echo "<br>".$fecha;

  $fechaBaja = $colaborador['fechaBaja'];

  $fechaBaja = converToLatinDate($fechaBaja);
  //echo "<br>".$fecha;
  $fechaBaja = converToLatinDateString($fechaBaja);
  //echo "<br>".$fecha;
  $fechaBaja = converToEnglishDate($fechaBaja);



?>

	<div class="contenedor-menu">
		<div class="post">
			<article>
				<h2 class="titulo">Editar Colaborador</h2>
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" name="editarColaborador" class="formulario"  method="POST" enctype="multipart/form-data">
				<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
						<input type="hidden" name="id" value="<?php echo $colaborador['id']; ?>">
						<input type="hidden" name="sitioWebControl" value="<?php echo $colaborador['sitioWeb']; ?>">
					<label for="razonSocial">Razón Social</label><br>
						<input type="text" class="frmEditUser" name="razonSocial" value="<?php echo $colaborador['razonSocial']; ?>" required><br>
					<label for="sitioWeb">Sitio Web</label><br>
						<input type="url" class="frmEditUser" name="sitioWeb" value="<?php echo $colaborador['sitioWeb']; ?>" required><br>
					<label for="fechaAlta">Fecha Alta</label><br>
						<input type="date" class="frmEditUser" name="fechaAlta" value="<?php echo $fechaAlta;?>"  required><br>
					<label for="fechaBaja">Fecha Baja</label><br>
						<input type="date" class="frmEditUser" name="fechaBaja" value="<?php echo $fechaBaja; ?>" min=<?php $hoy=date("Y-m-d"); echo $hoy;?> required><br><br>
					<label for="destacado">¿ Destacar Colaborador ?</label><br><br>
				<?php 
				
					if($colaborador['destacado'] == 1){
						echo '<input type="radio" name="destacado" id="" value="1" checked  class="formulario"> NO &nbsp;&nbsp;';
						echo '<input type="radio" name="destacado" id="" value="0" class="formulario"> SI &nbsp;&nbsp;<br><br>';
					}else{
						echo '<input type="radio" name="destacado" id="" value="1"   class="formulario"> NO &nbsp;&nbsp;';
						echo '<input type="radio" name="destacado" id="" value="0" checked class="formulario"> SI &nbsp;&nbsp;<br><br>';
					} ?>
					
					
						<?php if(!empty($colaborador['logo'])!=''){?>
						<img src="../img/colaboradores/<?php echo $colaborador['logo']; ?>" alt="" width="250px"><br>
						<a href="borrarImagenColaborador?id=<?php echo $colaborador['id'];?>&logo=<?php echo $colaborador['logo'];?>" onclick="return confirm('Seguro desea eliminar la imagen?');">
						<img border="0" src="../img/borrar.png" width="30px"/></a><br><br>
					<?php }else{ ?>
						<label for="logo">Suba Imagen Rectangular de 550px * 370px</label>
						<!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
						<input type='file' class="frmEditUser" name='logo' required><br><br>
					<?php } ?>
					<input type="submit" value="Guardar Datos" class="btn"  >
					<!-- Comprobamos si la variable errores esta seteada y no esta vacia, si es asi mostramos los errores -->
				
				</form>
			</article>
		</div>
	</div>
	<?php require 'footer.php'; ?>
</body>
</html>
