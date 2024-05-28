<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
  .casilla {
  width: 300px;
  padding: 20px;
  border: 1px solid #ccc;
  margin: 10px;
  box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
}
.titulo {
  font-size: 20px;
  margin: 0;
  margin-bottom: 10px;
}
.contenido {
  font-size: 16px;
  line-height: 1.5;
  margin: 0;
}
  </style>
</head>
<body>
<?php

require_once 'funciones.php';//Require lo que hace es lo mismo que el include solamente que lo hace una vez, si no lo encuentra dice un error
session_start();


$resultados_asir=f_sacarAsignaturas($_SESSION['codUsuario']);

foreach($resultados_asir as $resultado){
?>
<div class="center-text">
    
    <div class="casilla">
      <h2 class="titulo"><?=$resultado['nombreasignaturas'] ?></h2>
      <p class="contenido"><?=$resultado['nombreciclo'] ?></p>
    </div>
<?php
}
?>  
</body>
</html>


