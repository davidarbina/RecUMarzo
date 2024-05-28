<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    //En este caso si ha  iniciado sesion le redirigimos a paginabienvenida.php  
    if (isset($_SESSION['codigo'])) {
        header('Location: paginabienvenida.php');
    }?>
    <form action="procesologin.php" method="post">
        <label for="nombre"> Nombre</label><input type="text" name="txtUsuario" id="nombre"/><br>
        <label for="contrasena"> Contraseña</label><input type="text" name="txtPass" id="passwd"/><br>
       <input type="submit" value="Enviar">
    </form>
    <!-- test -->
</body>
</html>