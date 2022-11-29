<?php include("../template/cabecera.php")?>
<?php 

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtnombre=(isset($_POST['txtnombre']))?$_POST['txtnombre']:"";
$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){

    case "Agregar":

        $sentenciaSQL= $conexion->prepare("INSERT INTO juegos (nombre,imagen) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtnombre);

        $fecha=new DateTime();
        $nombreArchivo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen.jpg";

        $tmpimagen=$_FILES["txtimagen"]["tmp_name"];

        if($tmpimagen!=""){

            move_uploaded_file($tmpimagen,"../../img/".$nombreArchivo);
        }

        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        header("Location:productos.php");
        break;

    case "Modificar":
        $sentenciaSQL= $conexion->prepare("UPDATE juegos SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre',$txtnombre);
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        
        if($txtimagen!=""){

            $fecha=new DateTime();
            $nombreArchivo=($txtimagen!="")?$fecha->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen.jpg";
            
            $tmpimagen=$_FILES["txtimagen"]["tmp_name"];

            move_uploaded_file($tmpimagen,"../../img/".$nombreArchivo);

            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM juegos WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $curso=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            if( isset($curso["imagen"]) &&($curso["imagen"]!="imagen.jpg") ){
                
                if(file_exists("../../img/".$curso["imagen"])){
    
                    unlink("../../img/".$curso["imagen"]);
                }
            }

            $sentenciaSQL= $conexion->prepare("UPDATE juegos SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");
        break;
    case "Cancelar":
        header("Location:productos.php");
        break;
    case "Seleccionar":
        $sentenciaSQL= $conexion->prepare("SELECT * FROM juegos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $curso=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtnombre=$curso['nombre'];
        $txtimagen=$curso['imagen'];
        //echo "Presionado boton Seleccionar";
        break;

    case "Borrar":
       
        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM juegos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $curso=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if( isset($curso["imagen"]) &&($curso["imagen"]!="imagen.jpg") ){
            
            if(file_exists("../../img/".$curso["imagen"])){

                unlink("../../img/".$curso["imagen"]);
            }
        }

        $sentenciaSQL= $conexion->prepare("DELETE FROM juegos WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;
    }

$sentenciaSQL= $conexion->prepare("SELECT * FROM juegos");
$sentenciaSQL->execute();
$listacursos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

    <div class="col-md-5">

        <div class="card">
            <div class="card-header">
                Datos de los VideoJuegos 
            </div>

            <div class="card-body">

            
            <form method="POST" enctype="multipart/form-data">

            <div class = "form-group">
            <label for="txtID">ID:</label>
            <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" a
            placeholder="ID">   
            </div>

            <div class = "form-group">
            <label for="txtnombre">nombre:</label>
            <input type="text" required class="form-control" value="<?php echo $txtnombre; ?>" name="txtnombre" id="txtnombre" a
            placeholder="Nombre del VideoJuego">   
            </div>
            

            <div class = "form-group">
            <label for="txtnombre">Imagen:</label>

            <br/>

            <?php  if($txtimagen!=""){ ?>

                <img  class="img-thumbnail rounded" src="../../img/<?php echo $txtimagen; ?>" width="50" alt="" srcset="">

            <?php }?>    

            <input type="file" class="form-control" name="txtimagen" id="txtimagen" placeholder="nombre del juego">   
            </div>


            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?>  value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?>  value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>


                
    </div>

</div>


</div>
    <div class="col-md-7">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listacursos as $curso) { ?>
                <tr>
                    <td><?php echo $curso['id'];?></td>
                    <td><?php echo $curso['nombre'];?></td>
                    <td>
                        
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $curso['imagen'];?>" width="50" alt="" srcset="">
                    
                    </td>

                    <td>
                        
                   <form method="post">

                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $curso['id'];?>"/>

                        <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                        <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                   </form>
                
                    </td>

                </tr>
                <?php }?>
            </tbody>
        </table>

    </div>

<?php include("../template/pie.php")?>


