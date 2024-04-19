
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="../admin/js/functions.js"></script>
	<link rel="stylesheet" href="css/estilos.css">
	<link rel="shortcut icon" href="logo.jpeg" type="image/x-icon">

    <title>ESCBA</title>
</head>
<body>

	<div class="contenedor-menu">
		<div class="post">
		<h1 class="titulo">Subir Imagen</h1>
			<center>
				<form class="formulario" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">

					<label for="imagen">Seleciona Imagen</label><br><br>
					<input type="file" name="imagen" id="imagen" required><br><br><br><br>

					<?php //if (isset($errores)): ?>
						<p class="error"><?php //echo $errores; ?></p>
					<?php// endif; ?>
					<?php  	if ( isset($_GET['errores']) ) {?>
							<br>
							<div class="error">
								<ul>
									<?php 	echo $_GET['errores'];?>
								</ul>
							</div>
						<?php } ?>
					<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">

					<input class="btn" type="submit" value="Subir Imagen">
					<!-- <a href="editarNoticia.php?id=<?php echo $_GET['id']; ?>" class="btn">Volver al la Noticia</a> -->

				</form>
			</center>
		</div>
	</div>

	<?php require 'footer.php'; ?>
</body>
</html>