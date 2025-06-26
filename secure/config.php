<?php
/*==========================================
=            variables glogales            =
==========================================*/
///error_reporting(0); // No mostrar reportes de errores en el codigo.
///header('Cache-Control: no cache'); //no cache
//session_cache_limiter('private_no_expire'); // works // BASE 1
///session_cache_limiter('private, must-revalidate');      //BASE 2
///session_cache_expire(300); //BASE 2
//session_cache_limiter('public'); // works too
session_start(); // Si tienes habilitado "session.auto_start=1" dejar esta linea comentada
/*=====  Fin de variables glogales  ======*/

/*==================================
=            Sistema web           =
==================================*/
function config(){
    $GLOBALS['charset'] = ('utf-8');
    $GLOBALS['date']=(date("d/m/Y"));
	$GLOBALS['url']=("http://localhost/"); //http://demon.sytes.net/
    $GLOBALS['title']=('CONTROL DE VENTAS AUTOMATIZADO');
    $GLOBALS['initials']=('T.');
    $GLOBALS['version']=('v1.0');
    $GLOBALS['copyright']=("Copyright &copy; ".date("Y")." - Todos los derechos reservados");
}
/*=====  Fin de Sistema web  ======*/

/*=====================================
=            Base de datos            =
=====================================*/
function conexionDB(){
	//datos del servidor y base de datos
	$GLOBALS["db"][0]=($host = ('127.0.0.1'));
	$GLOBALS["db"][1]=($usuario = ('root'));
	$GLOBALS["db"][2]=($clave = (''));
	$GLOBALS["db"][3]=($db = ('ventas'));

	global $mysql;
	$mysql = new mysqli($host,$usuario,$clave,$db);

	if ($mysql -> connect_errno) {
		echo("Error en la Conexion.");
	}

	// Consultas $tabla=($mysql->query("SELECT * FROM ..."));
}
/*=====  Fin de Base de datos  ======*/


/*=====================================
=            Separar monto            =
=====================================*/
function SepararMonto($monto){
    $monto=(number_format($monto, 2, ",", "."));
    return $monto;
}
/*=====  Fin separar monto    ======*/

//backup
function copiaSeguridad($host, $user, $pass, $dbname, $tables = '*'){
//make db connection
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
//get all of the tables
if($tables == '*'){
    $tables = array();
    $sql = "SHOW TABLES";
    $query = $conn->query($sql);
    while($row = $query->fetch_row()){
        $tables[] = $row[0];
    }
}
else{
    $tables = is_array($tables) ? $tables : explode(',',$tables);
}

//getting table structures
$outsql = '';
foreach ($tables as $table) {

    // Prepare SQLscript for creating table structure
    $sql = "SHOW CREATE TABLE $table";
    $query = $conn->query($sql);
    $row = $query->fetch_row();
    
    $outsql .= "\n\n" . $row[1] . ";\n\n";
    
    $sql = "SELECT * FROM $table";
    $query = $conn->query($sql);
    
    $columnCount = $query->field_count;

    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = $query->fetch_row()) {
            $outsql .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];
                
                if (isset($row[$j])) {
                    $outsql .= '"' . $row[$j] . '"';
                } else {
                    $outsql .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $outsql .= ',';
                }
            }
            $outsql .= ");\n";
        }
    }
    
    $outsql .= "\n"; 
}

// Save the SQL script to a backup file
$backup_file_name = "../generador/".$dbname . '.sql';
$fileHandler = fopen($backup_file_name, 'w+');
fwrite($fileHandler, $outsql);
fclose($fileHandler);
/*
// Download the SQL backup file to the browser
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($backup_file_name));
ob_clean();
flush();
readfile($backup_file_name);
exec('rm ' . $backup_file_name);*/
}

