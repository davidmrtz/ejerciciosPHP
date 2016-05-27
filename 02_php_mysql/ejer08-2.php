<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Curso de PHP | mayo de 2016 | ejer08-2.php</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/colors.css">
    <link rel="stylesheet" href="../css/ejemplos.css">
</head>
<body>


<?php
// Abrir la conexión
$conexion = mysqli_connect("localhost", "root", "root", "blog");

// Borrado, si es que nos pasan un id
if (isset($_GET['id'])) {

    $q = "SELECT  * from entrada where id='" . $_GET['id'] . "'";

    // Ejecutar la consulta en la conexión abierta. No hay "resultset"
    $r = mysqli_query($conexion, $q) or die(mysqli_error($conexion));


    $fila = mysqli_fetch_assoc($r);



    echo "<p class='red'>";

    if (mysqli_affected_rows($conexion) > 0)
        echo "Se ha encontrado la entrada con ID " . $_GET['id'] . ".";

    echo "</p>";

}

// Cerrar la conexión
mysqli_close($conexion);
?>


<h2>Modificar o Borrar el post</h2>

<?php

?>
<form action="ejer08-2.php" method="get">

    <div>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $fila['titulo']; ?>"/>
    </div>
    <div>
        <label for="texto">Texto:</label>
        <textarea id="texto" name="texto" rows="4" cols="40" ><?php echo $fila['texto']; ?></textarea>
    </div>
    <div>
        <label for="fecha">Fecha:</label>
        <input type="text" id="fecha" name="fecha" value="<?php echo $fila['fecha']; ?>"/>
    </div>

    <div>
        <label for="activo">Activo:</label>


        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />

        <input type="checkbox" id="activo" name="activo" <?php

        if ($fila['activo'] == 1)
            echo 'checked="checked"';

        ?> />
    </div>

    <?php
    // Abrir la conexión
    $conexion = mysqli_connect("localhost", "root", "root", "blog");

    // Formar la consulta (seleccionando todas las filas)
    $q = "SELECT  * from comentario where entrada_id='" . $_GET['id'] . "'";

    // Ejecutar la consulta en la conexión abierta y obtener el "resultset" o abortar y mostrar el error
    $r = mysqli_query($conexion, $q) or die(mysqli_error($conexion));

    // Calcular el número de filas
    $total = mysqli_num_rows($r);
    

    // Mostrar el contenido de las filas, creando una tabla XHTML
    if ($total > 0) {

        while ($coment = mysqli_fetch_assoc($r)) {
            echo "
                <div>
                    <label for=\"coment\">Comentarios:</label>
                    <textarea id=\"coment\" name=\"coment\" rows=\"4\" cols=\"40\" >'".$coment['texto']."'</textarea>

    </div>";

        }

    }
    ?>
    <div>
        <input type="reset" id="limpiar" name="limpiar" value="Limpiar"/>
        <input type="submit" id="enviar" name="enviar" value="Guardar"/>
        <input type="submit" id="borrar" name="borrar" value="Borrar"/>
        <input type="submit" id="comentario" name="comentario" value="Insertar nuevo comentario"/>
    </div>

</form>



