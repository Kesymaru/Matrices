
 <script> 
        $(document).ready(function() { 
			$('#UploadForm').on('submit', function(e) {
				e.preventDefault();
				$('#SubmitButton').attr('disabled', ''); // disable upload button
				//show uploading message
				$("#output").html('<div style="padding:10px"><img src="images/ajax-loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
				
				$(this).ajaxSubmit({
					target: '#output',
					success:  afterSuccess //call function after success
				});
				
			});
        }); 

		function afterSuccess()  { 
			$('#UploadForm').resetForm();  // reset form
			$('#SubmitButton').removeAttr('disabled'); //enable submit button

		} 
</script> 

<div align="center">
<form action="processupload.php" method="post" enctype="multipart/form-data" id="UploadForm">
<input name="ImageFile" type="file" />
<input type="submit"  id="SubmitButton" value="Upload" />
</form>
<div id="output"></div>
</div>


