<?php
$host="localhost";
$bd="sitiojuegos";
$usuario="root";
$contrasenia="";

try {
     $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
     if($conexion){ "conectado.. a sistema";}

} catch (Exception $ex) {
    echo $ex->getMessage();
}
?>
