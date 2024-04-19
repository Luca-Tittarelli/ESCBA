<?php 
session_start();
require 'config.php';
require '../functions.php';
require 'views/header.php'; 

//print_r($_SESSION['usuario']);
$conexion = conexion($bd_config);
// Obtenemos los usuarios
$colaboradores = obtener_colaboradores($admin_config['usuario_por_pagina'], $conexion);
//echo '<pre>';
//print_r($usuarios);

//-------------SI ELIMINA UN USUARIO Y VUELVE AL PISTADO CON MENSAJE MOSTRAMOS SWEET ALERT----
if (isset($_GET['e'])) {
  $mensaje = $_GET['e'];
  if ($mensaje==='o') {
    echo "<script>";
      echo "mensajeEliminaColaborador();";
    echo "</script>";
  }

  if ($mensaje==='e') {
    echo "<script>";
      echo "mensajeIngresadoColaborador();";
    echo "</script>";
  }
}

?>

<div class="contenedor-menu">

	<a href="nuevoColaborador.php" class="btn">Nuevo Colaborador</a>
	<!-- <a href="cerrar.php" class="btn">Cerrar Sesion</a>-->
	<h2 class="titulo">Listado de Colaboradores</h2>
	<section class="post">
	<table class="tablaColaboradores">
        <tr>
          <th scope="col">N&ordm;</th>
          <th scope="col">Razón Social</th>
          <th scope="col">Sitio Web</th>
          <th scope="col">Fecha Alta</th>
          <th scope="col">Fecha Baja</th>
          <th width="100" scope="col">Acción</th>
        </tr>

	<?php 
  $i = 1;
  foreach($colaboradores as $colaborador):?>
		<tr>
              <th scope="col"><?php echo $i;?></th>
              <th scope="col"><?php echo $colaborador['razonSocial'];?></th>
              <th scope="col"><?php echo $colaborador['sitioWeb'];?></th>
              <th scope="col"><?php echo $colaborador['fechaAlta'];?></th>
              <th scope="col"><?php echo $colaborador['fechaBaja'];?></th>
              <th  scope="col" class="tableCol">
              <a href='editarColaborador.php?id=<?php echo $colaborador['id']?>'><img src="../img/editar.png" class="imgTabla"></a>
              <a onclick="return confirm('Seguro desea eliminar el Colaborador?');" href="borrarColaborador.php?id=<?php echo $colaborador['id']?>&logo=<?php echo $colaborador['logo'];?>&p=<?php echo pagina_actual();?>"><img src="../img/borrar.png" class="imgTabla"></a>

              </th>
            </tr>
	
	</section>
	<?php 
    $i++;
    endforeach; ?>
	</table>
</div>

<?php require 'paginacion_colaboradores.php'; ?>
</html>
<?php require 'views/footer.php'; ?>
</body>
