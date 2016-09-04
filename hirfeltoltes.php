<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hirfeltoltest</title>
</head>

<body>
	<h1>Hír feltöltése az IMAGER-be</h1>
	<form id="form1" name="form1" method="post" action="">
		<label>Fájlnév (kiterjesztés nélkül)</label> <input type="text"
			name="fajl" id="fajl" /> <br /> <label>Hír címe</label> <input
			type="text" name="cim" id="cim" /> </label>
		<p>
			<label>Kategória <select name="kat" id="kat">
    
    <?php
				$dir = opendir ( "news" );
				
				while ( ($fil = readdir ( $dir )) !== false ) {
					
					if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".txt") && ($fil != ".") && ($fil != "..")) {
						$fin = substr ( $fil, 0, strlen ( $fil ) - 4 );
						echo "<option value='" . $fin . "'>" . $fin . "</option>";
					}
				}
				
				?>
    
   
    </select>
			</label>
		</p>
		<p>
			<label>Szerző: <input type="text" name="szerzo" id="szerzo" />
			</label>
		</p>
		<p>
			<label>Szöveg <textarea name="szoveg" id="szoveg" cols="100"
					rows="15"></textarea>
			</label>
		</p>
		<p>Mindent kötelező kitölteni.</p>
		<p>
			<label> <input type="submit" name="ok" id="ok" value="Feltöltés!" />
			</label>
		</p>
		<p>&nbsp;</p>
	</form>

	<p>&nbsp;</p>
</body>
</html>
