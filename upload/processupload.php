
<noscript>
<div align="center"><a href="index.php">Go Back To Upload Form</a></div><!-- If javascript is disabled -->
</noscript>

<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

if(isset($_POST))
{
	 //Some Settings
	$BigImageMaxSize 		= 200; //tamano maximo de la imagen
	$destino	= 'images/users/'; //destino de la imagen
	$Quality 				= 90;

	// check $_FILES['ImageFile'] array is not empty
	// "is_uploaded_file" Tells whether the file was uploaded via HTTP POST
	if(!isset($_FILES['ImageFile']) || !is_uploaded_file($_FILES['ImageFile']['tmp_name']))
	{
		//error si falla
		die('No se ha podido subir la imagen :(');
	}

	//datos imagen
	$nombreImagen = str_replace(' ','-',strtolower($_FILES['ImageFile']['name'])); 
	$tamanoImagen = $_FILES['ImageFile']['size'];
	$TempSrc      = $_FILES['ImageFile']['tmp_name']; // Tmp name of image file stored in PHP tmp folder
	$tipoImagen   = $_FILES['ImageFile']['type']; //Obtain file type, returns "image/png", image/jpeg, text/plain etc.

	//Let's use $tipoImagen variable to check wheather uploaded file is supported.
	//We use PHP SWITCH statement to check valid image format, PHP SWITCH is similar to IF/ELSE statements 
	//suitable if we want to compare the a variable with many different values
	switch(strtolower($tipoImagen))
	{
		case 'image/png':
			$CreatedImage =  imagecreatefrompng($_FILES['ImageFile']['tmp_name']);
			break;
		case 'image/gif':
			$CreatedImage =  imagecreatefromgif($_FILES['ImageFile']['tmp_name']);
			break;			
		case 'image/jpeg':
		case 'image/pjpeg':
			$CreatedImage = imagecreatefromjpeg($_FILES['ImageFile']['tmp_name']);
			break;
		default:
			die('Unsupported File!'); //output error and exit
	}
	
	//PHP getimagesize() function returns height-width from image file stored in PHP tmp folder.
	//Let's get first two values from image, width and height. list assign values to $CurWidth,$CurHeight
	list($CurWidth,$CurHeight)=getimagesize($TempSrc);

	//extension de la imagen
	$extencionImagen = substr($nombreImagen, strrpos($nombreImagen, '.'));
  	$extencionImagen = str_replace('.','',$extencionImagen);
	
	//remoeve la estencion del nombre de la imagen
	$nombreImagen = preg_replace("/\\.[^.\\s]{3,4}$/", "", $nombreImagen); 
	
	//nuevo nombre de la imagen con el id del usuario
	$nuevoNombreImagen = 'userId.'.$extencionImagen;


	$nombreImagenFinal = $destino.$nuevoNombreImagen; //Name for Big Image
	
	//Resize image to our Specified Size by calling resizeImage function.
	/*if(resizeImage($CurWidth,$CurHeight,$BigImageMaxSize,$nombreImagenFinal,$CreatedImage,$Quality,$tipoImagen))
	{
		
		echo '<table width="100%" border="0" cellpadding="4" cellspacing="0">';
		echo '<tr>';
		//echo '<td align="center"><img src="uploads/'.$ThumbPrefix.$nuevoNombreImagen.'" alt="Thumbnail"></td>';
		//echo '</tr><tr>';
		echo '<td align="center"><img src="uploads/'.$nuevoNombreImagen.'" alt="Resized Image"></td>';
		echo '</tr>';
		echo '</table>';

		
		// Insert info into database table!
		mysql_query("INSERT INTO myImageTable (ImageName, ThumbName, ImgPath)
		VALUES ($nombreImagenFinal, $thumb_DestRandImageName, 'uploads/')");
		

	}else{
		die('Error al redimensionar la imagen :('); //output error
	}*/

	move_uploaded_file($_FILES["ImageFile"]["tmp_name"], $nombreImagenFinal);
    
    echo "Stored in:" . $nombreImagenFinal;
}

?>