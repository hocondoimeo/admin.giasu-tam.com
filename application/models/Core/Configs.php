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
            "ConfigCategoryId"             => "Configs.ConfigCategoryId       = '{{param}}'",
            "IsDisabled"                   => "Configs.IsDisabled             = '{{param}}'",
            "LastUpdated"                  => "Configs.LastUpdated            = '{{param}}'",
            "LastUpdatedBy"                => "Configs.LastUpdatedBy          = '{{param}}'",
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


}