<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Images extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Images
********************************************************************/
    protected $_name        = 'Images';
    protected $_primary     = array('ImageId',);

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
            "ImageId"                      => "Images.ImageId                 = '{{param}}'",
            "ImageCode"                    => "Images.ImageCode               LIKE '%{{param}}%'",
            "ImageName"                    => "Images.ImageName               LIKE '%{{param}}%'",
            "ImageDesc"                    => "Images.ImageDesc               LIKE '%{{param}}%'",
            "RecommendWidth"               => "Images.RecommendWidth          = '{{param}}'",
            "RecommendHeight"              => "Images.RecommendHeight         = '{{param}}'",
            "Section"                      => "Images.Section                 LIKE '%{{param}}%'",
            "LastUpdated"                  => "Images.LastUpdated             = '{{param}}'",
            "LastUpdatedBy"                => "Images.LastUpdatedBy           = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "ImageId_Sort"                 => "Images.ImageId                 {{param}}",
            "ImageCode_Sort"               => "Images.ImageCode               {{param}}",
            "ImageName_Sort"               => "Images.ImageName               {{param}}",
            "ImageDesc_Sort"               => "Images.ImageDesc               {{param}}",
            "RecommendWidth_Sort"          => "Images.RecommendWidth          {{param}}",
            "RecommendHeight_Sort"         => "Images.RecommendHeight         {{param}}",
            "Section_Sort"                 => "Images.Section                 {{param}}",
            "LastUpdated_Sort"             => "Images.LastUpdated             {{param}}",
            "LastUpdatedBy_Sort"           => "Images.LastUpdatedBy           {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/


}