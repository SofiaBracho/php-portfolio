<?php
    session_start();

    if(!$_SESSION["login"]){
        header('Location:login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/estilos.css">
</head>
<body>
    <header>
        <a href="index.php">
            <img src="./img/logo.png" alt="Logo">
        </a>

        <nav>
            <a href="index.php">Inicio</a>
            <a href="portafolio.php">Portafolio</a>
            <a href="cerrar.php">Cerrar Sesión</a>
        </nav>
    </header>
    <div class="container">