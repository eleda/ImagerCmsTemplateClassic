<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Language" content="hu" />
<title>Imager Letöltőközpont</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="default.css" />
</head>

<body>

<?php 
$view = $_GET ["view"];
$art_cat = $_GET ["category"];
$art_file = isset ( $_GET ["id"] ) ? $_GET ["id"] : "";
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

// DÁTUM FÜGGVÉNYEK - JAVÍTVA!
function getdat($dat) // paraméter pl: 2011-01-27-11-56-00
{
	$y = substr ( $dat, 0, 4 );
	$m = substr ( $dat, 5, 2 );
	$d = substr ( $dat, 8, 2 );
	$h = substr ( $dat, 11, 2 );
	$mi = substr ( $dat, 14, 2 );
	if (strlen ( $dat ) == 19) {
		$se = ( int ) (substr ( $dat, 17, 2 ));
	} else {
		$se = 0;
	}
	
	$da = mktime ( $h, $mi, $se, $m, $d, $y );
	
	return $da;
}
function dupnum($nu) {
	if (strlen ( $nu ) == 1) {
		return "0" . $nu;
	}
}
function setdat($dat) // paraméter: unix timestamp
{
	return idate ( "Y", $dat ) . "." . idate ( "m", $dat ) . "." . idate ( "d", $dat ) . ". " . idate ( "H", $dat ) . ":" . idate ( "i", $dat ) . ":" . idate ( "s", $dat );
}
function isnew($dat) // paraméter: unix timestamp
{
	// echo $dat-time();
	if (time () - $dat <= 1000000) {
		return true;
	} else {
		return false;
	}
	// return true;
}
function shownew($dat) {
	if (isnew ( $dat ) == true) {
		echo "<img src='" . curURL () . "/uj.png' border=0> "; // kis kepecske
	}
}
// DÁTUM FÜGGVÉNYEK VÉGE.
function drawicon() {
	echo "<img src='" . curURL () . "/pictures/window.gif' border=0/>"; // kis kepecske
}
function showcategory($cat) {
	$file = fopen ( "downloads/" . $cat . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_desc = $mcdat;
	
	echo "\n";
	echo "<h1>" . $c_title . "</h1>\n";
	echo "<p>" . $c_desc . "</p>\n";
	
	// adatok kigyűjtése
	$a_title = array ();
	$a_id = array ();
	// $a_date=array();
	$a_file = array ();
	$a_picture = array ();
	$a_text = array ();
	$a_unixdate = array ();
	
	$dir = opendir ( "downloads/" . $cat );
	
	while ( ($fil = readdir ( $dir )) !== false ) {
		
		if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".dow") && ($fil != ".") && ($fil != "..")) {
			
			array_push ( $a_id, substr ( $fil, 0, strlen ( $fil ) - 4 ) );
			
			$ffile = fopen ( "downloads/" . $cat . "/" . $fil, "r" ) or exit ( "Nincs ilyen cikk." );
			$mc = fgets ( $ffile );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_title, $mcdat );
			$mc = fgets ( $ffile );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_unixdate, getdat ( $mc ) );
			$mc = fgets ( $ffile );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_file, $mcdat );
			$mc = fgets ( $ffile );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_picture, $mcdat );
			
			$mc = fgets ( $ffile );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_text, $mcdat );
			fclose ( $ffile );
		}
	}
	
	$rend = false;
	
	while ( $rend == false ) {
		$rend = true;
		
		for($i = 0; $i < count ( $a_unixdate ) - 1; $i ++) {
			if ($a_unixdate [$i + 1] > $a_unixdate [$i]) {
				$rend = false;
				$n_id = $a_id [$i + 1];
				$a_id [$i + 1] = $a_id [$i];
				$a_id [$i] = $n_id;
				$n_title = $a_title [$i + 1];
				$a_title [$i + 1] = $a_title [$i];
				$a_title [$i] = $n_title;
				$n_file = $a_file [$i + 1];
				$a_file [$i + 1] = $a_file [$i];
				$a_file [$i] = $n_file;
				$n_picture = $a_picture [$i + 1];
				$a_picture [$i + 1] = $a_picture [$i];
				$a_picture [$i] = $n_picture;
				$n_text = $a_text [$i + 1];
				$a_text [$i + 1] = $a_text [$i];
				$a_text [$i] = $n_text;
				$n_unixdate = $a_unixdate [$i + 1];
				$a_unixdate [$i + 1] = $a_unixdate [$i];
				$a_unixdate [$i] = $n_unixdate;
			}
		}
	}
	
	// ÍRÁS
	
	echo "<table width=600 cellspacing=0 cellpadding=0 class=medlist>\n";
	for($i = 0; $i < count ( $a_title ); $i ++) {
		$lin = curpurl () . "?view=download&category=" . $cat . "&id=" . $a_id [$i];
		// $lin="#";
		$fullfilename = "downloads/" . $cat . "/" . $a_file [$i];
		$fsize = filsize ( $fullfilename );
		echo "<tr>\n";
		echo "<td><img src='downloads/" . $cat . "/" . $a_picture [$i] . "' alt='kategoriakep' width=80 height=60/></td> \n";
		echo "<td> \n <h2>" . $a_title [$i] . " ";
		shownew ( $a_unixdate [$i] );
		echo "</h2>\n";
		echo "<h3>Fájl: <a href=" . $fullfilename . ">" . $a_file [$i] . " (" . $fsize . ")</a> | <a href='" . $lin . "'>Letöltés részletei</a></h3>\n";
		echo "<p>" . "Dátuma: " . setdat ( filectime ( $fullfilename ) ) . "</p>";
		// echo " <p>"."Feltöltve: ". setdat($a_unixdate[$i]) ."</p>";
		echo "</td>\n";
		echo "</tr>\n";
	}
	
	// echo $fil;
	echo "</table>\n";
	
	while ( ! feof ( $file ) ) {
		$mc = fgets ( $file );
		$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
		$a_text = $mcdat;
		echo $a_text;
	}
	
	fclose ( $file );
}
function filsize($fname) {
	$fs = filesize ( $fname );
	$mag = 0;
	
	while ( $fs > 1024 ) {
		$fs /= 1024;
		$fs = round ( $fs );
		$mag ++;
	}
	
	switch ($mag) {
		case 0 :
			return $fs . " byte";
			break;
		case 1 :
			return $fs . " KB";
			break;
		case 2 :
			return $fs . " MB";
			break;
		case 3 :
			return $fs . " GB";
			break;
		case 4 :
			return $fs . " TB";
			break;
		default :
			return $fs;
	}
}

