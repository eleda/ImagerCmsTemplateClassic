<?php
// PHP VIDEO BOX
echo "<html>";
echo "<head>";
echo "<title>Videólejátszó</title>";
echo "<link rel=stylesheet type=text/css href=../page.css />";
echo "</head>";

echo "<body>";
echo "<h1>Videó - " . $_GET ["file"] . "</h1>";
echo "<p>";
echo " <OBJECT id='mediaPlayer' width=480 height=460";
echo "    classid='CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95'";
echo "codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701'";
echo "standby='A Microsoft Windows Media Player összetevőinek betöltése...' type='application/x-oleobject'>";
echo "<param name='fileName' value=" . $_GET ["file"] . ">";
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
echo "src=somen_internet.wmv autostart=true designtimesp='5311' loop=true>";
echo "</EMBED>";
echo "</OBJECT>";
echo "</p>";
echo "<p>2010. Elekes Dávid </p>";
echo "<a href=media.htm>Vissza a videók oldalához</a>";
echo "</body>";

echo "</html>";

?>