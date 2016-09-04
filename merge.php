<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="form.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<h2>Maxor körlevelező szolgáltatás</h2>
	<form id="form1" name="form1" method="post" action="msender.php">
		<p>
			<label for="typ">Levél típusa</label> <select name="typ" id="typ">
				<option>Egyéni szöveg</option>
				<option>Beíratkozási üdvözlő levél</option>
				<option>Kiiratkozási elköszönő levél</option>
			</select>
		</p>
		<p>Esetleges szöveg:</p>
		<p>
			<label for="tx">Szöveg</label>
			<textarea name="tx" id="tx" cols="45" rows="5"></textarea>
		</p>
		<p>
			<label for="tol[]">Kinek megy:</label> <select name="tol[]" size="10"
				multiple="multiple" id="tol[]">
    
    <?php
				$file = fopen ( "merge.txt", "r" );
				while ( ! feof ( $file ) ) {
					$nam = fgets ( $file );
					$addr = fgets ( $file );
					
					echo "<option value='" . $addr . "'>" . $nam . "(" . $addr . ")</option>";
				}
				fclose ( $file );
				?>    
    </select>
		</p>
		<p>
			<input type="submit" name="button" id="button" value="Kész" />
		</p>
	</form>
	<p>&nbsp;</p>
</body>
</html>
