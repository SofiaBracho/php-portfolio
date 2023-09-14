<?php 
  include "cabecera.php"; 
  include "conexion.php";

  $conexion= new conexion();
?>

<div class="p-5 mb-4 bg-light rounded-3">
  <div class="container-fluid py-5">
    <h1 class="display-5 fw-bold">Bienvenidos</h1>
    <p class="col-md-8 fs-4">Este es un portafolio privado.</p>
    <button class="btn btn-primary btn-lg" type="button">Más información</button>
  </div>

  <div class="row">
      <?php
      $proyectos = $conexion->getProyects();

      // Bucle para iterar cada proyecto
      foreach ($proyectos as $proyecto) { ?>
    
      <div class="card col-md-3" style="width: 18rem;">
        <img class="card-img-top" src="<?="img/img-proyectos/".$proyecto["imagen"];?>" height="200" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title"><?=$proyecto["nombre"];?></h5>
          <p class="card-text"><?=$proyecto["descripcion"];?></p>
        </div>
      </div>

    <?php } ?>

  </div>

</div>

<?php include "pie.php"; ?>