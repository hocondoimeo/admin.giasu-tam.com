<?php

class Application_Form_Core_Classes extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $classId = new Zend_Form_Element_Hidden('ClassId');
        $classId->setDecorators(array('ViewHelper'));
        $this->addElement($classId);

        $classAddress = new Zend_Form_Element_Text('ClassAddress');
        $classAddress->setLabel('ClassAddress');
        $classAddress->addFilter('StringTrim');
        $classAddress->setRequired(true);
        $classAddress->setDecorators(array('ViewHelper'));
        $this->addElement($classAddress);

        $classContact = new Zend_Form_Element_Text('ClassContact');
        $classContact->setLabel('ClassContact');
        $classContact->addFilter('StringTrim');
        $classContact->setRequired(true);
        $classContact->setDecorators(array('ViewHelper'));
        $this->addElement($classContact);

        $classCost = new Zend_Form_Element_Text('ClassCost');
        $classCost->setLabel('ClassCost');
        $classCost->addFilter('StringTrim');
        //$classCost->addValidator('Int');
        $classCost->setRequired(true);
        $classCost->setDecorators(array('ViewHelper'));
        $this->addElement($classCost);

        $classDaysOfWeek = new Zend_Form_Element_Text('ClassDaysOfWeek');
        $classDaysOfWeek->setLabel('DaysOfWeek');
        $classDaysOfWeek->addFilter('StringTrim');
        //$classDaysOfWeek->addValidator('Int');
        $classDaysOfWeek->setRequired(true);
        $classDaysOfWeek->setDecorators(array('ViewHelper'));
        $this->addElement($classDaysOfWeek);

        $classTime = new Zend_Form_Element_Text('ClassTime');
        $classTime->setLabel('ClassTime');
        $classTime->addFilter('StringTrim');
        $classTime->setRequired(true);
        $classTime->setDecorators(array('ViewHelper'));
        $this->addElement($classTime);

        $classRequire = new Zend_Form_Element_Text('ClassRequire');
        $classRequire->setLabel('ClassRequire');
        $classRequire->addFilter('StringTrim');
        $classRequire->setRequired(true);
        $classRequire->setDecorators(array('ViewHelper'));
        $this->addElement($classRequire);

        $classTutors = new Zend_Form_Element_Text('ClassTutors');
        $classTutors->setLabel('ClassTutors');
        $classTutors->addFilter('StringTrim');
        $classTutors->setRequired(false);
        $classTutors->setAttrib('disabled', true);
        $classTutors->setDecorators(array('ViewHelper'));
        $this->addElement($classTutors);

        $classSubjects = new Zend_Form_Element_Text('ClassSubjects');
        $classSubjects->setLabel('ClassSubjects');
        $classSubjects->addFilter('StringTrim');
        $classSubjects->setRequired(true);
        $classSubjects->setAttrib('disabled', true);
        $classSubjects->setDecorators(array('ViewHelper'));
        $this->addElement($classSubjects);

        $classMember = new Zend_Form_Element_Text('ClassMember');
        $classMember->setLabel('ClassMember');
        $classMember->addFilter('StringTrim');
        $classMember->addValidator('Int');
        $classMember->setRequired(true);
        $classMember->setDecorators(array('ViewHelper'));
        $this->addElement($classMember);

        $classStatus = new Zend_Form_Element_Checkbox('ClassStatus');
        $classStatus->setLabel('ClassStatus');
        $classStatus->addFilter('StringTrim');
        $classStatus->setRequired(true);
        $classStatus->setDecorators(array('ViewHelper'));
        $this->addElement($classStatus);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
        $createdDate->addValidator('Date');
        $createdDate->setAttrib('disabled', true);
        $createdDate->setDecorators(array('ViewHelper'));
        $this->addElement($createdDate);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->addValidator('Int');
        $isDisabled->setRequired(true);
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

        $lastUpdated = new Zend_Form_Element_Text('LastUpdated');
        $lastUpdated->setLabel('LastUpdated');
        $lastUpdated->addFilter('StringTrim');
        $lastUpdated->setRequired(false);
        $lastUpdated->setAttrib('disabled', true);
        $lastUpdated->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdated);

        $lastUpdatedBy = new Zend_Form_Element_Text('LastUpdatedBy');
        $lastUpdatedBy->setLabel('LastUpdatedBy');
        $lastUpdatedBy->addFilter('StringTrim');
        $lastUpdatedBy->setAttrib('disabled', true);
        $lastUpdatedBy->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdatedBy);

        $save = new Zend_Form_Element_Submit('Save');
        $save->setLabel('Save');
        $save->setAttrib('class', 'btn btn-primary');
        $save->setDecorators(array('ViewHelper'));
        $this->addElement($save);

        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->setLabel('Reset');
        $reset->setAttrib('class', 'btn btn-primary');
        $reset->setDecorators(array('ViewHelper'));
        $this->addElement($reset);

    }
    
     public function changeModeToAdd() {
    	$this->removeElement('LastUpdated');
    	$this->removeElement('CreatedDate');
    	$this->getElement('Save')->setLabel('Add');
    }
    
    public function changeModeToUpdate($classSubjects) {
    	//convert object array to string for subject
    	function array2string($haystack, $needle){
    		$str="";
    		foreach($haystack as $k=>$i){
    			if(is_array($i)){
    				if(in_array($i['SubjectId'], $needle))
    					$str.= ','.$i['SubjectName'];
    				$str.=array2string($i, $needle);
    			}
    		}
    		return $str;
    	}
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$subjectModel = new Application_Model_Core_Subjects();
    	$subjects = $subjectModel->fetchAll($subjectModel->getAllAvaiabled());
    	$subjectNames = trim(array2string($subjects->toArray(), explode(',', $classSubjects)), ',');
     	$this->getElement('ClassSubjects')->setValue($subjectNames);
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    }
}