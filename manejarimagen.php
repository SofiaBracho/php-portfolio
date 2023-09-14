<?php 
    const TAM_MAX=2048000;
    $directorio="img/img-proyectos";
    
    function cargarImagen($imagen, $nombre_imagen){
        global $directorio;

        //verificar que la imagen cumpla las condiciones
        if(verificarImagen($imagen)){
    
            //Verifico la ruta
            if (directorioExiste($directorio)) {
                //Proseguir con la manipulación del archivo
                moverArchivo($imagen, $nombre_imagen);
            }
        }
    }

    function moverArchivo($imagen, $nombre_imagen){
        global $directorio;
        
        $nombre_temp=realpath($imagen["tmp_name"]);
        $nombre=basename($imagen["name"]); //basename ayuda a protegerse contra ataques transversales

        $nueva_ruta="$directorio/$nombre_imagen";
        
        try {
            move_uploaded_file($nombre_temp,$nueva_ruta);
            // echo "Archivo subido exitosamente!";
        } catch (\Throwable $th) {
            echo "<script>alert('Error al subir el archivo: ".$th."');</script>";
        }
    }

    function directorioExiste($directorio){

        if(is_dir($directorio)){ 
            return true;
        }else{ 
            try {
                mkdir("$directorio"); //crear carpeta para almacenar las imágenes
                chmod("$directorio", 755); //permisos

            } catch (\Throwable $th) {
                echo "Error: ".$th;
                return false;
            }
            return true;
        }
    }

    function verificarImagen($imagen){
        $tamaño=$imagen["size"];
        $tipo_imagen=$imagen["type"];

        $tipo_valido= ($tipo_imagen == "image/jpeg" or $tipo_imagen == "image/png")?true:false;
        $no_hay_error= ($imagen["error"]==0)?true:false;
        $tamaño_valido= ($tamaño < TAM_MAX)?true:false;

        if($tipo_valido && $no_hay_error){
            if($tamaño_valido){
                return true;
            }else{
                echo "<script> alert('La imagen excede el límite mencionado...'); </script>";
            }
        }else {
            echo "<script> alert('Por favor, inserta una imagen...'); </script>";
        }
        return false;
    }

    function eliminarImagen($img){
        global $directorio;
        $ruta="$directorio/$img";

        unlink($ruta);
    }

?>