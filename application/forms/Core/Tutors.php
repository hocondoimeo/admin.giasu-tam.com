<?php

class Application_Form_Core_Tutors extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $tutorId = new Zend_Form_Element_Hidden('TutorId');
        $tutorId->setDecorators(array('ViewHelper'));
        $this->addElement($tutorId);

        $userName = new Zend_Form_Element_Text('UserName');
        $userName->setLabel('UserName');
        $userName->addFilter('StringTrim');
        $userName->setRequired(true);
        $userName->setDecorators(array('ViewHelper'));
        $this->addElement($userName);

        $gender = new Zend_Form_Element_Select('Gender');
        $gender->setLabel('Gender');
        $gender->addFilter('StringTrim');
        $gender->addValidator('Int');
        $gender->setRequired(false);
        $gender->setMultiOptions(array('1'=>'Male', '0'=>'Female'));
        $gender->setDecorators(array('ViewHelper'));
        $this->addElement($gender);

        $birthday = new Zend_Form_Element_Text('Birthday');
        $birthday->setLabel('Birthday');
        $birthday->addFilter('StringTrim');
        $birthday->setRequired(true);
        $birthday->setDecorators(array('ViewHelper'));
        $this->addElement($birthday);

        $email = new Zend_Form_Element_Text('Email');
        $email->setLabel('Email');
        $email->addFilter('StringTrim');
        $email->setRequired(true);
        $email->setDecorators(array('ViewHelper'));
        $this->addElement($email);

        $address = new Zend_Form_Element_Text('Address');
        $address->setLabel('Address');
        $address->addFilter('StringTrim');
        $address->setRequired(true);
        $address->setDecorators(array('ViewHelper'));
        $this->addElement($address);

        $phone = new Zend_Form_Element_Text('Phone');
        $phone->setLabel('Phone');
        $phone->addFilter('StringTrim');
        //$phone->addValidator('Int');
        $phone->setRequired(true);
        $phone->setDecorators(array('ViewHelper'));
        $phone->addValidator('stringLength', false, array(6, 50, "messages" => "Phone contains 6-50 characters long"));
        $this->addElement($phone);

        $level = new Zend_Form_Element_Select('Level');
        $level->setLabel('Level');
        $level->addFilter('StringTrim');
        $level->addValidator('Int');
        $level->setRequired(true);
        $level->setDecorators(array('ViewHelper'));
        $level->addMultiOptions(unserialize(TUTOR_LEVELS));
        $this->addElement($level);

        $university = new Zend_Form_Element_Text('University');
        $university->setLabel('University');
        $university->addFilter('StringTrim');
        $university->setRequired(true);
        $university->setDecorators(array('ViewHelper'));
        $this->addElement($university);

        $subject = new Zend_Form_Element_Text('Subject');
        $subject->setLabel('Subject');
        $subject->addFilter('StringTrim');
        $subject->setRequired(true);
        $subject->setDecorators(array('ViewHelper'));
        $this->addElement($subject);

        $graduation = new Zend_Form_Element_Text('Graduation');
        $graduation->setLabel('Graduation');
        $graduation->addFilter('StringTrim');
        $graduation->setRequired(true);
        $graduation->setDecorators(array('ViewHelper'));
        $this->addElement($graduation);

        $career = new Zend_Form_Element_Select('Career');
        $career->setLabel('Career');
        $career->addFilter('StringTrim');
        $career->addValidator('Int');
        $career->setRequired(false);
        $career->setDecorators(array('ViewHelper'));
        $career->addMultiOptions(unserialize(TUTOR_CAREERS));
        $this->addElement($career);

        $introduction = new Zend_Form_Element_Textarea('Introduction');
        $introduction->setLabel('Introduction');
        $introduction->setRequired(false);
        $introduction->setDecorators(array('ViewHelper'));
        $this->addElement($introduction);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
        $createdDate->addValidator('Date');
        $createdDate->setAttrib('disabled', true);
        $createdDate->setDecorators(array('ViewHelper'));
        $this->addElement($createdDate);

        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('Disabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->addValidator('Int');
        $isDisabled->setRequired(false);
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

        $avatar = new Zend_Form_Element_Text('Avatar');
        $avatar->setLabel('Avatar');
        $avatar->addFilter('StringTrim');
        $avatar->setRequired(false);
        $avatar->setDecorators(array('ViewHelper'));
        $this->addElement($avatar);

        $status = new Zend_Form_Element_Checkbox('Status');
        $status->setLabel('Status');
        $status->addFilter('StringTrim');
        $status->addValidator('Int');
        $status->setRequired(false);
        $status->setDecorators(array('ViewHelper'));
        $this->addElement($status);
        
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
    	$this->removeElement('CreatedDate');
    	$this->getElement('Save')->setLabel('Add');
    	$email = $this->getElement('Email');
    	$email->addValidator(new Zend_Validate_Db_NoRecordExists("Tutors","Email"));
    	$email->addValidator('EmailAddress', true);
    	$email->setRequired(true)->addValidator('NotEmpty',true,array('messages'=>array('isEmpty'=>"Email is whether invalid or not exist")));
    }
    
    public function changeModeToUpdate($cateId) {
    	//$this->removeElement('CreatedDate');
    	$this->removeElement('UpdatedDate');
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    }
}