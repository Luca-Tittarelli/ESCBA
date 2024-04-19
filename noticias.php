<?php

require 'admin/config.php';
require 'functions.php';



$conexion = conexion($bd_config);

if (!$conexion) {
	header('Location: error.php');
}


$noticias = obtener_noticias_anteriores($admin_config['usuario_por_pagina'], $conexion);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Poppins:ital,wght@1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
    <!--BOOTSTRAP-->
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--Hojas de estilos-->
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="shortcut icon" href="img/logo.jpeg" type="image/x-icon">
    <!--wow animaciones-->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Noticias de la ESCBA y la región</title>
    <!--METAS-->
    <meta name="author" content="ESCBA" />
    <meta name="title" content="Ultimas noticias de la ESCBA y la region" />
    <meta name="keywords" content="escuelas en leones, escuelas en cordoba, leones, cordoba, leones cordoba, intitucion en leones, instituciones, noticias de leones, noticias de hoy, noticias de cordoba, noticia escuelas, orientacion informatica, informatica, orientaciones comunicaciones, comunicaciones, orientacion economia, economia" />
    <meta name="description" content="Escuela de Leones, espacialidad informática, comunicaciones y economía,  brinda información sobre la institución, la ciudad y la región." />    
</head>
<body class="container-fluid">
    <?php require 'nav.php';?>
    <div class="container-fluid"><!--CONTEINER BOOTSTRAP-->
    <?php if ($noticias) {?>
        <div class="row col-xs-12 col-sm-12 col-md-12 col-md-d-1 col-lg-12 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
            <!--SECCION GENERAL DE LISTADO DE NOTICIAS-->
            <main class="menuNoticias container-fluid">
                    <h1 class="noticiasH1">NOTICIAS ANTERIORES</h1>
                    <HR class="linea">
                        <section class="contenedor container-fluid">
                        <?php foreach($noticias as $noticia):?>
                            
                            <div class="contenedorHijo container-fluid">
                                <a class="enlaceNoticias" href="detalleNoticia.php?id=<?php echo $noticia['id'];?>"><h2 class="noticiasH2"><?php echo $noticia['titulo'];?></h2></a><br>
                                <a class="enlaceNoticias" href="detalleNoticia.php?id=<?php echo $noticia['id'];?>"><p class="noticiasP"><?php echo $noticia['intro'];?></p></a>
                            </div>
                                <div class="contenedorHijoImg container-fluid">
                                <a class="enlaceNoticias" href="detalleNoticia.php?id=<?php echo $noticia['id'];?>"><img class="noticiasImg" src="img/noticias/<?php echo ($noticia['imagen']=='') ?  "notiBlankImg.png": $noticia['imagen'];?>" alt="Título Noticia"></a>
                            </div>
                        <?php endforeach; ?>
                        <?php require 'paginacion_noticias.php'; ?>
                        </section>
                </main>
            </div> <!--CIERRE DIV ROW BOOTSTRAP-->
         <?php }?>
        </div><!--CIERRE DIV CONTAINER BOOTSTRAP-->    
    <!-- Footer -->
    <?php require 'footer.php';?> 
    <script src="libs/bootstrap/js/bootstrap.min.js"></script><!--BOOTSTRAP-->    
</body>
</html>