<?php

class Application_Form_Core_Contacts extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $contactId = new Zend_Form_Element_Hidden('ContactId');
        $contactId->setDecorators(array('ViewHelper'));
        $this->addElement($contactId);

        $contactName = new Zend_Form_Element_Text('ContactName');
        $contactName->setLabel('ContactName');
        $contactName->addFilter('StringTrim');
        $contactName->setRequired(true);
        $contactName->setDecorators(array('ViewHelper'));
        $this->addElement($contactName);

        $contactContent = new Zend_Form_Element_Textarea('ContactContent');
        $contactContent->setLabel('ContactContent');
        $contactContent->setRequired(true);
        $contactContent->setDecorators(array('ViewHelper'));
        $this->addElement($contactContent);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
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

        $userId = new Zend_Form_Element_Text('UserId');
        $userId->setLabel('UserId');
        $userId->addFilter('StringTrim');
        $userId->setAttrib('disabled', true);
        $userId->setDecorators(array('ViewHelper'));
        $this->addElement($userId);

        $contactPhone = new Zend_Form_Element_Text('ContactPhone');
        $contactPhone->setLabel('ContactPhone');
        $contactPhone->addFilter('StringTrim');
        $contactPhone->setRequired(true);
        $contactPhone->setDecorators(array('ViewHelper'));
        $this->addElement($contactPhone);

        $contactTitle = new Zend_Form_Element_Text('ContactTitle');
        $contactTitle->setLabel('ContactTitle');
        $contactTitle->addFilter('StringTrim');
        $contactTitle->setRequired(true);
        $contactTitle->setDecorators(array('ViewHelper'));
        $this->addElement($contactTitle);

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