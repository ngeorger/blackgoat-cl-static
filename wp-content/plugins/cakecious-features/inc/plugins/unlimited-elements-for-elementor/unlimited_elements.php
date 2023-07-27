<?php
/*
Plugin Name: Unlimited Elements for Elementor
Plugin URI: http://unlimited-elements.com
Description: Unlimited Elements - Huge Widgets Pack for Elementor Page Builder, with html/css/js widget creator and editor
Author: Unlimited Elements
Version: 1.4.42
Author URI: http://unlimited-elements.com
*/


if(!defined("UNLIMITED_ELEMENTS_INC"))
	define("UNLIMITED_ELEMENTS_INC", true);

$mainFilepath = __FILE__;
$currentFolder = dirname($mainFilepath);
$pathProvider = $currentFolder."/provider/";


try{
		
	if(class_exists("GlobalsUC"))
		define("UC_BOTH_VERSIONS_ACTIVE", true);
	else{
		
		$pathAltLoader = $pathProvider."provider_alt_loader.php";
		if(file_exists($pathAltLoader)){
			
			require $pathAltLoader;
		}else{
			require_once $currentFolder.'/includes.php';
					
			require_once  GlobalsUC::$pathProvider."core/provider_main_file.php";
		}
		
	}
	
}catch(Exception $e){
	$message = $e->getMessage();
	$trace = $e->getTraceAsString();
	
	echo "<br>";
	echo esc_html($message);
	echo "<pre>";
	print_r($trace);
}


