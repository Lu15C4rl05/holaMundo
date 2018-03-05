<!DOCTYPE html>
<html>
<head>
	<title>INSERTAR</title>
</head>
<body>
	<h1>Ingreso de pasajeros</h1>
	<form method="POST" action="pasajeros/index">
		<p>Código del pasajero: </p>
		<input type="input" name="codigo_pasaj">
		<br/>
		<p>Nombre del pasajero: </p>
		<input type="input" name="nombre_pasaj">
		<br/>
		<p>Código de Verificación del pasajero: </p>
		<input type="input" name="codigoVer_pasaj">
		<br/>
		<input type="submit" name="Enviar">
	</form>

</body>
</html>