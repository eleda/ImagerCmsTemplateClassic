<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Language" content="hu" />
<title>Imager</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="default.css" />
<link href="https://fonts.googleapis.com/css?family=OpenSans"
	rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Lora"
	rel="stylesheet" />

</head>

<body>
<?php
// $_SESSION[];
$view = isset ( $_GET ["view"] ) ? $_GET ["view"] : "";
$art_cat = isset ( $_GET ["category"] ) ? $_GET ["category"] : "";
$art_file = isset ( $_GET ["id"] ) ? $_GET ["id"] : "";
$copyright = "2009-2011, 2016 IMAGER, Elekes Dávid";

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
// NULL PREFIX FOR NUMBERS
function dupnum($nu) {
	if (strlen ( $nu ) == 1) {
		return "0" . $nu;
	}
}
// SET DATE
function setdat($dat) // paraméter: unix timestamp
{
	return idate ( "Y", $dat ) . "." . idate ( "m", $dat ) . "." . idate ( "d", $dat ) . ". " . idate ( "H", $dat ) . ":" . idate ( "i", $dat ) . ":" . idate ( "s", $dat );
}
// IS A NEW CONTENT?
function isnew($dat) // paraméter: unix timestamp
{
	// echo $dat-time();
	if (time () - $dat <= 1000000) {
		return true;
	} else {
		return false;
	}
}
// SHOW "NEW!!" SPAN.
function shownew($dat) {
	if (isnew ( $dat ) == true) {
		echo "<img src='" . curURL () . "/uj.png' border=0/>"; // kis kepecske
			                                                       // echo "új!";
	}
}
// DÁTUM FÜGGVÉNYEK VÉGE.
function newsbox($datatype, $alignment) {
	$extension = "";
	$directory = "";
	$name = "";
	$url_view_cat = "";
	$url_view_art = "";
	$url_phpfile = "index";
	
	// echo "Ez az adat kerül ide:". $datatype;
	switch ($datatype) {
		case 0 :
			$extension = ".txt";
			$directory = "news";
			$name = "Hírek";
			$url_view_cat = "articles";
			$url_view_art = "article";
			$url_phpfile = "index";
			break;
		case 1 :
			$extension = ".med";
			$directory = "media";
			$name = "Videók";
			$url_view_cat = "channel";
			$url_view_art = "media";
			$url_phpfile = "media";
			break;
		case 2 :
			$extension = ".dow";
			$directory = "downloads";
			$name = "Letöltések";
			$url_view_cat = "downloads";
			$url_view_art = "download";
			$url_phpfile = "downloads";
			break;
	}
	
	echo "<div>";
	echo "<h2>" . $name . "</h2>";
	
	// HIREK/////////////////////////////////////////////////////	
	$categs = array ();
	$categn = array ();
	
	// KATEGÓRIÁK ÖSSZEGYŰJTÉSE
	$dir = opendir ( $directory );
	while ( ($fil = readdir ( $dir )) !== false ) {
		
		if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".txt") && ($fil != ".") && ($fil != "..")) {
			$n = substr ( $fil, 0, strlen ( $fil ) - 4 );
			array_push ( $categs, $n );			
			$file = fopen ( $directory . "/" . $n . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $categn, $mcdat );
			fclose ( $file );
		}
	}
	
	echo "<div class='lis'>";
	
	// /KATEGÓRIÁN KÍVÜL ÖSSZES ELEM KIIRATÁSA
	for($i = 0; $i < count ( $categs ); $i ++) {
		$nid = array ();
		$nt = array ();
		$nd = array ();
		$np = array ();
		
		$dir = opendir ( $directory . "/" . $categs [$i] );
		while ( ($fil = readdir ( $dir )) !== false ) {
			
			if ((substr ( $fil, strlen ( $fil ) - 4 ) == $extension) && ($fil != ".") && ($fil != "..")) {
				
				$file = fopen ( $directory . "/" . $categs [$i] . "/" . $fil, "r" ) or exit ( "Nincs ilyen fájl." );
				
				$n = substr ( $fil, 0, strlen ( $fil ) - 4 );
				array_push ( $nid, $n );
				
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				array_push ( $nt, $mcdat );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				array_push ( $nd, getdat ( $mc ) );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				array_push ( $np, $mcdat );
				
				fclose ( $file );
			}
		}
		// RENDEZÉS A DÁTUM SZERINTI CSÖKKENŐ SORRENDBEN
		$rend = false;
		
		while ( $rend == false ) {
			$rend = true;
			
			for($j = 0; $j < count ( $nd ) - 1; $j ++) {
				if ($nd [$j + 1] > $nd [$j]) {
					$rend = false;
					$nnid = $nid [$j + 1];
					$nid [$j + 1] = $nid [$j];
					$nid [$j] = $nnid;
					$nnt = $nt [$j + 1];
					$nt [$j + 1] = $nt [$j];
					$nt [$j] = $nnt;
					$nnp = $np [$j + 1];
					$np [$j + 1] = $np [$j];
					$np [$j] = $nnp;
					$nnd = $nd [$j + 1];
					$nd [$j + 1] = $nd [$j];
					$nd [$j] = $nnd;
				}
			}
		}
		
		echo "<div class='lisle'>";
		
		echo "<img src='" . $directory . "/" . $categs [$i] . "/" . $np [0] . "' alt='6' width='68' height='58' class=indpic align='left' />";
		echo "</div>";
		
		$lz = curURL () . '/' . $url_phpfile . ".php?view=" . $url_view_art . "&category=" . $categs [$i] . "&id=" . $nid [0];
		echo "<div class='lisri'>";
		echo "<a href=" . $lz . "><h3>" . $nt [0] . " ";
		shownew ( $nd [0] );
		echo "</a></h3>";
		
		$c = 3;
		if (count ( $nid ) < 3) {
			$c = count ( $nid );
		} else {
			$c = 3;
		}
		echo "<p>";
		for($j = 1; $j < $c; $j ++) {
			$lz = curURL () . "/" . $url_phpfile . ".php?view=" . $url_view_art . "&category=" . $categs [$i] . "&id=" . $nid [$j];
			echo "<a href=" . $lz . ">" . $nt [$j] . " ";
			shownew ( $nd [$j] );
			echo "</a></br>";
		}
		echo "</p>";
		$lc = curURL () . "/" . $url_phpfile . ".php?view=" . $url_view_cat . "&category=" . $categs [$i];
		echo "          <p><i><a href=" . $lc . ">" . $categn [$i] . "</a></i></p>";
		echo "</div>";
	}	
	// ////////////HIR LISTA VÉGE
	
	echo "</div>";
	
	echo "    <p>&nbsp;</p>";
	
	echo "</div>";
}

