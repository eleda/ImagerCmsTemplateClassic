<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="gallery.css" rel="stylesheet" type="text/css" />
<title>Imager galéria</title>
</head>

<body>

<?php

// GET CURRENT URL ROOT
function curURL() {
	$pageURL = 'http';
	$pageURL .= "://";
	if ($_SERVER ["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"];
	} else {
		$pageURL .= $_SERVER ["SERVER_NAME"];
	}
	$pageURL .= dirname ( $_SERVER ['PHP_SELF'] );
	return $pageURL;
}
// GET CURRENT PHP FILE WITH FULL PATH
function curpurl() {
	return curURL () . '/' . basename ( $_SERVER ['PHP_SELF'] );
}
function gallerymenu() {
	$dir = opendir ( "gallery" );
	$gals = array ();
	$gtitle = array ();
	$gdesc = array ();
	$crdate = array ();
	$pfile = array ();
	$pname = array ();
	$pdesc = array ();
	

	while ( ($fil = readdir ( $dir )) !== false ) {
		if ((strtolower ( substr ( $fil, strlen ( $fil ) - 4 ) ) == ".gal") && ($fil != ".") && ($fil != "..")) {
			array_push ( $gals, substr ( $fil, 0, strlen ( $fil ) - 4 ) );			
			$file = fopen ( "gallery/" . $fil, "r" ) or exit ( "Gallery file not found." );			
			$ex = 0;
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $gtitle, $mc );
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $gdesc, $mc );
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $crdate, $mc );			
			while ( ! feof ( $file ) ) {
				
				$mc = fgets ( $file );
				$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
				if (($mc == '---')) {
					
					$mc = fgets ( $file );
					$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
					if ($ex == 0) {
						array_push ( $pfile, $mc );
					}
					$mc = fgets ( $file );
					$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
					if ($ex == 0) {
						array_push ( $pname, $mc );
					}
					$mc = fgets ( $file );
					$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
					if ($ex == 0) {
						array_push ( $pdesc, $mc );
					}
					$ex ++;
				}
			}
			fclose ( $file );
		}
	}
	echo "<table width=200 border=0 cellspacing=0 cellpadding=0>";
	echo "      <tr>";
	$atab = isset ( $_GET ["gallery"] ) ? $_GET ["gallery"] : "";
	
	if ($atab == "") {
		$tabtype = "gtabactive";
	} else {
		$tabtype = "gtab";
	}
	
	echo "<td class='" . $tabtype . "' height=30><a href=" . curpurl () . ">Főoldal</a></td>";
	echo "      </tr>";
	
	for($i = 0; $i < count ( $gals ); $i ++) {
		if ($gals [$i] == $atab) {
			$tabtype = "gtabactive";
		} else {
			$tabtype = "gtab";
		}
		
		$ref = curpurl () . "?gallery=" . $gals [$i];
		
		echo "      <tr>";
		echo "<td class='" . $tabtype . "' height=30><em><a href=" . $ref . ">" . $gtitle [$i] . "</a></em></td>";
		echo "      </tr>";
	}
	echo "</table>";
}
function gallerylist() {
	$dir = opendir ( "gallery" );
	
	$gals = array ();
	$gtitle = array ();
	$gdesc = array ();
	$crdate = array ();
	$pfile = array ();
	$pname = array ();
	$pdesc = array ();
	
	while ( ($fil = readdir ( $dir )) !== false ) {
		if ((strtolower ( substr ( $fil, strlen ( $fil ) - 4 ) ) == ".gal") && ($fil != ".") && ($fil != "..")) {
			
			array_push ( $gals, substr ( $fil, 0, strlen ( $fil ) - 4 ) );
			
			$file = fopen ( "gallery/" . $fil, "r" ) or exit ( "Gallery file not found." );
			
			$ex = 0;
			
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $gtitle, $mc );
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $gdesc, $mc );
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $crdate, $mc );
			
			while ( ! feof ( $file ) ) {
				
				$mc = fgets ( $file );
				$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
				if (($mc == '---')) {
					
					$mc = fgets ( $file );
					$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
					if ($ex == 0) {
						array_push ( $pfile, $mc );
					}
					$mc = fgets ( $file );
					$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
					if ($ex == 0) {
						array_push ( $pname, $mc );
					}
					$mc = fgets ( $file );
					$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
					if ($ex == 0) {
						array_push ( $pdesc, $mc );
					}
					$ex ++;
				}
			}
			fclose ( $file );
		}
	}
	
	echo "<h1>Galéria - főoldal</h1>";
	echo "<p> Itt saját képek találhatók. Kattintson a megnézni kívánt tárra. Béta verzió.</a>";
	
	echo "<table width=600px border=0 cellspacing=0 cellpadding=3>";
	
	for($i = 0; $i < count ( $gals ); $i ++) {
		
		$ref = curpurl () . "?gallery=" . $gals [$i];
		
		echo "  <tr>";
		echo "   <td width=150><img src='gallery/" . $gals [$i] . "/" . $pfile [$i] . "' alt='picture of gallery' width='150' height='100' /></td>";
		echo "<td >";
		
		echo "<h3><a href=" . $ref . ">" . $gtitle [$i] . "</a></h3>";
		echo "<p>" . $gdesc [$i] . "</br>";
		echo $ex . " kép</br>";
		echo "Galéria létrehozva: " . $crdate [$i] . "</p>";
		
		echo "</td>";
		echo " </tr>";
	}
	echo "</table>";
}
function drawgallery($gal, $id) {
	
	// KÉPEK BETÖLTÉSE A GALÉRIA FÁJLBÓL.
	
	$file = fopen ( "gallery/" . $gal . ".gal", "r" ) or exit ( "Gallery file not found." );
	
	$pfile = array ();
	$pname = array ();
	$pdesc = array ();
	
	$gtitle = "Gallery";
	$gdesc = "";
	$crdate = "";
	
	$mc = fgets ( $file );
	$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$gtitle = $mc;
	$mc = fgets ( $file );
	$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$gdesc = $mc;
	$mc = fgets ( $file );
	$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$crdate = $mc;
	
	while ( ! feof ( $file ) ) {
		
		$mc = fgets ( $file );
		$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
		if ($mc == '---') {
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $pfile, $mc );
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $pname, $mc );
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $pdesc, $mc );
		}
	}
	fclose ( $file );
	
	echo "<h1>" . $gtitle . "</h1>";
	echo "<p>" . $gdesc . "</p>";
	echo "<p>Módosítva: " . $crdate . "</p>";
	echo "<p><a href=" . curpurl () . ">Vissza</a></p>";
	
	echo "<table width=800 border=0>";
	echo "  <tr>";
	echo "    <td>";
	echo "<p>";
	
	// BALRA NAVIGÁL
	if ($id > 0) {
		$lpic = curpurl () . "?gallery=" . $gal . "&id=" . ($id - 1);
		echo "<a href=" . $lpic . ">";
		echo "<img src=gallery/lef.gif width=30 height=400></a>";
	}
	
	$pfi = "gallery/" . $gal . "/" . $pfile [$id];
	echo "<img src='" . $pfi . "' width=500 height=400>";
	
	// JOBBRA NAVIGÁL
	if ($id < count ( $pfile ) - 1) {
		$rpic = curpurl () . "?gallery=" . $gal . "&id=" . ($id + 1);
		
		echo "<a href=" . $rpic . ">";
		echo "<img src=gallery/rig.gif width=30 height=400/></a>";
	}
	
	echo "</p>";
	
	echo "<p><b>" . $pname [$id] . "</b></p>";
	echo "<p>" . $pdesc [$id] . "</p>";
	
	echo "</td>";
	echo "  </tr>";
	echo "  <tr>";
	echo "    <td>";
	
	if (count ( $pfile ) > 0) {
		
		// echo "<ul>";
		// KÉPEK MEGJELENÍTÉSE ALUL
		echo "<div class='ilink'>";
		
		for($i = 0; $i < count ( $pfile ); $i ++) {
			
			$chpic = curpurl () . "?gallery=" . $gal . "&id=" . $i;			
			echo "<a href=" . $chpic . ">";
			echo "<img src=gallery/" . $gal . "/" . $pfile [$i] . " width='150' height='120' /></a>";
			
		}
		echo "</div>";
	}
	
	echo "</td>";
	echo "  </tr>";
	echo "</table>";
}

// ELŐKÉSZÍTÉS:

$sp ["gallery"] = isset ( $_GET ["gallery"] ) ? $_GET ["gallery"] : ""; // 7
$sp ["id"] = isset ( $_GET ["id"] ) ? $_GET ["id"] : ""; // 7

echo "<table width=1000px border=0 cellspacing=0 cellpadding=0>";
echo "  <tr>";
echo "  <td colspan=2>";
echo "</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td width=198 valign=top>";
echo "<p><img src='imagergal.jpg' alt='top' width=180 height=80/></p>";

gallerymenu ();
echo "</td>";

echo "    <td class='pag'> ";

if ($sp ["id"] == "") {
	$sp ["id"] = 0;
}

switch ($sp ["gallery"]) {
	case "" :
		gallerylist ();
		break;
	default :
		drawgallery ( $sp ["gallery"], $sp ["id"] );
}

echo "</td>";
echo "  </tr>";

echo "  <tr>";
echo "    <td colspan=2><p>2011. Imager | Béta verzió | ";
echo "<a href=" . curURL () . ">Vissza az Imager kezdőoldalára</a></p>";
echo "</td>";
echo "  </tr>";
echo "</table>";

?>

</body>
</html>
