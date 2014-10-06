<?php

class Application_Form_Core_Grades extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $gradeId = new Zend_Form_Element_Hidden('GradeId');
        $gradeId->setDecorators(array('ViewHelper'));
        $this->addElement($gradeId);

        $gradeName = new Zend_Form_Element_Text('GradeName');
        $gradeName->setLabel('GradeName');
        $gradeName->addFilter('StringTrim');
        $gradeName->setRequired(true);
        $gradeName->setDecorators(array('ViewHelper'));
        $this->addElement($gradeName);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->addValidator('Int');
        $isDisabled->setRequired(false);
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

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
    	//$this->removeElement('LastUpdated');
    	//$this->removeElement('CreatedDate');
    	$this->getElement('Save')->setLabel('Add');
    }
    
    public function changeModeToUpdate($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	//$this->getElement('MenuCode')->setAttrib('disabled', true);
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    }
}