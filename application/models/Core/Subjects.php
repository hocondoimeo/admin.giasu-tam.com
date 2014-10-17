<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Subjects extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Subjects
********************************************************************/
    protected $_name        = 'Subjects';
    protected $_primary     = array('SubjectId',);

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
            "SubjectId"                    => "Subjects.SubjectId             = '{{param}}'",
            "SubjectName"                  => "Subjects.SubjectName           LIKE '%{{param}}%'",
            "IsDisabled"                   => "Subjects.IsDisabled            = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "SubjectId_Sort"               => "Subjects.SubjectId             {{param}}",
            "SubjectName_Sort"             => "Subjects.SubjectName           {{param}}",
            "IsDisabled_Sort"              => "Subjects.IsDisabled            {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/
    public function getAllAvaiabled(){
    	return $this->select()->where('IsDisabled = 0')->order("SubjectId ASC");
    }
    
    public function getSubjectName($subjectIds = ''){
    	$cols = array('SubjectId', 'SubjectName');
    	$select = $this->getQuerySelectAll(array(), $cols, array('where' => 'SubjectId  IN ('.$subjectIds.') AND IsDisabled = 0'));
    	$result = $this->fetchAll($select);
    	if(count($result)) return $result;
    	else return null;
    }
	
    public function getAvailableSubjects(){
    	$select = $this->select()->from($this,'count(SubjectId) as ASubjects');
    	$result = $this->fetchRow($select);
    	if($result) return $result->ASubjects;
    	else return null;
    }
}