// FŐOLDAL
function mainpage() {
	echo "<h1>Üdvözöljük az IMAGER weboldalon!</h1>";
	// A FŐOLDAL TARTALMA	
	echo "<div class='index'>";
	newsbox ( 0, 0 );
	newsbox ( 1, 0 );
	newsbox ( 2, 0 );
}
// SHOW A CATEGORY LIST
function showcategory($cat) {
	$file = fopen ( "news/" . $cat . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_desc = $mcdat;
	fclose ( $file );
	
	$a_title = array ();
	$a_id = array ();
	$a_author = array ();
	$a_picture = array ();
	$a_text = array ();
	$a_unixdate = array ();
	
	echo "<h1>" . $c_title . "</h1>";
	echo "<p>" . $c_desc . "</p>";
	
	$dir = opendir ( "news/" . $cat );
	
	while ( ($fil = readdir ( $dir )) !== false ) {		

		if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".txt") && ($fil != ".") && ($fil != "..")) {			
			array_push ( $a_id, substr ( $fil, 0, strlen ( $fil ) - 4 ) );			
			$file = fopen ( "news/" . $cat . "/" . $fil, "r" ) or exit ( "Nincs ilyen cikk." );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_title, $mcdat );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_unixdate, getdat ( $mc ) );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_author, $mcdat );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_picture, $mcdat );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $a_text, $mcdat );
			fclose ( $file );
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
				$n_author = $a_author [$i + 1];
				$a_author [$i + 1] = $a_author [$i];
				$a_author [$i] = $n_author;
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

	echo "<div class='lis'>";

	for($i = 0; $i < count ( $a_title ); $i ++) {
		$lin = curpurl () . "?view=article&category=" . $cat . "&id=" . $a_id [$i];
		echo "<div class='lisle'>";
		echo "<img src=news/" . $cat . "/" . $a_picture [$i] . " alt=pict width=80 height=60/>";
		echo "</div>";
		echo "<div>";
		echo "<h2><a href=" . $lin . ">" . $a_title [$i] . "</a></h2>";
		echo "    <p>" . "Hír készült: " . setdat ( $a_unixdate [$i] ) . "</p>";
		echo "</div>";
	}
	
	echo "</div>";
}
// CIKK MEGJELENÍTÉSE
function showarticle($cat, $id) {
	
	$file = fopen ( "news/" . $cat . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_desc = $mcdat;
	fclose ( $file );
	
	$file = fopen ( "news/" . $cat . "/" . $id . ".txt", "r" ) or exit ( "Nincs ilyen cikk." );	
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
	$a_author = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$a_picture = $mcdat;
	
	$clin = curpurl () . "?view=articles&category=" . $cat;	
	echo "<h1>" . $a_title . "</h1>";
	echo "<p>" . $uda . "<br />";
	echo "  kategória: <a href=" . $clin . ">" . $c_title . "</a> | szerző: " . $a_author . "</p>";	
	echo "<p class='tex'>";
	while ( ! feof ( $file ) ) {
		$mc = fgets ( $file );
		$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
		$a_text = $mcdat;
		echo $a_text;
	}
	echo "</p>";
	
	fclose ( $file );

	echo $a_text;
}
// SHOW MENU ON THE LEFT SIDE
function showmenu() {

	$dir = opendir ( getcwd () );	
	$file = fopen ( "menuitems.txt", "r" ) or exit ( "A navigációs menüt nem sikerült létrehozni" );	
	$iname = array ();
	$ipage = array ();
	$itype = array ();	
	$mc = fgets ( $file );
	while ( ! feof ( $file ) ) {
		$mc = fgets ( $file );
		$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
		$mcdata = substr ( $mcdat, 2 );		
		switch ($mcdat) {
			case "[item]" :
				array_push ( $itype, 0 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $iname, $mcdata );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $ipage, $mcdata );
				break;
			case "[articles]" :
				array_push ( $itype, 3 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $iname, $mcdata );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $ipage, $mcdata );
				break;
			case "[dcenter]" :
				array_push ( $itype, 4 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $iname, $mcdata );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $ipage, $mcdata );
				break;
			case "[mcenter]" :
				array_push ( $itype, 5 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $iname, $mcdata );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $ipage, $mcdata );
				break;
			case "[wholepage]" :
				array_push ( $itype, 2 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $iname, $mcdata );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $ipage, $mcdata );
				break;
			case "[header]" :
				array_push ( $itype, 1 );
				$mc = fgets ( $file );
				$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
				$mcdata = substr ( $mcdat, 2 );
				array_push ( $iname, $mcdata );
				array_push ( $ipage, "#" );
				break;
		}
	}	
	fclose ( $file );
	
	// MENÜ KIRAJZOLÁSA	
	echo "<div class='lb'>";
	for($i = 0; $i < count ( $iname ); $i ++) {
		echo "  <div>";
		switch ($itype [$i]) {
			case 0 :
				echo "    <div height='25' class='mnuitem'>";				
				$lin = curpurl () . "?page=" . $ipage [$i];
				echo "<a href=" . $lin . ">";
				echo $iname [$i];
				echo "</a>";
				break;
			case 2 :
				echo "    <div height='25' class='mnuitem'>";				
				$lin = curURL () . "/" . $ipage [$i];
				echo "<a href='" . $lin . "' target='_top'>";
				echo $iname [$i];
				echo "</a>";
				break;
			
			case 3 :
				echo "    <div height='25' class='mnuitem'>";				
				$lin = curpurl () . "?view=articles&category=" . $ipage [$i];
				echo "<a href='" . $lin . "'>";
				echo $iname [$i];
				echo "</a>";
				break;
			case 4 :
				echo "    <div height='25' class='mnuitem'>";
				$lin = curURL () . "/" . "downloads.php?view=downloads&category=" . $ipage [$i];
				echo "<a href='" . $lin . "'>";
				echo $iname [$i];
				echo "</a>";
				break;
			case 5 :
				echo "    <div height='25' class='mnuitem'>";
				$lin = curURL () . "/" . "media.php?view=channel&category=" . $ipage [$i];
				echo "<a href='" . $lin . "'>";
				echo $iname [$i];
				echo "</a>";
				break;
			case 1 :
				echo "    <div height='25' class='mnuheader'>";				
				echo $iname [$i];
				break;
		}		
		echo "</div>";
		echo "  </div>";
	}	
	echo "  <div>";
	echo "   <div height=100% valign='top'>";
	include ("aftermenu.html");
	echo "</div>";
	echo "  </div>";
	echo "</div>";
}

echo " <div class='ler'> ";
echo "       <div class='le'> ";
showmenu ();
echo "      </div> ";
echo "  <div class='ri'>   ";

// tartalom
switch ($view) {
	case "testindex" :
		mainpage ();
		break;
	case "article" :
		showarticle ( $art_cat, $art_file );
		break;
	case "articles" :
		showcategory ( $art_cat );
		break;
	default :
		$page = isset ( $_GET ["page"] ) ? $_GET ["page"] : "";
		if (($page == "main") || ($page == "")) {
			mainpage ();
		} else {
			if (file_exists ( $_GET ["page"] ) == 1) {
				include ($_GET ["page"]);
			} else {
				echo "<p class=war>Ilyen oldal nincs a tárhelyen.</p>";
				mainpage ();
			}
		}
}

echo "   </div> ";
echo "  </div> ";
echo " </div> ";

echo "<div class='ri'>";
echo "<p class='ri'>$copyright</p>";
echo "</div>";

?>
</body>
</html>
