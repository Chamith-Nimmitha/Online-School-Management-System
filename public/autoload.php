<?php
    if(!isset($_SESSION)) { 
        session_start(); 
    } 
?>
<?php 
	
	// define all folder paths
	define("DS", DIRECTORY_SEPARATOR);
	define("ROOT_PATH",dirname(__DIR__).DS);
	define("APP", ROOT_PATH.'app'.DS );
	define("CONFIG", APP.'config'.DS );
	define("CORE", APP.'core'.DS );
	define("CONTROLLERS", APP.'controllers'.DS );
	define("MODELS", APP.'models'.DS );
	define("VIEWS", APP.'views'.DS );
	define("HELPERS", APP.'helpers'.DS );
	define("INCLUDES", APP.'includes'.DS );
	define("PUB", ROOT_PATH.'public'.DS );
	define("UPLOADS", PUB.'uploads'.DS );
	define("ASSETS", PUB.'assets'.DS );

	//autoload all classes
	$modules = [CORE,CONTROLLERS,MODELS,VIEWS,HELPERS];
	set_include_path(get_include_path(). PATH_SEPARATOR.implode(PATH_SEPARATOR, $modules));
	spl_autoload_register('spl_autoload',false);
	
	require_once(CONFIG."config.php");
	require_once(HELPERS."url_helper.php");
	require_once(INCLUDES."common.php");
	require_once(INCLUDES."check_permissions.php");

	new App();
 ?>