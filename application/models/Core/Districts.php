<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Districts extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Districts
********************************************************************/
    protected $_name        = 'Districts';
    protected $_primary     = array('DistrictId',);

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
            "DistrictId"                   => "Districts.DistrictId           = '{{param}}'",
            "DistrictName"                 => "Districts.DistrictName         LIKE '%{{param}}%'",
            "IsDisabled"                   => "Districts.IsDisabled           = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "DistrictId_Sort"              => "Districts.DistrictId           {{param}}",
            "DistrictName_Sort"            => "Districts.DistrictName         {{param}}",
            "IsDisabled_Sort"              => "Districts.IsDisabled           {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/


}