//
// CIKK MEGJELENÍTÉSE
//
function showdownload($cat, $id) {
	
	$file = fopen ( "downloads/" . $cat . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_desc = $mcdat;
	fclose ( $file );
	
	$file = fopen ( "downloads/" . $cat . "/" . $id . ".dow", "r" ) or exit ( "Nincs ilyen cikk." );
	
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$a_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$a_date = $mcdat;
	$da = getdat ( $a_date );
	$uda = setdat ( $da );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$a_file = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$a_picture = $mcdat;
	
	$clin = curpurl () . "?view=downloads&category=" . $cat;
	
	$fullfilename = "downloads/" . $cat . "/" . $a_file;
	$fsize = filsize ( $fullfilename );
	
	// $url= curpurl() ."/". $fullfilename;
	$url = curURL () . "/" . $fullfilename;
	echo "    <h1>" . $a_title . "</h1>";
	echo "    <h2>Fájl: <a href=" . $fullfilename . ">";
	drawicon ();
	echo " " . $a_file . "</a></h2>\n";
	echo "<p>Kategória: <a href='" . $clin . "'>" . $c_title . "</a></br>";
	echo "    URL: <a href=" . $url . ">" . $url . "</a></br>";
	echo "    " . "Mérete: " . $fsize . " (" . filesize ( $fullfilename ) . " bájt)</br>";
	echo "    " . "Dátuma: " . setdat ( filectime ( $fullfilename ) ) . "</br>";
	echo "    " . "Feltöltve: " . $uda . "</br>";
	echo "<p></hr></p>";
	
	while ( ! feof ( $file ) ) {
		$mc = fgets ( $file );
		$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
		$a_text = $mcdat;
		echo $a_text;
	}
	
	fclose ( $file );
	
	echo $a_text;
}

echo "<table width='1200px'  cellspacing=0 cellpadding=0>\n";
echo "<tr height=100px>\n";
echo "<td>\n";

if (file_exists ( "downloads/" . $art_cat . "/banner.jpg" )) {
	echo "<img src='downloads/" . $art_cat . "/banner.jpg' alt=banner width=1200 height=110 />\n";
} else {
	echo "<h1>Imager letöltőközpont BÉTA</h1>\n";
}

echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td valign=top>\n";

echo "<table width='100%' border='0' height='100%'>\n";
echo "<tr>\n";
echo "<td valign='top' class='cont'>\n";

switch ($view) {
	case "download" :
		showdownload ( $art_cat, $art_file );
		break;
	case "downloads" :
		showcategory ( $art_cat );
		break;
	default :
		if (file_exists ( $_GET ["page"] ) == 1) {
			include ($_GET ["page"]);
		} else {
			echo "<p>Letöltőközpont</p>";
		}
}

echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";
$backurl = curURL ();
echo "<p>2011., 2016. IMAGER, Elekes Dávid | <a href=" . $backurl . ">Vissza a főoldalhoz</a></p>\n";
?>

</body>
</html>
