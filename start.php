<?php if (!defined("CMS")) die('Direct access to this location is not allowed.');
//Start Timer
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
//Open Database
$db = new DB();
//Interface Cms Starting
ob_start();
//Check Status Website
if(info_cms('site_status')=="offline"){
	include_once(_MAINTENANCE.'/offline.php');
}else{
	//Require Meta-tags from system
	require_once(_SYSTEM.'/meta-content.php');
	//Optional function themes
	if(file_exists(_THEMES.'/'.info_cms('site_themes').'/function.php')){
		include_once(_THEMES.'/'.info_cms('site_themes').'/function.php');
	}
	//Masukkan header
	if(file_exists(_THEMES.'/'.info_cms('site_themes').'/header.php')){
		include_once(_THEMES.'/'.info_cms('site_themes').'/header.php');
	}
	//Ini bagian center
	if(file_exists(_THEMES.'/'.info_cms('site_themes').'/layout.php')){
		include_once(_THEMES.'/'.info_cms('site_themes').'/layout.php');
	}else{
		echo 'Your Site Is Broken, because themes is missing !';
	}
	//Masukkan footer
	if(file_exists(_THEMES.'/'.info_cms('site_themes').'/footer.php')){
		include_once(_THEMES.'/'.info_cms('site_themes').'/footer.php');
	}
}
ob_end_flush();
//Close Database
$db->close();
?>
