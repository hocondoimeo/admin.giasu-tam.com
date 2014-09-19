<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    public function _initLoadViewResource() {
        
        $this->bootstrap('view');
        $view = $this->getResource('view');

        $this->_setNavigation($view);
    }
//
    public function _setNavigation($view){

         $config = new Zend_Config_Ini(APPLICATION_PATH.'/layouts/navigation.ini', 'run');
         $navigation = new Zend_Navigation($config->navigation);
         $view = $view->navigation($navigation);
        
    }
    
    public function _initDb() {
    	$resource = $this->getPluginResource('db');
    	$options = $resource->getOptions();
    	$db = new Zend_Db_Adapter_Pdo_Mysql($options["params"]);
    	Zend_Db_Table_Abstract::setDefaultAdapter($db);
    	try {
    		$db->getConnection();
    	} catch( Exception $e ) {
    		print_r($e->getMessage());
    		die;
    	}
    }    
    
    private function _initSession(){
    	$this->bootstrap('db');
    	$this->bootstrap('session');
    	Zend_Session::start();
    }
}

