<?php 
session_start();
  if(!isset($_SESSION['usuario'])){
    header("Location:../index.php");
  }else{
    if($_SESSION['usuario']=="ok"){
        $nombreUsuario=$_SESSION["nombreUsuario"];
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
  <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="../../css/bootstrap.css"/>


    
  </head>
  <body>

    <?php $url="http://".$_SERVER['HTTP_HOST']."/SitioWeb" ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
          <ul class="nav navbar-nav">
        
            <a class="nav-item nav-link" href="<?php $url;?>/administrador/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php $url;?>/administrador/seccion/productos.php">Galeria de juegos</a>
            <a class="nav-item nav-link" href="<?php $url;?>/administrador/seccion/cerrar.php">Cerrar sesion</a>
            <a class="nav-item nav-link" target="_blank" href="<?php echo $url;?>">Ver sitio web</a>
        </div>
    </nav>

    <div class="container">
        <br>
        <div class="row">