//Restore
function restaurar($filePath, $conn)
{
    $sql = '';
    $error = '';
    $response = '';
    
    if (file_exists($filePath)) {
        $lines = file($filePath);
        
        foreach ($lines as $line) {
            
            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            
            $sql .= $line;
            
            if (substr(trim($line), - 1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (! $result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "¡Enhorabuena! Restauración de la base de datos completada con éxito."
            );
        }
    } // end if file exists
    return $response;
}

//Correlativo
function correlativo($numero_correlativo){
    $correlativo=(str_pad($numero_correlativo, 5, "0", STR_PAD_LEFT));
    return $correlativo;
}

//mayusculas uniformato
function mayusculas($texto){
    $convertido=(strtoupper($texto));
    $convertido=(str_replace("á", "Á", $convertido));
    $convertido=(str_replace("é", "É", $convertido));
    $convertido=(str_replace("í", "Í", $convertido));
    $convertido=(str_replace("ó", "Ó", $convertido));
    $convertido=(str_replace("ú", "Ú", $convertido));
    $convertido=(str_replace("ñ", "Ñ", $convertido));
    return $convertido;
}

function comprobarURL($ruta){
    $test = file_exists($ruta);
    return $test;
}

/*=====================================
=            Cerrar sesion            =
=====================================*/
function salir(){
	//mysqli_close();
	session_destroy();
	unset($_SESSION['acceso']);
    unset($_SESSION['rol']);
}
/*=====  Fin de Cerrar sesion  ======*/

/*==========================================
=            Ordenar fechas                =
==========================================*/
function fechaHora($datetime){
    $a_ordenar = date_create($datetime);
    $ordenado = date_format($a_ordenar, 'd-m-Y H:i:s A');
    return $ordenado;
}
/*=====  Fin de ordenar fecha  ======*/
/*==========================================
=            Ordenar fechas   2            =
==========================================*/
function fecha($date){
    $a_ordenar = date_create($date);
    $ordenado = date_format($a_ordenar, 'd-m-Y');
    return $ordenado;
}
/*=====  Fin de ordenar fecha  ======*/

/*==========================================
=            Correo electronico            =
==========================================*/
function comrpobarEMAIL($email){
	if(ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@+([_a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]{2,200}\.[a-zA-Z]{2,6}$", $email)){
		return true;
	} 
	else{
		return false;
	}
}
/*=====  Fin de Correo electronico  ======*/

/*========================================
=            Encriptación EAS            =
========================================*/
function encriptacionAES($a_encriptar, $clave)
{
     $td = (mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, ''));
     $iv = (mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM ));
     mcrypt_generic_init($td, $clave, $iv);
     $a_encriptar_contenedor_datos = (mcrypt_generic($td, $a_encriptar));
     mcrypt_generic_deinit($td);
     mcrypt_module_close($td);
     $encriptado = (bin2hex($iv).bin2hex($a_encriptar_contenedor_datos));
     
     return $encriptado;
 }

 function desencriptacionAES($a_desencriptar, $clave)
 {
     $td = (mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, ''));
     $iv_size_hex = (mcrypt_enc_get_iv_size($td)*2);
     $iv = (pack("H*", substr($a_desencriptar, 0, $iv_size_hex)));
     $a_desencriptar_contenedor_datos = (pack("H*", substr($a_desencriptar, $iv_size_hex)));
     mcrypt_generic_init($td, $clave, $iv);
     $desencriptado = (mdecrypt_generic($td, $a_desencriptar_contenedor_datos));
     mcrypt_generic_deinit($td);
     mcrypt_module_close($td);
     
     return $desencriptado;
 }
/*=====  Fin de Encriptación EAS  ======*/

/*=============================================
=            Encriptación NewFiles            =
=============================================*/
function encriptacionPRO($a_encriptar){
	$salt = ('NewFiles'); // Frace de complemento
	$encriptado = (base64_encode(md5(sha1($salt . $a_encriptar))));
	
	return $encriptado;
}
/*=====  Fin de Encriptación NewFiles  ======*/

/*=========================================
=            Encriptación Salt            =
=========================================*/
function encriptacionSALT($a_encriptar){
	$salt = ('NewFiles'); // Frace de complemento
	$encriptado = (md5($salt . $a_encriptar));
	
	return $encriptado;
}
/*=====  Fin de Encriptación Salt  ======*/

/*=========================================
=            Encriptacion SHA1            =
=========================================*/
function encriptacionSHA1($a_encriptar){
	$encriptado = (sha1($a_encriptar));
	
	return $encriptado;
}
/*=====  Fin de Encriptacion SHA1  ======*/

/*========================================
=            Encriptación MD5            =
========================================*/
// Encriptación
function encriptacionMD5($a_encriptar){
	$encriptado = (md5($a_encriptar));
	
	return $encriptado;
}
/*=====  Fin de Encriptación MD5  ======*/

/*===========================================
=            Encriptación base64            =
===========================================*/
// Encriptación
function encriptacionBASE64($a_encriptar){
	$encriptado = (base64_encode($a_encriptar));
	
	return $encriptado;
}

// Desencriptación
function desencriptacionBASE64($a_desencriptar){
	$desencriptado = (base64_decode($a_desencriptar));
	
	return $desencriptado;
}
/*=====  Fin de Encriptación base64  ======*/

/*==========================================
=            Fecha del servidor            =
==========================================*/
function fechaServidor(){
    $dia=date("l");
    if ($dia=="Monday") $dia="Lunes";
    if ($dia=="Tuesday") $dia="Martes";
    if ($dia=="Wednesday") $dia="Miércoles";
    if ($dia=="Thursday") $dia="Jueves";
    if ($dia=="Friday") $dia="Viernes";
    if ($dia=="Saturday") $dia="Sabado";
    if ($dia=="Sunday") $dia="Domingo";

    $mes=date("F");
    if ($mes=="January") $mes="Enero";
    if ($mes=="February") $mes="Febrero";
    if ($mes=="March") $mes="Marzo";
    if ($mes=="April") $mes="Abril";
    if ($mes=="May") $mes="Mayo";
    if ($mes=="June") $mes="Junio";
    if ($mes=="July") $mes="Julio";
    if ($mes=="August") $mes="Agosto";
    if ($mes=="September") $mes="Setiembre";
    if ($mes=="October") $mes="Octubre";
    if ($mes=="November") $mes="Noviembre";
    if ($mes=="December") $mes="Diciembre";

    $ano=date("Y");
    $dia2=date("d");
    //setlocale(LC_ALL,"es_ES");
    //echo strftime("%A %d de %B del %Y");
    //$Today = date('y:m:d',mktime());
    //$new = date('l, d, F, Y', strtotime($Today));
    //echo $new;
    echo "$dia, $dia2 de $mes del $ano";
}
/*=====  Fin de Fecha del servidor  ======*/
?>
