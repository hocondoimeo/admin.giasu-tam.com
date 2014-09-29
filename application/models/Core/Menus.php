<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Menus extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Menus
********************************************************************/
    protected $_name        = 'Menus';
    protected $_primary     = array('MenuId',);

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
            "MenuId"                       => "Menus.MenuId                   = '{{param}}'",
            "ParentMenuId"                 => "Menus.ParentMenuId             = '{{param}}'",
            "MenuName"                     => "Menus.MenuName                 LIKE '%{{param}}%'",
            "MenuCode"                     => "Menus.MenuCode                 LIKE '%{{param}}%'",
            "MenuUrl"                      => "Menus.MenuUrl                  LIKE '%{{param}}%'",
            "ClassName"                    => "Menus.ClassName                LIKE '%{{param}}%'",
            "Position"                     => "Menus.Position                 = '{{param}}'",
            "IsDisabled"                   => "Menus.IsDisabled               = '{{param}}'",
            "LastUpdatedBy"                => "Menus.LastUpdatedBy            = '{{param}}'",
            "LastUpdated"                  => "Menus.LastUpdated              = '{{param}}'",
            "CreatedDate"                  => "Menus.CreatedDate              = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "MenuId_Sort"                  => "Menus.MenuId                   {{param}}",
            "ParentMenuId_Sort"            => "Menus.ParentMenuId             {{param}}",
            "MenuName_Sort"                => "Menus.MenuName                 {{param}}",
            "MenuCode_Sort"                => "Menus.MenuCode                 {{param}}",
            "MenuUrl_Sort"                 => "Menus.MenuUrl                  {{param}}",
            "ClassName_Sort"               => "Menus.ClassName                {{param}}",
            "Position_Sort"                => "Menus.Position                 {{param}}",
            "IsDisabled_Sort"              => "Menus.IsDisabled               {{param}}",
            "LastUpdatedBy_Sort"           => "Menus.LastUpdatedBy            {{param}}",
            "LastUpdated_Sort"             => "Menus.LastUpdated              {{param}}",
            "CreatedDate_Sort"             => "Menus.CreatedDate              {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/
	public function getParentMenu($menuId){
		$select = $this->select()->where('ParentMenuId is null');
		if(isset($menuId) && $menuId) $select->where('MenuId != '.$menuId);
		$select->order("Position ASC");
		$result = $this->fetchAll($select)->toArray();
		$content = array();
		 
		foreach ($result as $val) {
			$content[$val['MenuId']] = $val['MenuName'];
		}
		 
		return $content;
	}
	
	public function getParentName($menuId){
		return $this->fetchRow($this->select()->where('MenuId = '.$menuId)->where('ParentMenuId is null'));
	}

}