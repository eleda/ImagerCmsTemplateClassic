<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Language" content="hu" />
<title>Imager Médiatár</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="media.css" />

<style type="text/css">
.fadeSome {
	opacity: 0.30;
	filter: alpha(opacity = 30);
	-moz-opacity: 30%;
}

.fadeLots {
	opacity: 0.50;
	filter: alpha(opacity = 50);
	-moz-opacity: 0.5;
}

.fadeCompletely {
	opacity: 0.0;
	filter: alpha(opacity = 0);
	-moz-opacity: 0.0;
}

#silverlightControlHost {
	
}
</style>
<script type="text/javascript">
//SILVERLIGHT LEJÁTSZÓHOZ
        function onSilverlightError(sender, args) {

            var appSource = "";
            if (sender != null && sender != 0) {
                appSource = sender.getHost().Source;
            }
            var errorType = args.ErrorType;
            var iErrorCode = args.ErrorCode;

            var errMsg = "Unhandled Error in Silverlight Application " + appSource + "\n";

            errMsg += "Code: " + iErrorCode + "    \n";
            errMsg += "Category: " + errorType + "       \n";
            errMsg += "Message: " + args.ErrorMessage + "     \n";

            if (errorType == "ParserError") {
                errMsg += "File: " + args.xamlFile + "     \n";
                errMsg += "Line: " + args.lineNumber + "     \n";
                errMsg += "Position: " + args.charPosition + "     \n";
            }
            else if (errorType == "RuntimeError") {
                if (args.lineNumber != 0) {
                    errMsg += "Line: " + args.lineNumber + "     \n";
                    errMsg += "Position: " + args.charPosition + "     \n";
                }
                errMsg += "MethodName: " + args.methodName + "     \n";
            }

            throw new Error(errMsg);
        }

        function highlightDownloadArea(fOn) {
            document.getElementById("overlay").className = (fOn) ? "fadeSome" : "fadeLots";            
        }

	function CloseWindow()
	{
	    window.close();
	}
   </script>
</head>
<body>



<?php 
// $_SESSION[];
$view = $_GET ["view"];
$art_cat = $_GET ["category"];
$art_file = isset ( $_GET ["id"] ) ? $_GET ["id"] : "";
function curURL() {
	$pageURL = 'http';
	// if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER ["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"];
	} else {
		$pageURL .= $_SERVER ["SERVER_NAME"];
	}
	return "";
	// return $pageURL;
}
function curpurl() {
	return "";
	// return curURL() . $_SERVER["SCRIPT_NAME"];
}
function downloadbutton($lnk) {
	echo "<a href=" . $lnk . "><img src=" . curURL () . "/dload1.png alt=Letöltések name=dload  class=nopicborder border=0/></a>";
}

