<?php

require 'admin/config.php';
require 'functions.php';



$conexion = conexion($bd_config);

if (!$conexion) {
	header('Location: error.php');
}

// Obtenemos los post
$colaboradores = obtener_colaboradores_front($admin_config['colaboradores_por_pagina'], $conexion);

/*
// Si no hay colaboradores entonces redirigimos
if(!$colaboradores){
	header('Location: error.php');
}
*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.jpeg" type="image/x-icon">
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
    <!--wow animaciones-->
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Colaboran con Nuestra Institución</title>
    <!--METAS-->
    <meta name="author" content="ESCBA" />
    <meta name="title" content="Colaboran con Nuestra Institucion" />
    <meta name="keywords" content="escuelas en leones, escuelas en cordoba, leones, cordoba, leones cordoba, intitucion en leones, instituciones, noticias de leones, noticias de hoy, noticias de cordoba, noticia escuelas, orientacion informatica, informatica, orientaciones comunicaciones, comunicaciones, orientacion economia, economia" />
    <meta name="description" content="Escuela de Leones, espacialidad informática, comunicaciones y economía,  brinda información sobre la institución, la ciudad y la región." />    
</head>
<!--Color del body 01508B no se usaporque no se leen las fuentes, cuando integremos CSS usaré e color que va-->
<body class="container-fluid">
    <?php require 'nav.php';?>
    <div class="container-fluid"><!--CONTEINER BOOTSTRAP-->
        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
        <?php if (!$colaboradores) {
                echo '<HR class="linea">';
                echo '<h1 class="colabH1">Aún no Tenemos Colaboradores en Nuestra Institución</h1>';
                echo '<HR class="linea">';
            }else{?>
                <h1 class="colabH1">Colaboran con Nuestra Institución</h1>
                <HR class="linea">
                <main>
                    <section  class="contenidoCol">    
                    <?php 
                        $hoy=date("d-m-Y");
                        foreach($colaboradores as $colaborador):?>  
                        <?php if ( $colaborador['logo'] != '') {
                            $logo = $colaborador['logo'];
                        }else{
                            $logo = 'colaboradorsBlanco';
                        }?> 
                        
                        <?php if ( $colaborador['fechaBaja'] >= $hoy) {?>
                            <div class="infoCol container-fluid">
                                <a href="<?php echo $colaborador['sitioWeb'];?>" target="_blank"><img class="imgCol" src="img/colaboradores/<?php echo $logo;?>" alt="Colaborador"></a>
                                <h1 class="colH1"><?php echo $colaborador['razonSocial'];?></h1>
                            </div>
                        <?php }?>  

                    	<?php endforeach; ?>
                    </section>
                </main>

            <?php  }?>
            </div> <!--CIERRE DIV ROW BOOTSTRAP-->
        </div><!--CIERRE DIV CONTAINER BOOTSTRAP-->
    <!-- Footer -->
    <?php require 'footer.php';?>     
<script src="libs/bootstrap/js/bootstrap.min.js"></script><!--BOOTSTRAP-->    
</body>
</html>