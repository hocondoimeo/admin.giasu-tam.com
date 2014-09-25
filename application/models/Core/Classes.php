<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Classes extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Classes
********************************************************************/
    protected $_name        = 'Classes';
    protected $_primary     = array('ClassId',);

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
            "ClassId"                      => "Classes.ClassId                = '{{param}}'",
            "ClassAddress"                 => "Classes.ClassAddress           LIKE '%{{param}}%'",
            "ClassContact"                 => "Classes.ClassContact           LIKE '%{{param}}%'",
            "ClassCost"                    => "Classes.ClassCost              = '{{param}}'",
            "ClassDaysOfWeek"              => "Classes.ClassDaysOfWeek        = '{{param}}'",
            "ClassTime"                    => "Classes.ClassTime              LIKE '%{{param}}%'",
            "ClassRequire"                 => "Classes.ClassRequire           LIKE '%{{param}}%'",
            "ClassTutors"                  => "Classes.ClassTutors            LIKE '%{{param}}%'",
            "ClassSubjects"                => "Classes.ClassSubjects          LIKE '%{{param}}%'",
            "ClassMember"                  => "Classes.ClassMember            = '{{param}}'",
            "ClassStatus"                  => "Classes.ClassStatus            = '{{param}}'",
            "CreatedDate"                  => "Classes.CreatedDate            = '{{param}}'",
            "IsDisabled"                   => "Classes.IsDisabled             = '{{param}}'",
            "LastUpdated"                  => "Classes.LastUpdated            = '{{param}}'",
            "LastUpdatedBy"                => "Classes.LastUpdatedBy          = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "ClassId_Sort"                 => "Classes.ClassId                {{param}}",
            "ClassAddress_Sort"            => "Classes.ClassAddress           {{param}}",
            "ClassContact_Sort"            => "Classes.ClassContact           {{param}}",
            "ClassCost_Sort"               => "Classes.ClassCost              {{param}}",
            "ClassDaysOfWeek_Sort"         => "Classes.ClassDaysOfWeek        {{param}}",
            "ClassTime_Sort"               => "Classes.ClassTime              {{param}}",
            "ClassRequire_Sort"            => "Classes.ClassRequire           {{param}}",
            "ClassTutors_Sort"             => "Classes.ClassTutors            {{param}}",
            "ClassSubjects_Sort"           => "Classes.ClassSubjects          {{param}}",
            "ClassMember_Sort"             => "Classes.ClassMember            {{param}}",
            "ClassStatus_Sort"             => "Classes.ClassStatus            {{param}}",
            "CreatedDate_Sort"             => "Classes.CreatedDate            {{param}}",
            "IsDisabled_Sort"              => "Classes.IsDisabled             {{param}}",
            "LastUpdated_Sort"             => "Classes.LastUpdated            {{param}}",
            "LastUpdatedBy_Sort"           => "Classes.LastUpdatedBy          {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/


}