// CIKK KATEGÓRIA MUTATÁSA

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
}
function shownew($dat) {
	if (isnew ( $dat ) == true) {
		echo "<img src=" . curURL () . "/uj.png border=0/> "; // kis kepecske
	}
}
// DÁTUM FÜGGVÉNYEK VÉGE.
function showcategory($cat) {
	$file = fopen ( "media/" . $cat . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_desc = $mcdat;
	
	echo "    <h1> ";
	echo "<img src=" . curURL () . "/med_ind.gif width=15 height=15 border=0/> "; // kis kepecske
	echo $c_title . "</h1>";
	
	echo "<p>" . $c_desc . "</p>";
	
	medialist ( $cat );
	
	while ( ! feof ( $file ) ) {
		$mc = fgets ( $file );
		$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
		$a_text = $mcdat;
		echo $a_text;
	}
	
	fclose ( $file );
}
function categorylist() {
	$categs = array ();
	$categn = array ();
	// KATEGÓRIÁK ÖSSZEGYŰJTÉSE
	$dir = opendir ( "media" );
	while ( ($fil = readdir ( $dir )) !== false ) {
		if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".txt") && ($fil != ".") && ($fil != "..")) {
			$n = substr ( $fil, 0, strlen ( $fil ) - 4 );
			array_push ( $categs, $n );
			$file = fopen ( "media/" . $n . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
			$mc = fgets ( $file );
			$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
			array_push ( $categn, $mcdat );
			fclose ( $file );
		}
	}
	
	echo "<table width=400 class=medlist>";
	
	for($i = 0; $i < count ( $categs ); $i ++) {
		$lin = curpurl () . "?view=channel&category=" . $categs [$i];
		echo "<tr>";
		echo "<td>";
		echo "<p>";
		echo "<img src=" . curURL () . "/med.gif width=15 height=15 border=0/> "; // kis kepecske
		echo " <a href=" . $lin . ">" . $categn [$i] . "</a></p>";
		echo "</td>";
		echo "</tr>";
	}
	
	echo "</table>";
}
function medialist($cat) {
	$a_title = array ();
	$a_id = array ();
	// $a_date=array();
	$a_file = array ();
	$a_picture = array ();
	$a_text = array ();
	$a_unixdate = array ();
	
	$dir = opendir ( "media/" . $cat );
	
	while ( ($fil = readdir ( $dir )) !== false ) {
				
		if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".med") && ($fil != ".") && ($fil != "..")) {
			
			array_push ( $a_id, substr ( $fil, 0, strlen ( $fil ) - 4 ) );
			
			$ffile = fopen ( "media/" . $cat . "/" . $fil, "r" ) or exit ( "Nincs ilyen média." );
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
		// echo "*";
		
		for($i = 0; $i < count ( $a_unixdate ) - 1; $i ++) {
			// echo $a_unixdate[$i+1] ." ". $a_unixdate[$i];
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
	
	// date(format,timestamp)
	
	echo "<table width=400 border=0 cellspacing=0 cellpadding=0 class=medlist>";
	
	for($i = 0; $i < count ( $a_title ); $i ++) {
		// http://imager.fw.hu/index.php?view=articles&category=hirek
		$lin = curpurl () . "?view=media&category=" . $cat . "&id=" . $a_id [$i];
		// $lin="#";
		$fullfilename = "media/" . $cat . "/" . $a_file [$i];
		$fsize = filsize ( $fullfilename );
		echo "  <tr>";
		echo "    <td width=100>";
		echo "<img src=media/" . $cat . "/" . $a_picture [$i] . " alt=pict width=80 height=60/>";
		echo "</td>";
		echo "    <td><p><b>";
		echo "<a href='" . $lin . "'>";
		echo "<img src=" . curURL () . "/med.gif width=15 height=15 border=0/> "; // kis kepecske
		echo $a_title [$i] . " " . shownew ( $a_unixdate [$i] ) . "</a></b></br>";
		// echo " <h3>Fájl: <a href=".$fullfilename.">".$a_file[$i]." (".$fsize.")</a> | <a href='".$lin."'>Média részletei</a></h3>";
		echo "  " . "Dátuma: " . setdat ( filectime ( $fullfilename ) ) . "<br>";
		echo "  " . "Feltöltve: " . setdat ( $a_unixdate [$i] ) . "</p>";		
		echo "</td>";
		echo "  </tr>";
	}
	
	// echo $fil;
	echo "</table>";
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

// CIKK MEGJELENÍTÉSE
function showmedia($cat, $id) {
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
	echo "  <tr>";
	echo "<td>";
	
	$file = fopen ( "media/" . $cat . ".txt", "r" ) or exit ( "Nincs ilyen kategória." );
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_title = $mcdat;
	$mc = fgets ( $file );
	$mcdat = substr ( $mc, 0, strlen ( $mc ) - 2 );
	$c_desc = $mcdat;
	fclose ( $file );
	
	$file = fopen ( "media/" . $cat . "/" . $id . ".med", "r" ) or exit ( "Nincs ilyen cikk." );
	
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
	
	$clin = curpurl () . "?view=channel&category=" . $cat;
	
	$fullfilename = "media/" . $cat . "/" . $a_file;
	$fsize = filsize ( $fullfilename );
	$url = curURL () . "/" . $fullfilename;
	echo "    <h1> ";
	echo "<img src=" . curURL () . "/med.gif width=15 height=15 border=0/> "; // kis kepecske
	echo $a_title . " ";
	downloadbutton ( $url );
	echo "</h1>";
	player ( $fullfilename, 1 );
	
	echo "<p class='war'>
Ha a lejátszó nem jelenik meg, kattintson az URL címre az letöltéshez. A hiba kijatívásán dolgozunk.<br>
A lejátszó inkompatibilis az IE 9 64 bites verziójával.
</p>";
	
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
	
	echo "</td>";
	echo "    <td valign=top>";
	
	echo "<h3>Adások</h3>";
	
	medialist ( $cat );
	
	echo "<h3>Csatornák</h3>";
	
	categorylist ();
	
	echo "</td>";
	echo "  </tr>";
	echo "</table>";
}
function player($file, $typ) {
	switch ($typ) {
		case 1 :
			// SILVERLIGHT LEJÁTSZÓ			
			// echo "<p class='war'>Figyelem! A lejátszó ismeretlen okokból kifolyólag 'leadarálja' a lejátszandó műsort. A hiba kijavításáig használják a Letöltés lehetőséget. Köszönjük.</p>";
			
			echo "<div><object data='data:application/x-silverlight,' type='application/x-silverlight' style='height: 441px; width: 548px'>";
			echo "            <param name='source' value='MediaPlayerTemplate.xap'/>";
			echo "            <param name='onerror' value='onSilverlightError' />";
			echo "            <param name='autoUpgrade' value='true' />";
			echo "            <param name='minRuntimeVersion' value='4.0.0.0' />";
			echo "            <param name='enableHtmlAccess' value='true' />";
			echo "            <param name='enableGPUAcceleration' value='true' />";
			echo "            <param name='initparams' value='playerSettings = ";
			echo "                        <Playlist>";
			echo "                            <AutoLoad>true</AutoLoad>";
			echo "                            <AutoPlay>true</AutoPlay>";
			echo "                            <DisplayTimeCode>true</DisplayTimeCode>";
			echo "                            <EnableOffline>true</EnableOffline>";
			echo "                            <EnablePopOut>true</EnablePopOut>";
			echo "                            <EnableCaptions>true</EnableCaptions>";
			echo "                            <EnableCachedComposition>true</EnableCachedComposition>";
			echo "                            <StretchNonSquarePixels>NoStretch</StretchNonSquarePixels>";
			echo "                            <StartMuted>false</StartMuted>";
			echo "                            <StartWithPlaylistShowing>false</StartWithPlaylistShowing>";
			echo "                            <Items>";
			echo "						<PlaylistItem>";
			echo "									<AudioCodec>WmaProfessional</AudioCodec>";
			echo "									<Description></Description>";
			echo "									<IsAdaptiveStreaming>false</IsAdaptiveStreaming>";
			echo "									<MediaSource>" . $file . "</MediaSource>";
			echo "									<ThumbSource></ThumbSource>";
			echo "									<Title>Maxor Videólejátszó</Title>";
			echo "									<DRM>false</DRM>";
			echo "									<VideoCodec>VC1</VideoCodec>";
			// echo " <FrameRate>25</FrameRate>";
			echo "									<AspectRatioWidth>4</AspectRatioWidth>";
			echo "									<AspectRatioHeight>3</AspectRatioHeight>";
			echo "								</PlaylistItem>";
			echo "			    </Items>";
			echo "                        </Playlist>'/>       ";
			echo "            <!--  unused valid silverlight init parameters";
			echo "            <param name='enableFrameRateCounter' value='bool' />";
			echo "            <param name='enableRedrawRegions' value='bool' />";
			echo "            <param name='maxFrameRate' value='int' />";
			echo "            <param name='allowHtmlPopupWindow' value='bool'/>";
			echo "            <param name='background' value='colorValue'/>";
			echo "            <param name='splashScreenSource' value='uri'/>";
			echo "            <param name='fullScreen' value='bool'/>";
			echo "            <param name='onFullScreenChanged' value='functionname'/>";
			echo "            <param name='onResize' value='functionname'/>";
			echo "            <param name='onSourceDownloadComplete' value='functionname'/>";
			echo "            <param name='onSourceDownloadProgressChanged' value='functionname'/>";
			echo "            <param name='windowLess' value='bool'/>";
			echo "             --> ";
			echo "             <div onMouseOver='highlightDownloadArea(true)' onMouseOut='highlightDownloadArea(false)'>";
			echo "                    <img src='' style='position:relative                ";
			echo "                  ;width:100%;height:100%;border-style:none;' onerror='this.style.display='none''/>";
			echo "                    <img src=Preview.png style='position:relative;width:100%;height:100%;border-style:none;' ";
			echo "onerror='this.style.display='none''/>                                            ";
			echo "                    <div id='overlay' class='fadeLots' style='position:relative;width:100%;";
			echo "height:100%;border-style:none;background-color:white;'/></div>";
			echo "                    <table width='100%' height='100%' ";
			echo "style='position:relative;'><tr><td align='center' valign='middle'>                       ";
			echo "                    <img src='http://go2.microsoft.com/fwlink/?LinkId=108181' alt='Get Microsoft Silverlight'> ";
			echo "                    </td></tr></table>                   ";
			echo "                    <a href='http://go2.microsoft.com/fwlink/?LinkID=149156'>";
			echo "                        <img src='' class='fadeCompletely'";
			echo " style='position:relative;width:100%;height:100%;border-style:none;' alt='Get Microsoft Silverlight'/>";
			echo "                    </a>                   ";
			// echo " </div> ";
			echo "        </object></div>";
			break;
		case 2 :
			// WINDOWS MEDIA PLAYERES LEJÁTSZÓ
			// echo "Most szkripptel mennek a dolgok";
			echo "<script type='text/javascript'>";
			echo "AC_AX_RunContent( 'id','mediaPlayer','width','480','height','460','classid','CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95','codebase','http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701','standby','A Microsoft Windows Media Player összetevõinek betöltése...','type','application/x-oleobject','pluginspage','http://microsoft.com/windows/mediaplayer/en/download/','name','mediaPlayer','displaysize','4','autosize','-1','bgcolor','darkblue','showcontrols','true','showtracker','-1','showdisplay','0','showstatusbar','-1','videoborder3d','-1','src','" . $file . "'
,'autostart','true','designtimesp','5311','loop','false','filename','" . $file . "','animationatstart','true','transparentatstart','false' ); //end AC code";
			
			echo "</script><noscript><OBJECT id='mediaPlayer' width=480 height=460";
			echo "    classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95'";
			echo "codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'";
			echo "standby='A Microsoft Windows Media Player összetevõinek betöltése...' type='application/x-oleobject'>";
			echo "<param name='fileName' value=" . $file . "97.mp3>";
			echo "<param name='animationatStart' value='true'>";
			echo "<param name='transparentatStart' value='false'>";
			echo "<param name='autoStart' value=true>";
			echo "<param name='showControls' value=true>";
			echo "<param name='loop' value=false>";
			echo "<EMBED type='application/x-mplayer2'";
			echo "pluginspage='http://microsoft.com/windows/mediaplayer/en/download/'";
			echo "id='mediaPlayer' name='mediaPlayer' displaysize='4' autosize='-1'";
			echo "bgcolor='darkblue' showcontrols=true showtracker='-1'";
			echo "showdisplay='0' showstatusbar='-1' videoborder3d='-1' width=320 height=285";
			echo "src=" . $file . " autostart=true designtimesp='5311' loop=true>";
			echo "</EMBED>";
			echo "</OBJECT></noscript>";
			break;
		default :
			echo "<p>Nincs lejátszó</p>";
	}
}

echo "<table width='1200px'  cellspacing=0 cellpadding=0>";
echo "				<tr height=100px>";
echo "								<td>";
// include("header.html");

if (file_exists ( "media/" . $art_cat . "/banner.jpg" )) {
	echo "<img src='media/" . $art_cat . "/banner.jpg' alt=banner width=1200 height=110 />";
} else {
	echo "<h1>Imager Médiatár BÉTA</h1>";
}

echo "								</td>";
echo "				</tr>";
echo "				<tr>";

echo "	<td valign=top>";

echo "<table width='100%' border='0' height='100%'>";
echo "  <tr>";
echo "    <td valign='top' class='cont'>";

switch ($view) {
	case "media" :
		showmedia ( $art_cat, $art_file );
		break;
	case "channel" :
		showcategory ( $art_cat );
		break;
	default :
		if (file_exists ( $_GET ["page"] ) == 1) {
			include ($_GET ["page"]);
		} else {
			echo "<p>Médiatár</p>";;
		}
}

echo "</td>";
echo "  </tr>";
echo "</table>";

echo "			</td>";
echo "			</tr>";
echo "</table>";
$backurl = curURL ();
echo "<p>2011., 2016 IMAGER, Elekes Dávid | <a href=" . $backurl . ">Vissza a főoldalhoz</a></p>";
?>

</body>

</html>
