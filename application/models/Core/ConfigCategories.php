<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_ConfigCategories extends Base_Db_Table_Abstract {


/********************************************************************
* Define table ConfigCategories
********************************************************************/
    protected $_name        = 'ConfigCategories';
    protected $_primary     = array('ConfigCategoryId',);

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
            "ConfigCategoryId"             => "ConfigCategories.ConfigCategoryId = '{{param}}'",
            "ConfigCategoryName"           => "ConfigCategories.ConfigCategoryName LIKE '%{{param}}%'",
            "ConfigCategoryCode"           => "ConfigCategories.ConfigCategoryCode LIKE '%{{param}}%'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "ConfigCategoryId_Sort"        => "ConfigCategories.ConfigCategoryId {{param}}",
            "ConfigCategoryName_Sort"      => "ConfigCategories.ConfigCategoryName {{param}}",
            "ConfigCategoryCode_Sort"      => "ConfigCategories.ConfigCategoryCode {{param}}",
            "CreatedDate_Sort"             => "ConfigCategories.CreatedDate   {{param}}",
            "IsDisabled_Sort"              => "ConfigCategories.IsDisabled    {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/
    public function getConfigCateByCateId($cateId) {
    	return $this->_db->fetch("SELECT  FROM {$this->_name} WHERE ConfigCategoryId = {$cateId} ORDER BY ConfigCategoryName DESC");
    }
    
    public function getAllConfigCate() {
    	return $this->_db->fetchOne("SELECT Position FROM {$this->_name} ORDER BY CreatedDate DESC");
    }
    
    public function getFormPairs() {
    	$select = $this->getQuerySelectAll(array(), array('ConfigCategoryId', 'ConfigCategoryName'));
    	 
    	$result = $this->fetchAll($select)->toArray();
    	$content = array();
    	 
    	foreach ($result as $val) {
    		$content[$val['ConfigCategoryId']] = $val['ConfigCategoryName'];
    	}
    	 
    	return $content;
    }

}