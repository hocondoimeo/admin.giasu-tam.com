<?php

class Application_Form_Core_Menus extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $menuId = new Zend_Form_Element_Hidden('MenuId');
        $menuId->setDecorators(array('ViewHelper'));
        $this->addElement($menuId);

        $parentMenuId = new Zend_Form_Element_Text('ParentMenuId');
        $parentMenuId->setLabel('ParentMenuId');
        $parentMenuId->addFilter('StringTrim');
        $parentMenuId->addValidator('Int');
        $parentMenuId->setRequired(false);
        $parentMenuId->setDecorators(array('ViewHelper'));
        $this->addElement($parentMenuId);

        $menuName = new Zend_Form_Element_Text('MenuName');
        $menuName->setLabel('MenuName');
        $menuName->addFilter('StringTrim');
        $menuName->setRequired(true);
        $menuName->setDecorators(array('ViewHelper'));
        $this->addElement($menuName);

        $menuCode = new Zend_Form_Element_Text('MenuCode');
        $menuCode->setLabel('MenuCode');
        $menuCode->addFilter('StringTrim');
        $menuCode->setRequired(true);
        $menuCode->setDecorators(array('ViewHelper'));
        $this->addElement($menuCode);

        $menuUrl = new Zend_Form_Element_Text('MenuUrl');
        $menuUrl->setLabel('MenuUrl');
        $menuUrl->addFilter('StringTrim');
        $menuUrl->setRequired(true);
        $menuUrl->setDecorators(array('ViewHelper'));
        $this->addElement($menuUrl);

        $className = new Zend_Form_Element_Text('ClassName');
        $className->setLabel('ClassName');
        $className->addFilter('StringTrim');
        $className->setRequired(true);
        $className->setDecorators(array('ViewHelper'));
        $this->addElement($className);

        $position = new Zend_Form_Element_Text('Position');
        $position->setLabel('Position');
        $position->addFilter('StringTrim');
        $position->addValidator('Int');
        $position->setRequired(true);
        $position->setDecorators(array('ViewHelper'));
        $this->addElement($position);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->addValidator('Int');
        $isDisabled->setRequired(true);
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

        $lastUpdatedBy = new Zend_Form_Element_Text('LastUpdatedBy');
        $lastUpdatedBy->setLabel('LastUpdatedBy');
        $lastUpdatedBy->addFilter('StringTrim');
        $lastUpdatedBy->addValidator('Int');
        $lastUpdatedBy->setRequired(false);
        $lastUpdatedBy->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdatedBy);

        $lastUpdated = new Zend_Form_Element_Text('LastUpdated');
        $lastUpdated->setLabel('LastUpdated');
        $lastUpdated->addFilter('StringTrim');
        $lastUpdated->addValidator('Date');
        $lastUpdated->setRequired(false);
        $lastUpdated->setAttrib('disabled', true);
        $lastUpdated->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdated);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
        $createdDate->addValidator('Date');
        $createdDate->setRequired(false);
        $createdDate->setAttrib('disabled', true);
        $createdDate->setDecorators(array('ViewHelper'));
        $this->addElement($createdDate);
        
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
    	$this->removeElement('LastUpdated');
    	$this->removeElement('CreatedDate');
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