<?php

class Application_Form_Core_Users extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $userId = new Zend_Form_Element_Hidden('UserId');
        $userId->setDecorators(array('ViewHelper'));
        $this->addElement($userId);

        $password = new Zend_Form_Element_Text('Password');
        $password->setLabel('Password');
        $password->addFilter('StringTrim');
        $password->setRequired(true);
        $password->setDecorators(array('ViewHelper'));
        $this->addElement($password);

        $email = new Zend_Form_Element_Text('Email');
        $email->setLabel('Email');
        $email->addFilter('StringTrim');
        //$email->setRequired(true);
        $email->addValidator(new Zend_Validate_Db_NoRecordExists("Users","Email"));
        $email->addValidator('EmailAddress', true);
        $email->setRequired(true)->addValidator('NotEmpty',true,array('messages'=>array('isEmpty'=>"Email is not valid")));
        $email->setDecorators(array('ViewHelper'));
        $this->addElement($email);

        $lastName = new Zend_Form_Element_Text('LastName');
        $lastName->setLabel('LastName');
        $lastName->addFilter('StringTrim');
        //$lastName->setRequired(true);
        $lastName->setDecorators(array('ViewHelper'));
        $this->addElement($lastName);

        $firstName = new Zend_Form_Element_Text('FirstName');
        $firstName->setLabel('FirstName');
        $firstName->addFilter('StringTrim');
        //$firstName->setRequired(true);
        $firstName->setDecorators(array('ViewHelper'));
        $this->addElement($firstName);

        $userName = new Zend_Form_Element_Text('UserName');
        $userName->setLabel('UserName');
        $userName->addFilter('StringTrim');
        $userName->setRequired(true);
        $userName->setDecorators(array('ViewHelper'));
        $this->addElement($userName);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->addValidator('Int');
        $isDisabled->setRequired(true);
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

        $lastLogin = new Zend_Form_Element_Text('LastLogin');
        $lastLogin->setLabel('LastLogin');
        $lastLogin->addFilter('StringTrim');
        $lastLogin->addValidator('Date');
        $lastLogin->setAttrib('disabled', true);
        $lastLogin->setDecorators(array('ViewHelper'));
        $this->addElement($lastLogin);
        
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
    	//$this->removeElement('UserId');
    	//$this->removeElement('CreatedDate');
    	$this->getElement('Email')->setRequired(true);
    	$this->getElement('FirstName')->setRequired(true);
    	$this->getElement('LastName')->setRequired(true);
    	$this->getElement('Save')->setLabel('Add');
    }
    
    public function changeModeToUpdate($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('UpdatedDate');
    	$this->getElement('Email')->removeValidator('Db_NoRecordExists');
    	$this->getElement('Password')->setRequired(false);
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    }
}