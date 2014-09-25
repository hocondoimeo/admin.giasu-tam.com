<?php

class Application_Form_Core_Districts extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $districtId = new Zend_Form_Element_Hidden('DistrictId');
        $districtId->setDecorators(array('ViewHelper'));
        $this->addElement($districtId);

        $districtName = new Zend_Form_Element_Text('DistrictName');
        $districtName->setLabel('DistrictName');
        $districtName->addFilter('StringTrim');
        $districtName->setRequired(true);
        $districtName->setDecorators(array('ViewHelper'));
        $this->addElement($districtName);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
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