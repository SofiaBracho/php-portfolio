<?php

    class conexion{
        private $host = "localhost";
        private $user = "postgres";
        private $pass = "1234";
        private $port = 5432;
        private $dbname = "album";
        private $conn;

        public function __construct()
        {
            try 
            {
                $this->conn = new PDO('pgsql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); //Configura la conección para mostrar los errores
                
            } catch (PDOException $error) 
            {
                die("Could not connect to database: ".$error);
            }
        }
        
        function __destruct() {
            //Cierro la conexión
            $this->conn=null;
        }

        public function insertProyect($nombre,$descripcion,$imagen)
        {
            try 
            {    
                $sql = 'INSERT INTO proyectos (nombre, imagen, descripcion) VALUES (:nombre, :imagen, :descripcion)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':imagen', $imagen);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->execute();
    
                // Obtener el resultado de la inserción
                if ($this->conn->lastInsertId() !== 0) 
                {
                    header('Location:portafolio.php');
                    // $insert_id = $this->conn->lastInsertId();
                    // echo "El proyecto se insertó satisfactoriamente! El id del nuevo proyecto es $insert_id.";
                }

            } catch (PDOException $error) 
            {
                die("<script> alert('Hubo un error al realizar la inserción:".$error."'); </script>");
            }
        }

        public function deleteProyect($id)
        {
            try 
            {
                $sql = 'DELETE FROM proyectos WHERE id = :id';
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
    
                if ($stmt->rowCount() == 1) 
                {
                    // echo "El proyecto se eliminó satisfactoriamente!";
                    header('Location:portafolio.php');
                }

            } catch (PDOException $error) 
            {
                die("<script> alert('Hubo un error al realizar la eliminación:".$error."'); </script>");
            }
        }
    
        public function getProyects($id = null)
        {
            try 
            {    
                $sql = 'SELECT * FROM proyectos';
                if ($id !== null) {
                    $sql .= ' WHERE id = :id';
                }
                $stmt = $this->conn->prepare($sql);
                if ($id !== null) {
                    $stmt->bindParam(':id', $id);
                }
                $stmt->execute();
            
                //Obtengo un array con todos los resultados
                $proyects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
                return $proyects;

            } catch (PDOException $error) 
            {
                die("<script> alert('Hubo un error al realizar la consulta:".$error."'); </script>");
            }
        }

        public function editProyect($id, $nombre=null, $imagen=null, $descripcion=null)
        {
        
            try 
            {    
                $sql="UPDATE proyectos SET nombre=:nombre , imagen=:imagen, descripcion=:descripcion where id=:id ";
                $stmt=$this->conn->prepare($sql);
                
                $stmt->bindValue(":nombre",$nombre);
                $stmt->bindValue(":imagen",$imagen);
                $stmt->bindValue(":descripcion",$descripcion);
                $stmt->bindValue(":id",$id);
                
                $result=$stmt->execute();
                
                if($result==true)
                {
                    // echo "Has editado el proyecto $id satisfactoriamente!";
                    header('Location:portafolio.php');
                }

            }catch(PDOException $e){
               print"<script> alert('Error!: " . $e->getMessage(). "'); </script>";
               die();
            }
            
        }

    }

?>