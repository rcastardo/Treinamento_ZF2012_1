<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH),
    get_include_path(),
)));


require 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Anhanguera');

spl_autoload_register(array('Anhanguera_Loader_Autoloader', 'autoload'));

$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

$adapter = $config->resources->db->adapter;
$params = $config->resources->db->params->toArray();
$db = Zend_Db::factory($adapter, $params);
Zend_Db_Table_Abstract::setDefaultAdapter($db);


Zend_Loader::loadClass('Bootstrap');
new Bootstrap();

Zend_Layout::startMvc(array(
	'layoutPath' => APPLICATION_PATH . '/layouts/scripts'
));

$frontController = Zend_Controller_Front::getInstance();
/*$frontController->setDefaultModule('default');

$frontController->addModuleDirectory(APPLICATION_PATH . '/modules');

$modules = array('admin', 'default', 'servicos');
foreach ($modules as $module)
{
	$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers', $module);
}
*/
$frontController->setControllerDirectory(APPLICATION_PATH . '/controllers');
$frontController->setBaseUrl('/bueno1');
//$frontController->setModuleControllerDirectoryName('controllers');
$frontController->dispatch();





