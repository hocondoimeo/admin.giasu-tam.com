<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Tutors extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Tutors
********************************************************************/
    protected $_name        = 'Tutors';
    protected $_primary     = array('TutorId',);

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
            "TutorId"                      => "Tutors.TutorId                 = '{{param}}'",
            "UserName"                     => "Tutors.UserName                LIKE '%{{param}}%'",
            "Gender"                       => "Tutors.Gender                  = '{{param}}'",
            "Birthday"                     => "Tutors.Birthday                LIKE '%{{param}}%'",
            "Email"                        => "Tutors.Email                   LIKE '%{{param}}%'",
            "Address"                      => "Tutors.Address                 LIKE '%{{param}}%'",
            "Phone"                        => "Tutors.Phone                   = '{{param}}'",
            "Level"                        => "Tutors.Level                   = '{{param}}'",
            "University"                   => "Tutors.University              LIKE '%{{param}}%'",
            "Subject"                      => "Tutors.Subject                 LIKE '%{{param}}%'",
            "Graduation"                   => "Tutors.Graduation              LIKE '%{{param}}%'",
            "Career"                       => "Tutors.Career                  = '{{param}}'",
            "Introduction"                 => "Tutors.Introduction            LIKE '%{{param}}%'",
            "CreatedDate"                  => "Tutors.CreatedDate             = '{{param}}'",
            "IsDisabled"                   => "Tutors.IsDisabled              = '{{param}}'",
            "Avatar"                       => "Tutors.Avatar                  LIKE '%{{param}}%'",
            "Status"                       => "Tutors.Status                  = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "TutorId_Sort"                 => "Tutors.TutorId                 {{param}}",
            "UserName_Sort"                => "Tutors.UserName                {{param}}",
            "Gender_Sort"                  => "Tutors.Gender                  {{param}}",
            "Birthday_Sort"                => "Tutors.Birthday                {{param}}",
            "Email_Sort"                   => "Tutors.Email                   {{param}}",
            "Address_Sort"                 => "Tutors.Address                 {{param}}",
            "Phone_Sort"                   => "Tutors.Phone                   {{param}}",
            "Level_Sort"                   => "Tutors.Level                   {{param}}",
            "University_Sort"              => "Tutors.University              {{param}}",
            "Subject_Sort"                 => "Tutors.Subject                 {{param}}",
            "Graduation_Sort"              => "Tutors.Graduation              {{param}}",
            "Career_Sort"                  => "Tutors.Career                  {{param}}",
            "Introduction_Sort"            => "Tutors.Introduction            {{param}}",
            "CreatedDate_Sort"             => "Tutors.CreatedDate             {{param}}",
            "IsDisabled_Sort"              => "Tutors.IsDisabled              {{param}}",
            "Avatar_Sort"                  => "Tutors.Avatar                  {{param}}",
            "Status_Sort"                  => "Tutors.Status                  {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/


}