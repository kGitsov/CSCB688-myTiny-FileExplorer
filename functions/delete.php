<?php
	$dir_folder=dirname($_GET["path"]);
	unlink($_GET["path"]);
	header("Location: ../index.php?dir=$dir_folder");
?>