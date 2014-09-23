<?php

class Application_Form_Core_Configs extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $configId = new Zend_Form_Element_Hidden('ConfigId');
        $configId->setDecorators(array('ViewHelper'));
        $this->addElement($configId);

        $configName = new Zend_Form_Element_Text('ConfigName');
        $configName->setLabel('ConfigName');
        $configName->addFilter('StringTrim');
        $configName->setRequired(true);
        $configName->setDecorators(array('ViewHelper'));
        $this->addElement($configName);

        $configCode = new Zend_Form_Element_Text('ConfigCode');
        $configCode->setLabel('ConfigCode');
        $configCode->addFilter('StringTrim');
        $configCode->setRequired(true);
        $configCode->setDecorators(array('ViewHelper'));
        $this->addElement($configCode);

        $configValue = new Zend_Form_Element_Text('ConfigValue');
        $configValue->setLabel('ConfigValue');
        $configValue->addFilter('StringTrim');
        $configValue->setRequired(true);
        $configValue->setDecorators(array('ViewHelper'));
        $this->addElement($configValue);

        $configCategoryId = new Zend_Form_Element_Select('ConfigCategoryId');
        $configCategoryId->setLabel('ConfigCategoryId');
        $configCategoryId->addFilter('StringTrim');
        $configCategoryId->addValidator('Int');
        $configCategoryId->setRequired(true);
        $configCategoryId->setDecorators(array('ViewHelper'));
        $this->addElement($configCategoryId);

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
        $lastUpdated->addValidator('Date');
        $lastUpdated->setRequired(false);
        $lastUpdated->setAttrib('disabled', true);
        $lastUpdated->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdated);

        $lastUpdatedBy = new Zend_Form_Element_Text('LastUpdatedBy');
        $lastUpdatedBy->setLabel('LastUpdatedBy');
        $lastUpdatedBy->addFilter('StringTrim');
        $lastUpdatedBy->addValidator('Int');
        $lastUpdatedBy->setRequired(false);
        $lastUpdatedBy->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdatedBy);
        
        $submit = new Zend_Form_Element_Submit('Save');
        $submit->setLabel('Save');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setDecorators(array('ViewHelper'));
        $this->addElement($submit);
        
        $reset = new Zend_Form_Element_Reset('Reset');
        $reset->setLabel('Reset');
        $reset->setAttrib('class', 'btn btn-primary');
        $reset->setDecorators(array('ViewHelper'));
        $this->addElement($reset);
    }
    
    public function changeModeToAdd() {
    	//$this->removeElement('ConfigId');
    	//$this->removeElement('CreatedDate');
    	$this->getElement('Save')->setLabel('Add');
    	 
    	$cateModel =  new Application_Model_Core_ConfigCategories();
    	$this->getElement('ConfigCategoryId')
    	->addMultiOptions($cateModel->getFormPairs());
    }
    
    public function changeModeToUpdate($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('ConfigCode')->setRequired(false);
    	$this->getElement('ConfigCode')->setAttrib('disabled', true);
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    
    	$cateModel =  new Application_Model_Core_ConfigCategories();
    	$this->getElement('ConfigCategoryId')
    	->addMultiOptions($cateModel->getFormPairs($cateId));
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    	
    	$cateModel =  new Application_Model_Core_ConfigCategories();
    	$this->getElement('ConfigCategoryId')
    	->addMultiOptions($cateModel->getFormPairs($cateId));
    }
}