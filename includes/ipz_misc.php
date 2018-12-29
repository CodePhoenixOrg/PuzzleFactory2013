<?php   
/*
iPuzzle.WebPieces
Copyright (C) 2004 David Blanchard

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

define("LINUX", "linux");
define("WIN32", "windows");
define ('DEBUG_LOG_FILE', serverPath() . '/logs/debug.log');
define ('CR_LF', "\r\n");
global $DEBUG_LOG_FILE;

$DEBUG_LOG_FILE = serverPath() . '/logs/debug.log';

function debugLog($message, $object = '') {
    global $DEBUG_LOG_FILE;

    $handle = fopen($DEBUG_LOG_FILE, 'a');
    
    $message = date('Y-m-d h:i:s') . " : $message"  . (isset($object) ? " : " . print_r($object, true) : "");
    fwrite($handle, $message . CR_LF);
    fclose($handle);
}

function serverPath() {
    $result = '';
    
    $sa = explode('/', $_SERVER['SCRIPT_NAME']);
    $result = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) .'/'. $sa[1] ;
    
    return $result;
    
}


function escapeChars($phrase) {
        $result = '';
        
        $result = str_replace("'", "''", $phrase);
        
        return $result;
}

function js_quote($code) {
	$js="<script language='JavaScript'>\n";
	$js.=$code;
	$js.="</script>\n";

	return $js;
}

function js_array($name="", $array=array()) {

	$js="var $name=new Array(\"".implode("\", \"", $array)."\");";
	
	return $js;
}
	
function js_alert($msg) {
	$js="<script language=\"JavaScript\">alert(\"$msg\")</script>";

	return $js;
}

function get_sql_date() {
	$date=getdate();
	$mon="0".$date["mon"];
	$mon=substr($mon, strlen($mon)-2, 2);
	$mday="0".$date["mday"];
	$mday=substr($mday, strlen($mday)-2, 2);
	$sql_date= $date["year"]."-".$mon."-".$mday;
	return $sql_date;
}

function get_french_date() {
	$date=getdate();
	$mon="0".$date["mon"];
	$mon=substr($mon, strlen($mon)-2, 2);
	$mday="0".$date["mday"];
	$mday=substr($mday, strlen($mday)-2, 2);
	$french_date=$mday."/".$mon."/".$date["year"];
	return $french_date;
}

function get_sql_time() {
	$time=getdate();
	$hours="0".$time["hours"];
	$hours=substr($hours, strlen($hours)-2, 2);
	$minutes="0".$time["minutes"];
	$minutes=substr($minutes, strlen($minutes)-2, 2);
	$seconds="0".$time["seconds"];
	$seconds=substr($seconds, strlen($seconds)-2, 2);
	$time=$hours.":".$minutes.":".$seconds;
	return $time;
}

function get_short_time() {
	$time=getdate();
	$hours="0".$time["hours"];
	$hours=substr($hours, strlen($hours)-2, 2);
	$minutes="0".$time["minutes"];
	$minutes=substr($minutes, strlen($minutes)-2, 2);
	$time=$hours.":".$minutes;
	return $time;
}

function get_days_delta($recent_date, $old_date) {
	$a_old_date=date_sql_to_array($old_date);
	$a_recent_date=date_sql_to_array($recent_date);
	
	$mm=$a_old_date["month"];
	$dd=$a_old_date["day"];
	$yy=$a_old_date["year"];
	$m_old_date=mktime(0,0,0,$mm,$dd,$yy);
	
	$mm=$a_recent_date["month"];
	$dd=$a_recent_date["day"];
	$yy=$a_recent_date["year"];
	$m_recent_date=mktime(0,0,0,$mm,$dd,$yy);
	
	$delta=round(($m_recent_date-$m_old_date)/86400);
	
	return $delta;
}
				
function date_mysql_to_french($date) {
	if(strlen($date) > 10) $date = substr($date, 0, 10);
	$date = preg_replace('^([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})$', '\3/\2/\1', $date);

	return $date;
}

function date_french_to_mysql($date) {
	$date = preg_replace('^([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})$', '\3-\2-\1', $date);

	return $date;
}

function date_sql_to_array($date) {
	$yy = substr($date, 0, 4);
	$mm = substr($date, 5, 2);
	$dd = substr($date, 8, 2);

	return array("day"=>$dd, "month"=>$mm, "year"=>$yy);
}

function time_mysql_to_short($time) {
	if(strlen($time)==19) $time = substr($time, 11, 5);

	return $time;
}

function datetime_mysql_to_french($datetime) {
	$datetime = preg_replace('^([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})$', '\1/\2/\3 \4:\5', $datetime);

	return $datetime;
}

function datetime_user_to_french($date, $time) {
	$date = date_mysql_to_french($date);
	$time = time_mysql_to_short($time);
	$datetime = $date . " " . $time;

	return $datetime;
}

function is_num($var) {

	$is_num=true;
	$l=trim(strlen($var));
	$i=0;
	while(($i<$l) && $is_num===true) {
		$char=substr($var, $i, 1);
        	$asc=ord($char);
		//echo "var[$i]='".$char."'; ascii_code='".$asc."'<br>";
                $char_is_num=($asc>47 && $asc<58);
		$is_num=$is_num && $char_is_num;
		$i++;
	}
    	return $is_num;
}

function get_variable_set($var) {
	//Global $HTTP_GET_VARS, $HTTP_POST_VARS;
	
	return array_merge($_POST, $_GET);
}

function get_variable($var, $default = '')
{
    $result = '';

    if (isset($_GET[$var])) {
        $result = $_GET[$var];
    } elseif (isset($_POST[$var])) {
        $result = $_POST[$var];
    }
    
    if ($result === '') {
        $result = $default;
    }
    return $result;
}

function get_http_root() {
	if($_SERVER["SERVER_PORT"]!='80')
		$http_root="http://".$_SERVER["SERVER_ADDR"].":".$_SERVER["SERVER_PORT"]."/";
	else
		$http_root="http://".$_SERVER["SERVER_NAME"];

	return $http_root;
}

function get_www_root() {
	/*
	$p=strpos($_SERVER["DOCUMENT_ROOT"], "/");
	if($p==2) 
		$system=WIN32;
	else
		$system=LINUX;

	if($system==LINUX)
		$wwwroot="/var/www";
	else
		$wwwroot="e:/www/html";
	*/
	//$wwwroot=$_SERVER["DOCUMENT_ROOT"]."/..";
	$wwwroot=$_SERVER["DOCUMENT_ROOT"];
	return $wwwroot;
}

