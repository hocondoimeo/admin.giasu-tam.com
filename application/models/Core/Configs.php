<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Configs extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Configs
********************************************************************/
    protected $_name        = 'Configs';
    protected $_primary     = array('ConfigId',);

    protected $_dependentTables = array(

    );

    protected $_referenceMap    = array(

    );


/********************************************************************
* Define field search, sort
********************************************************************/
    public $searchFields = array();
    public $sortFields   = array();

    public function init() {
        parent::init();

         /* Define field to search */
        $this->searchFields = array(
            "ConfigId"                     => "Configs.ConfigId               = '{{param}}'",
            "ConfigName"                   => "Configs.ConfigName             LIKE '%{{param}}%'",
            "ConfigCode"                   => "Configs.ConfigCode             LIKE '%{{param}}%'",
            "ConfigValue"                  => "Configs.ConfigValue            LIKE '%{{param}}%'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "ConfigId_Sort"                => "Configs.ConfigId               {{param}}",
            "ConfigName_Sort"              => "Configs.ConfigName             {{param}}",
            "ConfigCode_Sort"              => "Configs.ConfigCode             {{param}}",
            "ConfigValue_Sort"             => "Configs.ConfigValue            {{param}}",
            "ConfigCategoryId_Sort"        => "Configs.ConfigCategoryId       {{param}}",
            "IsDisabled_Sort"              => "Configs.IsDisabled             {{param}}",
            "LastUpdated_Sort"             => "Configs.LastUpdated            {{param}}",
            "LastUpdatedBy_Sort"           => "Configs.LastUpdatedBy          {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/
    /**
     * get config value
     * @author tri.van
     * @param string $configcode
     * @return string Config Value
     * @since Tue Now 12, 9:48 AM
     */
    public function getConfigValue($configcode){
    	$select = $this->select()->from($this,'ConfigValue')->where('ConfigCode = ?',$configcode)->where('IsDisabled = 0');
    	$result = $this->fetchRow($select);
    	if($result) return $result->ConfigValue;
    	else return null;
    }
    
    /**
     * get config value
     * @author Phuc Duong
     * @param string $configcode
     * @return string Config Value
     * @since Tue Now 12, 9:48 AM
     */
    public function getConfigValueByCategoryCode($categoryCode){
    	if(empty($categoryCode)){
    		return null;
    	}
    	$select = $this->select()
    	->from('Configs')
    	->join('ConfigCategories', 'Configs.ConfigCategoryId = ConfigCategories.ConfigCategoryId')
    	->setIntegrityCheck(false)
    	->where('ConfigCategoryCode = ?',$categoryCode)
    	->where('ConfigCategories.IsDisabled = 0')
    	->where('Configs.IsDisabled = 0');
    	$result = $this->fetchAll($select);
    
    	return $result;
    }
    
    /**
     * get config value
     * @author tri.van
     * @param string $configcode
     * @return string Config Value
     * @since Tue Now 12, 9:48 AM
     */
    public function getConfigName($configcode){
    	$select = $this->select()->from($this,'ConfigName')->where('ConfigCode = ?',$configcode)->where('IsDisabled = 0');
    	$result = $this->fetchRow($select);
    	if($result) return $result->ConfigName;
    	else return null;
    }
    
    public function getConfigDetail($configcode){
    	$cols = array('ConfigValue', 'ConfigName');
    	$select = $this->select()->from($this, $cols)->where('ConfigCode = ?',$configcode)->where('IsDisabled = 0');
    	$result = $this->fetchRow($select);
    	if($result) return $result;
    	else return null;
    }

}