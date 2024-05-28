<?php
//Comprobamos que si los datos del formulario no existen se volvera a la pagina login.php
if (!isset($_POST['txtUsuario']) || !isset($_POST['txtPass']) ) {
    header('Location: login.php');
}else {
//Si existen se guardaran esos datos en las variables $usuario y $contrasena
    $usuario = $_POST['txtUsuario'];
    $contrasena = $_POST['txtPass'];
}

//Ahora 
include 'funciones.php';

$datos= f_login($usuario,$contrasena);
//echo $datos['rol'];
if ($datos['rol'] != -1) {
    session_start();
    $_SESSION['nombre']= $usuario;
    $_SESSION['rol']= $datos['rol'];
    $_SESSION['codUsuario']= $datos['codUsuario'];
    header('Location: paginabienvenida.php');
}else {
    header('Location: login.php');
}

?>