<?php
	// Verifica si la variable $_SERVER['HTTPS'] no está vacía y si su valor es 'on'
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		// Si es verdadero, establece $uri como 'https://'
		$uri = 'https://';
	} else {
		// Si es falso o no está definido, establece $uri como 'http://'
		$uri = 'http://';
	}
	// Concatena el valor de $_SERVER['HTTP_HOST'] al final de $uri
	$uri .= $_SERVER['HTTP_HOST'];
	// Redirige el navegador a la URL construida en $uri seguido de '/dashboard/'
	header('Location: '.$uri.'/dashboard/');
	// Finaliza la ejecución del script para evitar que se procese más código después de la redirección
	exit;
?>



