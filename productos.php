<?php include("template/cabecera.php"); ?>
<?php 
include("administrador/config/bd.php");
$sentenciaSQL= $conexion->prepare("SELECT * FROM juegos");
$sentenciaSQL->execute();
$listacursos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listacursos as $curso) {?>

<div class="col-md-3">
<div class="card">
<img class="card-img-top" src="./img/<?php echo $curso['imagen']; ?>" alt="">
<div class="card-body">
    <h4 class="card-title"><?php echo $curso['nombre']; ?></h4>
    <a name="" id="" class="btn btn-primary" href="https://gameshopvideojuegos.com/" target="_blank" role="button">ver mas</a>
</div>
</div>    
</div>
<?php } ?>


<?php include("template/pie.php"); ?>  
