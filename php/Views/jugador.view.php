<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Nombre y Color</title>
</head>
<body>
    <h2>Formulario</h2>
    <form action="" method="post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="color">Color favorito:</label><br>
        <select id="color" name="color" required>
            <option value="red">Rojo</option>
            <option value="blue">Azul</option>
            <option value="green">Verde</option>
            <option value="yellow">Amarillo</option>
            <option value="black">Negro</option>
            <option value="white">Blanco</option>
        </select><br><br>
        
        <input type="submit" value="Enviar">
    </form>
</body>
</html>