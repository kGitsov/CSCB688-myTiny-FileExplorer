<?php

function parseString($str)
{
	$temporary = array( "&" => "&amp;", '"' => "&quot;", "<" => "&lt;", ">" => "&gt;" );	
	return strtr(stripslashes($str), $temporary);		
}
?>
