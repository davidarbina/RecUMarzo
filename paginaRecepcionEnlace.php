
<h1>Información recibida</h1>
    <?php//Solo se puede mandar por get en caso de hacerlo mediante enlaces
            $nombre = $_GET["nombre"];
            $apellido = $_GET["apellido"];
            // Mostrar los valores recibidos
            echo "<p>Nombre: $nombre</p>";
            echo "<p>Apellido: $apellido</p>";
        
    ?>
