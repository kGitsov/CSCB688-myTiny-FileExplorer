<?php include "functions/parse_strings.php";?>
<?php include "functions/download.php"; ?>
<?php include "functions/main.php";?>
<?php include "functions/upload_file.php";?>
<?php //include "functions/delete.php";?>

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>myTiny File Explorer project</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script language="javascript" type="text/javascript" src="script.js"></script>
	</head>
	<body>
	<div id="wrapper">
		<div id="header">
			<h2>myTiny file explorer project</h2>
		</div>
		<div id="navigation">
			<form action="index.php" method="get">
				<div id="label">Path: </div>
				<input type="text" name="dir" id="input" value="<?php echo $dir; ?>" size="130" maxlength="500" onfocus="select()"/>
				&nbsp;
				<input type="image" src="./type_images/go.png" width="16" height="16" style="vertical-align:bottom;" title="Type an address and go."/>
				&nbsp;
				<a href="<?php echo "?dir=".$home; ?>">
					<img src="./type_images/home.png" width="16" height="16" border="0" title="Go back to &quot;<?php echo $home; ?>&quot;" alt=""/>
				</a>&nbsp;
			</form><br/>			
			<div id="searchbar">
				<form method="post" action="index.php?dir=<?php echo $dir;?>">
					Files/dirs name :
					<input type="text" name="fileName" value="<?php echo @$fileName_value; ?>" size="20" id="input"/>
					Part of file content :
					<input type="text" name="content" value="<?php echo @$content_value; ?>" size="20" id="input"/>
					Search subdirs :
					<input type="checkbox" name="dir" checked />
					<input type="submit" id="searchbtn" value="Search"/>
				</form>
			</div>			
			<div id="upload_box">
				<form action="index.php?dir=<?php echo $dir; ?>" method="post" enctype="multipart/form-data">
					<div id="label">Upload File: </div>
					<input type="file" name="files" id="files">
					<input type="submit" name="submit" id="searchbtn" value="Submit"/>
				</form>
			</div>
		</div>
		<div id="content">		
			<table id="tblcntnt" align="right">									
				<tr id="trcntnt">				
					<td align="left">Name</td>
					<td align="center" width="80">Size</td>
					<td align="center" width="80">Permission</td>
					<td align="center" width="150">Date Modified</td>
					<td align="center" width="35">Actions</td>
				</tr>
				<?php echo $body; ?>
			</table>
		</div>
		<div id="footer">
			CSCB688 - myTiny file explorer project
		</div>
	</div>
	</body>
</html>