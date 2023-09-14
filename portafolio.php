<?php 
    include "cabecera.php"; 
    include "conexion.php";
    include "manejarimagen.php";
    
    $conexion = new conexion();

    if(isset($_GET["editar"])){
        $editar_id=$_GET["editar"];
        $data_edit=$conexion->getProyects($editar_id)[0];
    }

    if(isset($_GET["eliminar"])){
        $eliminar_id=$_GET["eliminar"];
        $img_eliminar=$conexion->getProyects($eliminar_id)[0]["imagen"];

        eliminarImagen($img_eliminar);
        $conexion->deleteProyect($eliminar_id);
    }
    
    //Si ingresaron datos en el formulario 
    if(isset($_POST)){
        //Si subieron un archivo
        if(isset($_FILES["archivo"])) {
            $nombre=$_POST["nombre"];
            $descripcion=$_POST["descripcion"];
            $imagen=$_FILES["archivo"];
            //Agrego un timestamp para evitar sobreescribir img con nombres repetidos
            $timestamp=time();
            $nombre_imagen=$timestamp."_".$imagen["name"];
            
            cargarImagen($imagen, $nombre_imagen);

            if(isset($_POST["enviar"])){
                $conexion->insertProyect($nombre,$descripcion,$nombre_imagen);
                
            } else if(isset($_POST["editar"])){
                $id=$_POST["id"];
                $conexion->editProyect($id, $nombre, $nombre_imagen, $descripcion);
            }
        }
    }

?>

<div class="container">
    <br>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3>Datos del proyecto</h3>
                </div>
                <div class="card-body">
                    <form action="portafolio.php" method="post" enctype="multipart/form-data">
                        Nombre del proyecto: <input required class="form-control" type="text" name="nombre" value="<?=(isset($data_edit))?$data_edit["nombre"]:'';?>">
                        <br>
                        Descripción del proyecto:
                        <textarea required name="descripcion" cols="15" rows="5" class="form-control"><?=(isset($data_edit))?$data_edit["descripcion"]:'';?></textarea>
                        <br>
                        Imagen del proyecto: <input required class="form-control" type="file" name="archivo">
                        <br>
                        
                        <?php if(isset($data_edit)){ ?>
                            <img width="250" height="250" src="./img/img-proyectos/<?=(isset($data_edit))?$data_edit["imagen"]:''; ?>">
                        <?php } ?>

                        <br>
                        <br>
                        <input type="hidden" name="id" value="<?=(isset($editar_id))?$editar_id:'';?>">
                        <input class="btn btn-success" type="submit" name="<?=(isset($data_edit))?'editar':'enviar';?>" value="<?=(isset($data_edit))?'Editar proyecto':'Enviar proyecto';?>">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Imagen</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $proyectos = $conexion->getProyects();

                        // Bucle para iterar cada proyecto
                        foreach ($proyectos as $proyecto) { ?>
                            <tr>
                                <td scope="row"><?=$proyecto["id"]?></td>
                                <td><?=$proyecto["nombre"]?></td>
                                <td><?=$proyecto["descripcion"]?></td>
                                <td><img src="./img/img-proyectos/<?=$proyecto["imagen"]?>" width="100" height="100"></td>
                                <td> 
                                    <a class="btn btn-danger" href="?eliminar=<?=$proyecto["id"]?>">Eliminar</a> 
                                    <a class="btn btn-warning" href="?editar=<?=$proyecto["id"]?>">Editar</a> 
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
</div>

<?php include "pie.php"; ?>