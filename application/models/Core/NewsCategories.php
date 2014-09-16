<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_NewsCategories extends Base_Db_Table_Abstract {


/********************************************************************
* Define table NewsCategories
********************************************************************/
    protected $_name        = 'NewsCategories';
    protected $_primary     = array('NewsCategoryId',);

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
            "NewsCategoryId"               => "NewsCategories.NewsCategoryId  = '{{param}}'",
            "NewsCategoryName"             => "NewsCategories.NewsCategoryName LIKE '%{{param}}%'",
            "NewsCategoryCode"             => "NewsCategories.NewsCategoryCode LIKE '%{{param}}%'",
            "CreatedDate"                  => "NewsCategories.CreatedDate     = '{{param}}'",
            "IsDisabled"                   => "NewsCategories.IsDisabled      = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "NewsCategoryId_Sort"          => "NewsCategories.NewsCategoryId  {{param}}",
            "NewsCategoryName_Sort"        => "NewsCategories.NewsCategoryName {{param}}",
            "NewsCategoryCode_Sort"        => "NewsCategories.NewsCategoryCode {{param}}",
            "CreatedDate_Sort"             => "NewsCategories.CreatedDate     {{param}}",
            "IsDisabled_Sort"              => "NewsCategories.IsDisabled      {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/

    public function getNewsCateByCateId($cateId) {
    	return $this->_db->fetch("SELECT  FROM {$this->_name} WHERE NewsCategoryId = {$cateId} ORDER BY NewsCategoryName DESC");
    }
    
    public function getAllNewsCate() {
    	return $this->_db->fetchOne("SELECT Position FROM {$this->_name} ORDER BY CreatedDate DESC");
    }
    
    public function getFormPairs() {
    	$select = $this->getQuerySelectAll(array(), array('NewsCategoryId', 'NewsCategoryName'));
    	
    	$result = $this->fetchAll($select)->toArray();
    	$content = array();
    	
    	foreach ($result as $val) {
    		$content[$val['NewsCategoryId']] = $val['NewsCategoryName'];
    	}
    	
    	return $content;
    }
}