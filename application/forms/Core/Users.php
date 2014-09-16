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
        $email->setRequired(true);
        $email->setDecorators(array('ViewHelper'));
        $this->addElement($email);

        $lastName = new Zend_Form_Element_Text('LastName');
        $lastName->setLabel('LastName');
        $lastName->addFilter('StringTrim');
        $lastName->setRequired(true);
        $lastName->setDecorators(array('ViewHelper'));
        $this->addElement($lastName);

        $firstName = new Zend_Form_Element_Text('FirstName');
        $firstName->setLabel('FirstName');
        $firstName->addFilter('StringTrim');
        $firstName->setRequired(true);
        $firstName->setDecorators(array('ViewHelper'));
        $this->addElement($firstName);

        $userName = new Zend_Form_Element_Text('UserName');
        $userName->setLabel('UserName');
        $userName->addFilter('StringTrim');
        $userName->setRequired(true);
        $userName->setDecorators(array('ViewHelper'));
        $this->addElement($userName);

        $isDisabled = new Zend_Form_Element_Text('IsDisabled');
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
        $lastLogin->setRequired(true);
        $lastLogin->setDecorators(array('ViewHelper'));
        $this->addElement($lastLogin);

    }
}