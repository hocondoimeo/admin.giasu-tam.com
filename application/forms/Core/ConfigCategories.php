<?php

class Application_Form_Core_ConfigCategories extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $configCategoryId = new Zend_Form_Element_Hidden('ConfigCategoryId');
        $configCategoryId->setDecorators(array('ViewHelper'));
        $this->addElement($configCategoryId);

        $configCategoryName = new Zend_Form_Element_Text('ConfigCategoryName');
        $configCategoryName->setLabel('ConfigCategoryName');
        $configCategoryName->addFilter('StringTrim');
        $configCategoryName->setRequired(true);
        $configCategoryName->setDecorators(array('ViewHelper'));
        $this->addElement($configCategoryName);

        $configCategoryCode = new Zend_Form_Element_Text('ConfigCategoryCode');
        $configCategoryCode->setLabel('ConfigCategoryCode');
        $configCategoryCode->addFilter('StringTrim');
        $configCategoryCode->setRequired(true);
        $configCategoryCode->setDecorators(array('ViewHelper'));
        $this->addElement($configCategoryCode);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
        $createdDate->addValidator('Date');
        $createdDate->setRequired(false);
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

        $submit = new Zend_Form_Element_Submit('Save');
        $submit->setLabel('Save');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setDecorators(array('ViewHelper'));
        //$submit->setDescription('Cancel');
        //$submit->setDecorators(array('ViewHelper',
		//array('Description', array('tag'=>'button', 'onclick'=>"javascript:window.history.back()"))));
        $this->addElement($submit);
        
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
    
    public function changeModeToUpdate($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    }
}