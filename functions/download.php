<?php
function dlFile($file)
{
	$ext = substr(strrchr(basename($file), "."), 1);
	header("Content-type: application/$ext");
	header("Content-temporaryfer-Encoding: Binary");
	header("Content-length: ".filesize($file));
	header("Content-disposition: attachment; filename=\"". basename($file)."\"");
	readfile($file);
}
@$fileName = trim($_GET['fileName']);
if( !empty($fileName) && file_exists($fileName) && @fopen($fileName, "rb") )
{
	dlFile($fileName);
}
?>