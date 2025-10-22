<?php

function crearConexion() {
	// Cambiar en el caso en que se monte la base de datos en otro lugar
	$host = "db";
	$user = "root";
	$pass = "root";
	$baseDatos = "basketandbites";

	$conn = new mysqli($host, $user, $pass, $baseDatos, 3306);

	if ($conn->connect_error) {
		die("Error de conexion con la base de datos: " . $conn->connect_error);
	}
	return $conn;
}

function cerrarConexion($conexion) {
	$conexion->close();
	return true;
}
