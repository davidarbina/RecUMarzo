

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once 'funciones.php';
?>
<h1>Trabajos</h1>
<?php
if(!isset($_GET['codAsignatura']) || !isset($_GET['codCiclo'])){
  header('Location: paginabienvenida.php');
}
$codAsignatura=$_GET['codAsignatura'];
$codCiclo=$_GET['codCiclo'];
$enunciados= f_sacardatosTrabajos($codAsignatura,$codCiclo);


foreach($enunciados as $enunciado){
    ?>
    <div class="center-text">
        
        <div class="casilla">
             <h1 class="titulo">
                <a href="enunciado.php?codAsignatura=<?=$enunciado['codAsignatura'] ?>&codCiclo=<?=$enunciado['codCiclo']?>&codEnunciado=<?=$enunciado['codEnunciado']?>">
                <?=$enunciado['nombreenunciado'] ?>
                </a>
            </h1>
            <a href="../ENUNCIADOS\ASIGNATURAS\<?=$codAsignatura?>-<?=$codCiclo?>\ENUNCIADO\<?=$enunciado["codEnunciado"]?>-<?=$codAsignatura?>-<?=$codCiclo?>\<?=$enunciado["codEnunciado"]?>-<?=$codAsignatura?>-<?=$codCiclo?>.<?=$enunciado['extension']?>" download="descarga_trabajo<?=$enunciado["codEnunciado"]?>-<?=$codAsignatura?>-<?=$codCiclo?>" ><?=$enunciado['descripcion'] ?></a>            
          <h1>Descripcion:</h1>
          <p>
          <?=$enunciado['descripcion'] ?>
          </p>
          <h2></h2>
          <h2 class="contenido">Fecha Entrega:<?=$enunciado['fechaEntrega'] ?></h2>
          <h2 class="contenido"><?=$enunciado['nombreasignaturas'] ?>-<?=$enunciado['nombreciclo'] ?></h2>
        </div>
    <?php
    }
    ?> 

</body>
</html>