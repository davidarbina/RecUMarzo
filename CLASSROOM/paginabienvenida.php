<?php
require_once 'funciones.php';//Require lo que hace es lo mismo que el include solamente que lo hace una vez, si no lo encuentra dice un error
session_start();
//var_dump($resultados_asir=f_sacarAsignaturasASIR1($_SESSION['codUsuario']));
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
}elseif ($_SESSION['rol']!=2 && $_SESSION['rol']!=3) {
    ?>
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

a{
    color: black;
}
  </style>
</head>
<body>

<?php

require_once 'funciones.php';//Require lo que hace es lo mismo que el include solamente que lo hace una vez, si no lo encuentra dice un error


?>
<h1>Hola <?=$_SESSION['nombre']?></h1>
<?php

$resultados_asir=f_sacarAsignaturas($_SESSION['codUsuario']);


foreach($resultados_asir as $resultado){
?>
<div class="center-text">
    
    <div class="casilla">
      <h2 class="titulo">
        <a href="asignatura.php?codAsignatura=<?=$resultado['CodAsignatura'] ?>&codCiclo=<?=$resultado['codCiclo']?>">
          <?=$resultado['nombreasignaturas'] ?>
         </a>
      </h2>
      <p class="contenido"><?=$resultado['nombreciclo'] ?></p>
    </div>
</div>
<?php
}

}elseif ($_SESSION['rol']=2) { 
    ?>
    <h1>Hola <?=$_SESSION['nombre'] ?></h1>
    <h1>Asignaturas del Profe</h1>
    <?php
    $AsigProfe=f_obtenerAsigProfe($_SESSION['codUsuario']);

   // var_dump($AsigProfe);
    foreach ($AsigProfe as $Asignatura ) {
      ?>
      <div class="center-text"><!--afsdf-->
        <div class="casilla">
          <h2 class="titulo">
            <a href="asignaturaProfe.php?codAsignatura=<?=$Asignatura['CodAsignaturas'] ?>&codCiclo=<?=$Asignatura['codCiclo']?>">
              <?=$Asignatura['nombreasignaturas'] ?>
            </a>
          </h2>
          
        </div>
      </div>
<?php
}
?> 
      
    
<?php
}
?>
</body>
</html>
