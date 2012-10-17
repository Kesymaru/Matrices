<?php
/* Conexion y funcionalidades de la base de datos */

$host      =    "localhost";
$user      =    "root";
//$pass      =    "Trans123@";
$tablename =    "matriz";

//$conecta = mysql_connect($host,$user,$pass);
$conecta = mysql_connect($host,$user);

mysql_select_db($tablename, $conecta) or die (mysql_error ());



?>

<!DOCTYPE html>
<html>

<head>
	<title>77Digital</title>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" href="css/style.css" TYPE="text/css" MEDIA=screen>	

</head>

<body>

	


</body>

</html>