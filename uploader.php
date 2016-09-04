<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imager Feltöltő</title>
<link href="form.css" rel="stylesheet" type="text/css" />
</head>


<body>
	<p>
		Feltöltőprogram az Imager weboldalhoz. Revízió:
		<!-- #BeginDate format:IS1 -->
		2011-05-30
		<!-- #EndDate -->
		<br /> Kérem várjon...
	</p>
<?php
$meth = isset ( $_POST ["method"] ) ? $_POST ["method"] : "";

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
function iso2ascii($str) {
	$arr = array (
			chr ( 32 ) => "_",
			"&" => "_",
			"?" => "_",
			"." => "_",
			"!" => "_",
			":" => "_",
			"," => "_",
			"á" => "a",
			"é" => "e",
			"í" => "i",
			"ó" => "o",
			"ö" => "o",
			"ő" => "o",
			"ú" => "u",
			"ü" => "u",
			"ű" => "u",
			"Á" => "a",
			"É" => "e",
			"Í" => "i",
			"Ó" => "o",
			"Ö" => "o",
			"Ő" => "o",
			"Ú" => "u",
			"Ü" => "u",
			"Ű" => "u",
			chr ( 161 ) => 'A',
			chr ( 163 ) => 'L',
			chr ( 165 ) => 'L',
			chr ( 166 ) => 'S',
			chr ( 169 ) => 'S',
			chr ( 170 ) => 'S',
			chr ( 171 ) => 'T',
			chr ( 172 ) => 'Z',
			chr ( 174 ) => 'Z',
			chr ( 175 ) => 'Z',
			chr ( 177 ) => 'a',
			chr ( 179 ) => 'l',
			chr ( 181 ) => 'l',
			chr ( 182 ) => 's',
			chr ( 185 ) => 's',
			chr ( 186 ) => 's',
			chr ( 187 ) => 't',
			chr ( 188 ) => 'z',
			chr ( 190 ) => 'z',
			chr ( 191 ) => 'z',
			chr ( 192 ) => 'R',
			chr ( 193 ) => 'A',
			chr ( 194 ) => 'A',
			chr ( 195 ) => 'A',
			chr ( 196 ) => 'A',
			chr ( 197 ) => 'L',
			chr ( 198 ) => 'C',
			chr ( 199 ) => 'C',
			chr ( 200 ) => 'C',
			chr ( 201 ) => 'E',
			chr ( 202 ) => 'E',
			chr ( 203 ) => 'E',
			chr ( 204 ) => 'E',
			chr ( 205 ) => 'I',
			chr ( 206 ) => 'I',
			chr ( 207 ) => 'D',
			chr ( 208 ) => 'D',
			chr ( 209 ) => 'N',
			chr ( 210 ) => 'N',
			chr ( 211 ) => 'O',
			chr ( 212 ) => 'O',
			chr ( 213 ) => 'O',
			chr ( 214 ) => 'O',
			chr ( 216 ) => 'R',
			chr ( 217 ) => 'U',
			chr ( 218 ) => 'U',
			chr ( 219 ) => 'U',
			chr ( 220 ) => 'U',
			chr ( 221 ) => 'Y',
			chr ( 222 ) => 'T',
			chr ( 223 ) => 's',
			chr ( 224 ) => 'r',
			chr ( 225 ) => 'a',
			chr ( 226 ) => 'a',
			chr ( 227 ) => 'a',
			chr ( 228 ) => 'a',
			chr ( 229 ) => 'l',
			chr ( 230 ) => 'c',
			chr ( 231 ) => 'c',
			chr ( 232 ) => 'c',
			chr ( 233 ) => 'e',
			chr ( 234 ) => 'e',
			chr ( 235 ) => 'e',
			chr ( 236 ) => 'e',
			chr ( 237 ) => 'i',
			chr ( 238 ) => 'i',
			chr ( 239 ) => 'd',
			chr ( 240 ) => 'd',
			chr ( 241 ) => 'n',
			chr ( 242 ) => 'n',
			chr ( 243 ) => 'o',
			chr ( 244 ) => 'o',
			chr ( 245 ) => 'o',
			chr ( 246 ) => 'o',
			chr ( 248 ) => 'r',
			chr ( 249 ) => 'u',
			chr ( 250 ) => 'u',
			chr ( 251 ) => 'u',
			chr ( 252 ) => 'u',
			chr ( 253 ) => 'y',
			chr ( 254 ) => 't' 
	);
	return strtr ( $str, $arr );
}
function fn($fi) {
	return strtolower ( iso2ascii ( utf8_decode ( $fi ) ) );
}
function uploadfile($fil, $todir) {
	// fil=ufile
	if ($_FILES [$fil] ["error"] > 0) {
		echo "Hiba történt: " . $_FILES [$fil] ["error"] . "<br />";
	} else {
		echo "Feltöltendő fájl: " . $_FILES [$fil] ["name"] . "<br />";
		echo "Mérete: " . ($_FILES [$fil] ["size"] / 1024) . " Kb<br />";
		// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		if (file_exists ( "upload/" . $_FILES [$fil] ["name"] )) {
			echo $_FILES [$fil] ["name"] . ": ez a fájl már egyszer fel lett töltve. </br>";
		} else {
			move_uploaded_file ( $_FILES [$fil] ["tmp_name"], $todir . "/" . $_FILES [$fil] ["name"] );
			echo "A fájl sikeresen feltöltődött.</br>";
		}
	}
}
function dat() {
	return date ( "Y-m-d-H-i-s" ); // javitva
}
function sdat() // rövid dátum
{
	return date ( "Y.m.d" );
}
function newgallery() {
	$picno = $_POST ["picno"];
	$des = $_POST ["des"];
	$gn = $_POST ["gn"];
	$gnn = fn ( $gn );
	$step = $_POST ["step"];
	$gf = "gallery/" . $gnn;
	
	if ($step == 0) {
		
		mkdir ( $gf );
		echo "<p>" . $gf . " mappa létrehozva. </p>";
		
		echo "<p>Képek feltöltése...</p>";
		
		$fns = array ();
		
		for($i = 1; $i <= $picno; $i ++) {
			$ud = "gallery/" . $gnn . "/" . $cat;
			array_push ( $fns, $_FILES ["p" . $i] ["name"] );
			uploadfile ( "p" . $i, $ud );
		}
		echo "<p>A képek fel lettek töltve.</p>";
		
		// ///MOST JÖN AZ EGYENKÉNTI CÍM ADÁS
		
		echo "</hr>";
		echo "<h3>Utolsó lépés: Képek címe és leírása</h3>";
		echo "<p class=info>Most adjon minden egyes képnek címet és egy rövid leírást. Ezek minden képhez külön meg lesznek jelenítve a Galériában.</p>";
		
		echo "<form id='form2' name='form2' method='post' action='uploader.php'>";
		
		for($i = 1; $i <= $picno; $i ++) {
			$filn = $fns [$i - 1];
			$dfiln = "gallery/" . $gnn . "/" . $filn;
			echo "  <p><img src='" . $dfiln . "' alt='6' width='145' height='100' border='2' align='left' /></p>";
			echo "  <p><strong>" . $i . ". kép</strong><br />";
			echo "  Fájlnév: " . $filn . "<br />";
			echo "  Cím: ";
			echo "  <label>";
			echo "  <input name='n1' type='text' id='n" . $i . "' size='50' />";
			echo "  </label>";
			echo "  <br />";
			echo "  Rövid leírás: ";
			echo "  <input name='d1' type='text' id='d" . $i . "' size='50' />";
			echo "  </p>";
			echo "<input type=hidden name='f" . $i . "' id='f" . $i . "' value='" . $filn . "'>";
		}
		
		echo "  <p>";
		echo "    <label>";
		echo "    <input type='submit' name='d' id='d' value='Kész!' />";
		echo "    </label>";
		echo "  </p>";
		echo "<input type=hidden name='method' id='method' value='gallery'>";
		echo "<input type=hidden name='picno' id='picno' value='" . $picno . "'>";
		echo "<input type=hidden name='des' id='des' value='" . $des . "'>";
		echo "<input type=hidden name='gn' id='gn' value='" . $gn . "'>";
		echo "<input type=hidden name='step' id='step' value='1'>";
		echo "</form>";
	} elseif ($step == 1) {
		$f = "gallery/" . $gnn . ".gal";
		$file = fopen ( $f, "w" );
		echo fwrite ( $file, $gn . "\r\n" );
		echo fwrite ( $file, $des . "\r\n" );
		echo fwrite ( $file, sdat () . "\r\n" );
		
		for($i = 1; $i <= $picno; $i ++) {
			echo fwrite ( $file, "---" . "\r\n" );
			echo fwrite ( $file, $_POST ["f" . $i] . "\r\n" );
			echo fwrite ( $file, $_POST ["n" . $i - 1] . "\r\n" );
			echo fwrite ( $file, $_POST ["d" . $i - 1] . "\r\n" );
		}
		
		fclose ( $file );
		
		echo "<p class=info>Minden elkészült!</p>";
	}
}
function newdownload() {
	echo "<h2>Új letöltés készítése...</h2>";
	// $fil=$_POST["fajl"];
	$tit = $_POST ["cim"];
	$cat = $_POST ["kat"];
	$pic = $_POST ["kep"];
	$tex = $_POST ["szoveg"];
	$filename = $_POST ["ufile"];
	// echo "<p>Ez lenne a file: ".$filename."</p>";
	
	$fil = strtolower ( iso2ascii ( $tit ) );
	$f = "downloads/" . $cat . "/" . $fil . ".dow";
	$ud = "downloads/" . $cat;
	// uploadfile($ud);
	echo "<p>Fájl készítése: " . $f . "</p>";
	
	$file = fopen ( $f, "w" );
	echo fwrite ( $file, $tit . "\r\n" );
	echo fwrite ( $file, dat () . "\r\n" );
	echo fwrite ( $file, $filename . "\r\n" );
	$pict = $pic;
	echo fwrite ( $file, $pict . "\r\n" );
	echo fwrite ( $file, $tex . "\r\n" );
	fclose ( $file );
	
	echo "<p class='info'>Kész!<p>";
}
function newmedia() {
	echo "<h2>Új médiaelem készítése...</h2>";
	// $fil=$_POST["fajl"];
	$tit = $_POST ["cim"];
	$cat = $_POST ["kat"];
	$pic = $_POST ["kep"];
	$tex = $_POST ["szoveg"];
	$filename = $_POST ["ufile"];
	// echo "<p>Ez lenne a file: ".$filename."</p>";
	
	$fil = strtolower ( iso2ascii ( $tit ) );
	$f = "media/" . $cat . "/" . $fil . ".med";
	$ud = "media/" . $cat;
	// uploadfile($ud);
	echo "<p>Fájl készítése: " . $f . "</p>";
	
	try {
		$file = fopen ( $f, "w" );
		echo fwrite ( $file, $tit . "\r\n" );
		echo fwrite ( $file, dat () . "\r\n" );
		echo fwrite ( $file, $filename . "\r\n" );
		$pict = $pic;
		echo fwrite ( $file, $pict . "\r\n" );
		echo fwrite ( $file, $tex . "\r\n" );
		fclose ( $file );
		echo "<p class='info'>Kész!<p>";
	} catch ( Exception $e ) {
		echo "<p class='info'>Fájl írási hiba: $e</p>";
	}
}
function newarticle() {
	echo "<h2>Új cikk készítése...</h2>";
	// $fil=$_POST["fajl"];
	$tit = $_POST ["cim"];
	$cat = $_POST ["kat"];
	$pic = $_POST ["kep"];
	$aut = $_POST ["szerzo"];
	$tex = $_POST ["szoveg"];
	
	$fil = fn ( $tit );
	$f = "news/" . $cat . "/" . $fil . ".txt";
	echo $f;
	
	try {
		$file = fopen ( $f, "w" );
		echo fwrite ( $file, $tit . "\r\n" );
		echo fwrite ( $file, dat () . "\r\n" );
		echo fwrite ( $file, $aut . "\r\n" );
		$pict = $pic;
		echo fwrite ( $file, $pict . "\r\n" );
		echo fwrite ( $file, $tex . "\r\n" );
		fclose ( $file );
		echo "Kész!";
	} catch ( Exception $e ) {
		echo "<p class='info'>Fájl írási hiba: $e</p>";
	}
}

switch ($meth) {
	case "article" :
		newarticle ();
		break;
	case "download" :
		newdownload ();
		break;
	case "media" :
		newmedia ();
		break;
	case "gallery" :
		newgallery ();
		break;
	default :
		echo "Feltöltési hiba.";
}

echo "<p><a href=" . curURL () . "/upload.php" . ">Új feltöltés</a></p>";
echo "<p><a href=" . curURL () . "/index.php" . ">A főoldalra</a></p>";

?></body>
</html>
