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
            <option value="rojo">Rojo</option>
            <option value="azul">Azul</option>
            <option value="verde">Verde</option>
            <option value="amarillo">Amarillo</option>
            <option value="negro">Negro</option>
            <option value="blanco">Blanco</option>
        </select><br><br>
        
        <input type="submit" value="Enviar">
    </form>
</body>
</html>