<?php if (isset($_GET['comentario'])) { ?>

    <div>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo $coment['email']; ?>" />
    </div>
    <div>
        <label for="texto">Nuevo Comentario:</label>

        <div>
            <textarea id="texto" name="texto" rows="4" cols="40" ><?php echo $coment['texto']; ?></textarea>
        </div>

    </div>
    <div>
        <label for="fecha">Fecha:</label>
        <input type="text" id="fecha" name="fecha" value="<?php echo $coment['fecha']; ?>"/>
    </div>
    <div>
        <label for="activo">Activo:</label>


        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"  />

        <input type="checkbox" id="activo" name="activo" <?php

        if ($fila['activo'] == 1)
            echo 'checked="checked"';

        ?> />
        <div>
            <input type="submit" id="guardarcoment" name="guardarcoment" value="Guardar Comentario"/>
        </div>
    </div>

    <?php if (isset($_GET['guardarcoment'])) { ?>

        <?php
// Recoger los valores

        if (isset($_GET['email']))
            $titulo = $_GET['email'];


        if (isset($_GET['texto']))
            $texto = $_GET['texto'];


        if (isset($_GET['fecha']))
            $fecha = $_GET['fecha'];

        $activo = 0;
        if (isset($_GET['activo']))
            $activo = 1;
        ?>

        <?php
// Abrir la conexión
        $conexion = mysqli_connect("localhost", "root", "root", "blog");

// Borrado, si es que nos pasan un id
        if (isset($_GET['id'])) {
            // Borramos los comentarios correspondientes a la entrada
            $q = "insert into comentario values (id='0', email='".$email."', texto='".$texto."', fecha='".$fecha."', activo='".$activo."', entrada_id='" . $fila['id'] . "')";

            // Ejecutar la consulta en la conexión abierta. No hay "resultset"
            mysqli_query($conexion, $q) or die(mysqli_error($conexion));

            // Comprobar si hemos afectado a alguna fila
            echo "<p class='green'>";


        }

        if (mysqli_affected_rows($conexion) > 0)
            //Muestra el MSG cuando los ha eliminado
            echo "<script>alert(\"COMENTARIO AÑADIDO\");</script>";
        else
            echo "<script>alert(\"NO SE HA AÑADIDO NINGÚN COMENTARIO\");</script>";

        echo "</p>";
        //Nos lleva a la ventana de la tabla
        echo  "<script>window.location='ejer08.php';</script>";

    }
}
?>


<?php if (isset($_GET['borrar'])) { ?>
    <?php
// Abrir la conexión
    $conexion = mysqli_connect("localhost", "root", "root", "blog");

// Borrado, si es que nos pasan un id
    if (isset($_GET['id'])) {
        // Borramos los comentarios correspondientes a la entrada
        $q = "delete from entrada where id='" . $_GET['id'] . "'";

        // Ejecutar la consulta en la conexión abierta. No hay "resultset"
        mysqli_query($conexion, $q) or die(mysqli_error($conexion));

        // Comprobar si hemos afectado a alguna fila
        echo "<p class='red'>";


    }

    if (mysqli_affected_rows($conexion) > 0)
        //Muestra el MSG cuando los ha eliminado
        echo "<script>alert(\"DATOS ELIMINADOS\");</script>";
    else
        echo "<script>alert(\"NO SE HA MODIFICADO NINGUNA ENTRADA\");</script>";

    echo "</p>";
    //Nos lleva a la ventana de la tabla
    echo  "<script>window.location='ejer08.php';</script>";
}

?>

<?php if (isset($_GET['enviar'])) { ?>

    <?php
// Recoger los valores

    if (isset($_GET['titulo']))
        $titulo = $_GET['titulo'];


    if (isset($_GET['texto']))
        $texto = $_GET['texto'];


    if (isset($_GET['fecha']))
        $fecha = $_GET['fecha'];

    $activo = 0;
    if (isset($_GET['activo']))
        $activo = 1;
    ?>

    <?php
// Abrir la conexión
    $conexion = mysqli_connect("localhost", "root", "root", "blog");


    $q = "UPDATE entrada SET titulo='". $titulo. "',texto='".$texto."',fecha='".$fecha."',activo='".$activo."' WHERE id ='".$_GET['id']."'";


// Ejecutar la consulta en la conexión abierta. No hay "resultset"
    mysqli_query($conexion, $q) or die(mysqli_error($conexion));
    if (mysqli_affected_rows($conexion) > 0)
        echo "<script>alert(\"DATOS MODIFICADOS\");</script>";
    else
        echo "<script>alert(\"NO SE HA MODIFICADO NINGUNA ENTRADA\");</script>";

    echo "</p>";


// Cerrar la conexión
    mysqli_close($conexion);

    echo  "<script>window.location='ejer08.php';</script>";
}

?>

<?php ?>

</body>
</html>