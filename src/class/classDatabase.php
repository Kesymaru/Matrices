<?php
/*
 * ACORE 4.0 Author: Brian Salazar http://www.avenidanet.com
 * 
 * Clase de Abstracion de la base de datos
 */
class Database{
	
	private $dbHost 	= "localhost";
	private $dbUser 	= "matrizroot";
	private $dbPassword = "Matriz159!!";
	private $dbDatabase = "matriz";
	
	private $dbLink      = 0;
	private $dbRecordSet = 0;
	public  $dbResult    = false;


/* Metodos principales */

	public function __construct(){	
		//Conectar 
		$this->conect();
					
		if($this->dbDatabase != ""){
			$this->setBase();
		}

	}
	
	//Conexion
	private function conect(){
		$this->dbLink= mysql_connect($this->dbHost, $this->dbUser, $this->dbPassword) or die ("Error classDatabase.php: 01 en conect. " . mysql_error()); 
	}

	//Seleccionar base	
	private function setBase(){
		mysql_select_db($this->dbDatabase) or die ("Error classDatabase.php: 02 en setBase. " . mysql_error()); 
	}
		
	public function __destruct(){
		$this->disconnect();	
	}
	//Desconexion
	private function disconnect(){
		if($this->dbLink){
		mysql_close($this->dbLink);	
		}
	}

	//Ejecuta consulta
	private function query($query){
		
		$resultado = mysql_query($query) or die ("Error classDatabase.php: 03 en query. " . mysql_error());
		
		if(is_bool($resultado)){
			$this->dbResult = $resultado;
		}else{
			$this->dbRecordSet = $resultado;
		}
	}

	//Devuelve numero de filas del recordset
	public function getRows(){
		return mysql_num_rows($this->dbRecordSet);
	}

	//Devuelve el recordSet en un arreglo
	public function getRecordSet(){
		$registros = array();
		if($this->getRows()){
			while($registro = mysql_fetch_assoc($this->dbRecordSet)){
				$registros = $registro;
			}
		}
		return $registros;
	}
		
	
/* Manejo de consultas */

	//Sentencia SELECT
	public function querySelect($tabla,$tipo = "default",$campos = "*",$where = "", $order = "",$limit = ""){
		
		$sentencia = "SELECT ";
		
		$sentencia .= ( $tipo == 'count' ) ? 'COUNT(' : '';
		
			if($campos != "*"){
				foreach($campos as $campos => $valor){
					$sentencia .= $valor . ",";
				}
				$sentencia = substr($sentencia, 0, -1);
			}else{
				$sentencia .= $campos;
			}
		
		$sentencia .= ( $tipo == 'count' ) ? ')' : '';
		
		$sentencia .= " FROM " . $tabla;
		$sentencia .= ( $where == '' ) ? '' : ' WHERE ' . $where;
		$sentencia .= ( $order == '' ) ? '' : ' ORDER BY ' . $order;
		$sentencia .= ( $limit == '' ) ? '' : ' LIMIT ' . $limit;
		$sentencia .= ";";
		
		//echo $sentencia;
		$this->query($sentencia);
	}		
	
	/**
	* INSERTAR DATOS
	* @param $tabla -> tabla
	* @param $datos -> array key -> campo y value -> dato
	*/
	public function queryInsert($tabla,$datos){
	
        $campos  = "";
        $valores = "";
        
        foreach ($datos as $field => $value)
        {
            $campos 	.= "".$field.",";
            $valores 	.= ( is_numeric( $value )) ? $value."," : "'".$value."',";			
        }
		
		$campos 	= substr($campos, 0, -1);
        $valores 	= substr($valores, 0, -1);
		
        $sentencia = "INSERT INTO " . $tabla ."(".$campos.") VALUES( ".$valores.");";
		
		//echo $sentencia;
		$this->query($sentencia);
	}

	/**
	* TRUNCA UNA TABLA
	* @param $tabla -> tabla ha limpiar
	*/
	public function clear($tabla){
		$query = "TRUNCATE TABLE ".$tabla;
		mysql_query($query) or die('Error classDatabase.php: 04 en clear. '. mysql_errno());
	}
	
	/**
	* REVISA SI EXISTE UN DATO DENTRO DE UNA TABLA
	* return true -> si existe
	* @param $tabla -> tabla ha consultar
	* @param $campo -> array campos ha seleccionar
	* @param $id -> array valores ha comparar
	*/
	public function exits($tabla, $campos, $datos){

		$query = "SELECT ";
		
		if($campos != "*"){
			foreach($campos as $campos => $valor){
				$query .= $valor . ",";
			}
			$query = substr($query, 0, -1);
		}else{
			$query .= $campos;
		}
		
		$query .= " FROM " . $tabla . " WHERE ";
		
		foreach ($datos as $field => $value)
        {
            $query .= $field." = ";
            $query .= ( is_numeric( $value )) ? $value."," : "'".$value."'";	
            $query .= " AND ";		
        }
		$query = substr($query, 0, -4);

		$resultado = mysql_query($query) or die ("Error classDatabase.php: 05 en exits. " . mysql_error());
		
		if($resultado = mysql_fetch_array($resultado)){
			return true;
		}else{
			return false;
		}
	}

	/**
	* ENCRIPTA TEXTO
	* @param $text => texto a encriptar o desencriptar
	*/
	public function encripta($text){
		//quita / y etiquetas html
		$text = stripcslashes($text);
		$text = strip_tags($text);
		$text = md5 ($text); 
		$text = crc32($text);
		$text = crypt($text, "xtemp"); 
		$text = sha1("xtemp".$text);
		return $text;
}
}