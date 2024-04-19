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
    <title>Contacto - ESCBA</title>
    <!--METAS-->
    <meta name="author" content="ESCBA" />
    <meta name="title" content="Contacto - ESCBA" />
    <meta name="keywords" content="escuelas en leones, escuelas en cordoba, leones, cordoba, leones cordoba, intitucion en leones, instituciones, noticias de leones, noticias de hoy, noticias de cordoba, noticia escuelas, orientacion informatica, informatica, orientaciones comunicaciones, comunicaciones, orientacion economia, economia" />
    <meta name="description" content="Escuela de Leones, espacialidad informática, comunicaciones y economía,  brinda información sobre la institución, la ciudad y la región." />    
</head>
<body class="container-fluid">
    <?php require 'nav.php';?>
    <div class="container-fluid"><!--CONTEINER BOOTSTRAP-->
        <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
            <h1 class="conH1">Contacto</h1>
            <HR class="linea">
                <main>       
                    <section class="contGeneral">
                            <!--DIV FORMULARIO-->
                            <div class="formCont container-fluid">
                                <article id="contenidos" class="container-fluid"> 
                                <?php if (!empty($_GET['send']) && $_GET['send'] === 'ok') { ?>
                                    <div class="w-50 p-1 text-white">
                                        <h4>Su consulta se envió con éxito.<br>
                                            Nos comunicaremos a la brevedad. <br>
                                            Gracias.
                                        </h4>
                                        </div>
                                <?php } else { ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" class="form-group">
                                        <div class="w-50 p-1 text-white">
                                            <label for="nombre">Nombre:</label> 
                                                <input type="text" class="form-control form-control-sm." name="nombre" id="nombre" value="<?php  //if(!$enviado && isset($nombre)) echo $nombre  // si no se envio por errores mostramos el nombre?>" required/>
                                        </div>
                                        <div class="w-50 p-1 text-white">
                                            <label for="apellidp">Apellido:</label> 
                                                <input type="text" class="form-control form-control-sm." name="apellido" id="apellido" value="<?php // if(!$enviado && isset($apellido)) echo $apellido  // si no se envio por errores mostramos el apellido?>"  required/>
                                        </div>
                                        <div class="w-50 p-1 text-white">
                                            <label for="telefono">Teléfono:</label> 
                                            <input type="text" class="form-control form-control-sm." name="telefono" id="telefono" value="<?php  //if(!$enviado && isset($telefono)) echo $telefono  // si no se envio por errores mostramos el apellido?>"  required/>
                                        </div>
                                        <div class="w-50 p-1 text-white">    
                                            <label for="email">e-mail:</label> 
                                                <input type="email" class="form-control form-control-sm." name="email" id="email" required value="<?php  //if(!$enviado && isset($email)) echo $email  // si no se envio por errores mostramos el email?>"/>
                                        </div>
                                        <div class="w-50 p-1 text-white">
                                            <label for="comentario">Comentario:</label>
                                                <textarea name="mensajeTexto" id="mensajeTexto" class="form-control form-control-sm." cols="20" rows="5"required><?php  //if(!$enviado && isset($mensajeTexto)) echo $mensajeTexto  // si no se envio por errores mostramos el mensaje?></textarea>
                                        </div> 
                                                <!-- Preguntamos si hay errores y mostramos el div empty solo pregunta si vribale esta vacia al agregar ! niega si esta vacia o sea si tiene algo-->
                                            <?php  if(!empty($errores)):  ?>
                                                <div class="error">
                                                    <ul>
                                                        <?php  echo $errores;  ?>
                                                    </ul>
                                                </div>
                                            <!-- comprobamos si esta todo correcto, la varibale enviado la ponemos en tru y mostramos el div success-->
                                            <?php // elseif($enviado):  ?>
                                            <!--     <div class="success">
                                                    <ul>
                                                        <li>Mensaje Enviado Correctamente</lip>
                                                    </ul>
                                                </div>-->
                                            <?php  endif  ?>
                                            
                                        <div>
                                            <input type="submit" name="submit" class="btn btn-secondary" style="margin: 2% 0% 0% 0%;" value="Enviar Mensaje">
                                            <!-- <input type="reset" class="btn btn-secondary" style="margin: 2% 0% 0% 0%;" value="Borrar Datos"> -->
                                        </div>    
                                    </form>   
                                    <?php } ?>
                                </article>
                            </div>
                            <!--DIV MAPA-->
                            <div class="infoCont container-fluid">
                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
                                    <label class="labelMapa" for=""><u>Dirección</u></label><br>
                                    <label class="labelDatos" for="">Alte. Brown 551</label><br><br><br>
                                    <label class="labelMapa" for=""><u>Teléfono</u></label><br>
                                    <label class="labelDatos" for="">03472 483562</label><br><br><br>
                                    <label class="labelMapa" for=""><u>email:</u></label><br>
                                    <label class="labelDatos" for="">escba.escbaleones@gmail.com</label>
                                </div>
                            </div>
                            <div class="mapaCont container-fluid">
                                <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"> <!--DIV ROS BOOTSTRAP-->
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3358.995963348382!2d-62.305871085343234!3d-32.65955156474142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95cbd8649b6b434b%3A0x37c41b85248498a8!2sESCBA!5e0!3m2!1ses!2sar!4v1647102602956!5m2!1ses!2sar" width="400" height="340" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                </div>
                            </div>
                    </section>
                </main>
        </div> <!--CIERRE DIV ROW BOOTSTRAP-->
    </div><!--CIERRE DIV CONTAINER BOOTSTRAP-->

    <!-- Footer -->
    <?php require 'footer.php';?>      
<script src="libs/bootstrap/js/bootstrap.min.js"></script><!--BOOTSTRAP-->    
</body>
</html>