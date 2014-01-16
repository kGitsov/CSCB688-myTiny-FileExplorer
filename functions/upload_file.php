<?php
	/*still not working and wondering why*/
	if (@$_FILES["files"]["tmp_name"]!=null){
		@$uploads_dir = $_GET["dir"];
		if (@$_FILES["files"]["error"] > 0)
		{
			echo "Error: " . $_FILES["files"]["error"] . "<br>";
		}
		else
		{
			if (@$error == UPLOAD_ERR_OK) 
			{
				@$tmp_name = $_FILES["files"]["tmp_name"];
				@$name = $_FILES["files"]["name"];
				move_uploaded_file(@$tmp_name, "$uploads_dir/$name");
			}
		}
	}
?>