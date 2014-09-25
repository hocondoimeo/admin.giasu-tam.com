<?php

class Application_Form_Core_Subjects extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $subjectId = new Zend_Form_Element_Hidden('SubjectId');
        $subjectId->setDecorators(array('ViewHelper'));
        $this->addElement($subjectId);

        $subjectName = new Zend_Form_Element_Text('SubjectName');
        $subjectName->setLabel('SubjectName');
        $subjectName->addFilter('StringTrim');
        $subjectName->setRequired(true);
        $subjectName->setDecorators(array('ViewHelper'));
        $this->addElement($subjectName);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->setRequired(true);
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