function get_current_dir() {
	$current_dir="";
	$phpself=$_SERVER["PHP_SELF"];
	
	//$p1=strpos($phpself, "/");
	//$p2=strpos($phpself, "/", ++$p1);
	//if($p2>0) $current_dir="/../".substr($phpself, $p1, $p2-$p1);
	//if($p2>0) $current_dir="/".substr($phpself, $p1, $p2-$p1);
	$p3=strrpos($phpself, "/");
	$current_dir=substr($phpself, 0, $p3);
	
	return $current_dir;
}

function get_current_http_root() {
	$current_dir="";
	$phpself=$_SERVER["PHP_SELF"];
	
//	$p1=strpos($phpself, "/");
//	$p2=strpos($phpself, "/", ++$p1);
//	if($p2>0) $current_dir="/".substr($phpself, $p1, $p2-$p1);
	$p3=strrpos($phpself, "/");
	$current_dir=substr($phpself, 0, $p3);
	
	$http_root=get_http_root();
	
	$current_http_root=$http_root.$current_dir;

	return $current_http_root;
}
	
function get_current_www_root() {

	$www_root=get_www_root();
	$current_dir=get_current_dir();
	$files_dir="";

	$files_dir=$www_root.$current_dir;
		
	return $files_dir;
}

function get_http_images_dir($directory="") {
	$images_dir=get_http_root()."images/";
	return $images_dir;
}

function get_http_fonts_dir($directory="") {
	$fonts_dir=get_http_root()."fonts/";
	return $fonts_dir;
}

function get_local_images_dir() {
	$images_dir=$_SERVER["DOCUMENT_ROOT"]."/$img/";
	return $images_dir;
}

function get_local_fonts_dir() {
	$fonts_dir=$_SERVER["DOCUMENT_ROOT"]."/fonts/";
	return $fonts_dir;
}

function raise_error($message, $action, $on_click) {
	global $panel_colors;
	
	$on_click=trim($on_click);
	if($on_click!='') $on_click=" onClick=\"$on_click\"";
?>
<center>
<form method='POST' name='errorForm' action='<?php echo $action?>'>
<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'><tr><td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
<table border="0" cellpadding="20">
    <tr>
      <td align="center">
        <?php   
	echo 'ERREUR<br>'.$message;
	?><br><br>
        <input type="submit" name="action" value="OK"<?php echo $on_click?>><br>
      </td>
    </tr>
</table>
</td></tr></table>
</form>
<center>
<?php   
}

function msg_box($message, $action, $on_click) {
	global $panel_colors;
	
	$on_click=trim($on_click);
	if($on_click!='') $on_click=" onClick=\"$on_click\"";
?>
<center>
<form method='POST' name='msgForm' action='<?php echo $action?>'>
<table border='1' bordercolor='<?php echo $panel_colors["border_color"]?>' cellpadding='0' cellspacing='0' witdh='100%' height='1'><tr><td align='center' valign='top' bgcolor='<?php echo $panel_colors["back_color"]?>'>
<table border="0" cellpadding="20">
    <tr>
      <td align="center">
        <?php   
	echo $message;
	?><br><br>
        <input type="submit" name="action" value="OK"<?php echo $on_click?>><br>
      </td>
    </tr>
</table>
</td></tr></table>
</form>
<center>
<?php   
}

define("PZ_DEFAULTS", get_current_www_root()."/pz_defaults.php");
