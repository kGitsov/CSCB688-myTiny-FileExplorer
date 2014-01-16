<?php
$self_dir = basename(__FILE__);
@$get_dir = $_GET['dir'];
$home = str_replace( "\\", "/", dirname(__FILE__) );

if( !empty($_GET['dir']) && @opendir($get_dir) )
{
	$dir = str_replace( "\\", "/", $get_dir );
}
else{ $dir = $home;}

@$fileName = trim($_POST['fileName']);
@$content = trim($_POST['content']);

function loop_dir($dir)
{
	global $self_dir, $fileName, $content, $subdirs, $refresh, $dir_up, $all_dir, $unread_dir, $all_file, $unread_file;
	
	//check if directory can be open
	if ($handle = @opendir($dir))
	{
		while ( false != ($file = readdir($handle)) )
		{
			$full_path = str_replace( "//", "/", $dir . "/" . $file);
			
			if( $file == "." )
			{
				$refresh = "<tr bgcolor=\"#F6F6F6\">
				<td align=\"left\"><img src=\"./type_images/refresh.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
				<a href=\"index.php?dir=$dir\">Refresh</a></td>
				<td align=\"center\"></td>
				<td align=\"left\"></td>
				<td align=\"left\"></td></tr>\r\n";
			}
			elseif( $file == ".." )
			{
				$up_lvl = str_replace( "\\", "/", dirname($dir . "..") );
				$dir_up = "<tr bgcolor=\"#FFFFFF\">
				<td align=\"left\"><img src=\"./type_images/back.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
				<a href=\"index.php?dir=$up_lvl\">Up one level</a></td>
				<td align=\"center\"></td>
				<td align=\"left\"></td>
				<td align=\"left\"></td></tr>\r\n";
			}
			elseif( is_dir($full_path) )
			{			
				$perm = substr(sprintf('%o', @fileperms("$full_path")), -3);
				$time_mod = date("Y M d h:i A" ,filemtime($full_path));
				if( @opendir($full_path) )
				{
					if( $subdirs == 1 )
					{
						loop_dir($full_path);
					}					
					if( !empty($fileName) )
					{
						if( stristr($file, $fileName) )
						{
							$all_dir[] .= "<td align=\"left\"><img src=\"./icons/folder.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
							<a href=\"index.php?dir=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"center\">-</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
						elseif( stristr($file, $fileName) )
						{
							$all_dir[] .= "<td align=\"left\"><img src=\"./icons/folder.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
							<a href=\"index.php?dir=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"center\">-</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
					}
					else if( empty($content) )
					{
						$all_dir[] .= "<td align=\"left\"><img src=\"./icons/folder.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
						<a href=\"index.php?dir=$full_path\" title=\"$full_path\">" . $file . "</a></td>
						<td align=\"center\">-</td>
						<td align=\"center\">$perm</td>
						<td align=\"left\">$time_mod</td>";
					}					
				}
				else
				{ 
					$unread_dir[] .= "<td align=\"left\"><img src=\"./icons/folder2.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" /> " 
					. $file . "</td>
					<td align=\"center\">-</td>
					<td align=\"center\">$perm</td>
					<td align=\"left\">$time_mod</td>";
				}				
			}
			else
			{
				@$size = filesize($full_path);				
				if( $size >= 0 && $size < 1024 )
				{
					$size = $size . " B";
				}
				elseif( $size >= 1024 && $size < 1048576 )
				{
					$size = round(($size/1024),2) . " KB";
				}
				else if( $size >= 1048576 && $size < 1073741824 )
				{
					$size = round(($size/1048576),2) . " MB";
				}
				else if( $size >= 1073741824 )
				{
					$size = round(($size/1073741824),2) . " GB";
				}
				else{ $size = "--";}	
				
				$perm = substr(sprintf('%o', @fileperms("$full_path")), -3);
				@$time_mod = date("Y M d h:i A" ,filemtime($full_path));			
				
				//set icons
				$ext = substr(strrchr($file, "."), 1);
				if( file_exists( "./icons/" . $ext . ".png") )
				{
					$icon_normal = "./icons/" . $ext . ".png";
				}
				else{ $icon_normal = "./icons/file.png";}
				
				if( file_exists( "./icons/" . $ext . "2.png") )
				{
					$icon_unview = "./icons/" . $ext . "2.png";
				}
				else{ $icon_unview = "./icons/file2.png";}
				
				//check if the file can be read
				if( @fopen($full_path, "rb") )
				{
					if( !empty($content) )
					{
						$file_data = file_get_contents($full_path);
					}
					if( !empty($fileName) )
					{
						if( stristr($file, $fileName) )
						{
							$all_file[] .= "\n<!--$file!-->
							<td align=\"left\"><img src=\"$icon_normal\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
							<a href=\"index.php?fileName=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"right\">$size</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}
					}
					elseif( !empty($content) )
					{ 						
						if( stristr($file_data, $content) )
						{
							//store all files in array
							$all_file[] .= "\n<!--$file!-->
							<td align=\"left\"><img src=\"$icon_normal\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
							<a href=\"index.php?fileName=$full_path\" title=\"$full_path\">" . $file . "</a></td>
							<td align=\"right\">$size</td>
							<td align=\"center\">$perm</td>
							<td align=\"left\">$time_mod</td>";
						}				
					}
					elseif( empty($fileName) )
					{						
						//store all files in array
						$all_file[] .= "\n<!--$file!-->
						<td align=\"left\"><img src=\"$icon_normal\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" />
						<a href=\"index.php?fileName=$full_path\" title=\"$full_path\">" . $file . "</a></td>
						<td align=\"right\">$size</td>
						<td align=\"center\">$perm</td>
						<td align=\"left\">$time_mod</td>
						<td align=\"left\">
						<form action=\"functions/delete.php?path=$full_path\" method=\"post\" >
							<input type=\"submit\" name=\"submit\" id=\"searchbtn\" value=\"del\"/>				
						</form></td>";
						
					}
				}
				else
				{
					//file cannot be read
					$unread_file[] .= "\n<!--$file!-->
					<td align=\"left\"><img src=\"$icon_unview\" width=\"16\" height=\"16\" border=\"0\" alt=\"\" /> "
					. $file . "</td>
					<td align=\"right\">$size</td>
					<td align=\"center\">$perm</td>
					<td align=\"left\">$time_mod</td>";
				}
			}
			@$file_count++;
		}
		@natcasesort($all_dir);
		@natcasesort($unread_dir);
		@natcasesort($all_file);
		@natcasesort($unread_file);
	}
}
loop_dir($dir);
	//merge all the files and dirs which in in array
	$arrs = array();
	
	$arrs[] = $all_dir;
	$arrs[] = $unread_dir;
	$arrs[] = $all_file;
	$arrs[] = $unread_file;
	
	$all_files = array();
	
	foreach($arrs as $arr)
	{
		if(is_array($arr))
		{
			$all_files = array_merge($all_files,$arr);
		}
	}
	$count = @count($all_files);
	$body = $dir_up . $refresh;
	if( $count > 0 )
	{
		$bg = "#F6F6F6";
		for( $i = 0; $i < $count; $i++ )
		{
			if( $bg == "#FFFFFF" )
			{
				$bg = "#F6F6F6";
			}
			else
			{
				$bg = "#FFFFFF";
			}
			$body .= "<tr bgcolor=\"$bg\">" . $all_files[$i] . "</tr>\r\n";
		}
	}
	else
	{
		$body .= "<tr bgcolor=\"#FFFFFF\">
			<td colspan=\"4\" align=\"center\" valign=\"middle\" height=\"32\">- No Files Found -</td>
		</tr>\r\n";
	}	
?>