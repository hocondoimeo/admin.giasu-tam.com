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

        $career = new Zend_Form_Element_Select('Career');
        $career->setLabel('Career');
        $career->addFilter('StringTrim');
        $career->addValidator('Int');
        $career->setRequired(false);
        $career->setDecorators(array('ViewHelper'));
        $career->addMultiOptions(unserialize(TUTOR_CAREERS));
        $this->addElement($career);

        $experienceYears  = new Zend_Form_Element_Select('ExperienceYears');
        $experienceYears->setLabel('ExperienceYears *');
        $experienceYears->addFilter('StringTrim');
        $experienceYears->setRequired(false);
        $experienceYears->setDecorators(array('ViewHelper'));
        $options = unserialize(EXPERIENCE_YEAR);
        //$experienceYears->addMultiOptions(array_combine($options, $options));
        $experienceYears->setMultiOptions(unserialize(EXPERIENCE_YEAR));
        $this->addElement($experienceYears);
        
        $careerLocation  = new Zend_Form_Element_Text('CareerLocation');
        $careerLocation->setLabel('CareerLocation *');
        $careerLocation->addFilter('StringTrim');
        $careerLocation->setRequired(false);
        $careerLocation->setDecorators(array('ViewHelper'));
        $careerLocation->addValidator('stringLength', false, array(1, 100, "messages" => "CareerLocation limits 100 characters"));
        $this->addElement($careerLocation);
        
        $teachableInClass = new Zend_Form_Element_Text('TeachableInClass');
        $teachableInClass->setLabel('TeachableInClass');
        $teachableInClass->addFilter('StringTrim');
        $teachableInClass->setRequired(false);
        $teachableInClass->setAttrib('disabled', true);
        $teachableInClass->setDescription('<a id="grades-modal" class="btn btn-info" title="Choose grade">...</a>');
        $teachableInClass->setDecorators(array(
        		'ViewHelper',
        		array('Description', array('escape' => false, 'tag' => 'span', 'id' => 'desc')),
        		array(array('control' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element-control col-lg-6')),
        		array('Label', array('class' => 'control-label col-lg-2')),
        		array(array('controls' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group'))
        ));
        $this->addElement($teachableInClass);
        
        $teachableSubjects = new Zend_Form_Element_Text('TeachableSubjects');
        $teachableSubjects->setLabel('TeachableSubjects');
        $teachableSubjects->addFilter('StringTrim');
        $teachableSubjects->setRequired(false);
        $teachableSubjects->setAttrib('disabled', true);
        $teachableSubjects->setDescription('<a id="subjects-modal" class="btn btn-info" title="Choose subject">...</a>');
        $teachableSubjects->setDecorators(array(
        		'ViewHelper',
        		array('Description', array('escape' => false, 'tag' => 'span', 'id' => 'desc')),
        		array(array('control' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element-control col-lg-6')),
        		array('Label', array('class' => 'control-label col-lg-2')),
        		array(array('controls' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group'))
        ));
        $this->addElement($teachableSubjects);
        
        $teachableDistricts = new Zend_Form_Element_Text('TeachableDistricts');
        $teachableDistricts->setLabel('TeachableDistricts');
        $teachableDistricts->addFilter('StringTrim');
        $teachableDistricts->setRequired(false);
        $teachableDistricts->setAttrib('disabled', true);
        $teachableDistricts->setDescription('<span id="districts-modal" class="btn btn-info" title="Choose district">...</span>');
        $teachableDistricts->setDecorators(array(
        		'ViewHelper',
        		array('Description', array('escape' => false, 'tag' => 'span', 'id' => 'desc')),
        		array(array('control' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element-control col-lg-6')),
        		array('Label', array('class' => 'control-label col-lg-2')),
        		array(array('controls' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form-group'))
        ));
        $this->addElement($teachableDistricts);

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
    
    public function changeModeToUpdate($tutorGrades, $tutorSubjects, $tutorDistricts) {
    	function array2string($haystack, $needle, $name){
    		$str="";
    		foreach($haystack as $k=>$i){
    			if(is_array($i)){
    				if(in_array($i[$name.'Id'], $needle))
    					$str.= ','.$i[$name.'Name'];
    				$str.=array2string($i, $needle, $name);
    			}
    		}
    		return $str;
    	}
    	//$this->removeElement('CreatedDate');
    	$this->removeElement('UpdatedDate');
    	
    	$gradeModel = new Application_Model_Core_Grades();
    	$grades = $gradeModel->fetchAll($gradeModel->getAllAvaiabled());
    	$gradeNames = trim(array2string($grades->toArray(), explode(',', $tutorGrades), 'Grade'), ',');
    	$this->getElement('TeachableInClass')->setValue($gradeNames);
    	$this->getElement('TeachableInClass')->setAttrib('subs', $tutorGrades);
    	
    	$subjectModel = new Application_Model_Core_Subjects();
    	$subjects = $subjectModel->fetchAll($subjectModel->getAllAvaiabled());
    	$subjectNames = trim(array2string($subjects->toArray(), explode(',', $tutorSubjects), 'Subject'), ',');
    	$this->getElement('TeachableSubjects')->setValue($subjectNames);
    	$this->getElement('TeachableSubjects')->setAttrib('subs', $tutorSubjects);
    	
    	$districtModel = new Application_Model_Core_Districts();
    	$districts = $districtModel->fetchAll($districtModel->getAllAvaiabled());
    	$districtNames = trim(array2string($districts->toArray(), explode(',', $tutorDistricts), 'District'), ',');
    	$this->getElement('TeachableDistricts')->setValue($districtNames);
    	$this->getElement('TeachableDistricts')->setAttrib('subs', $tutorDistricts);
    	
    	$this->getElement('Save')->setLabel('Update')->setAttrib('class', 'btn btn-warning');
    }
    
    public function changeModeToDelete($cateId) {
    	//$this->removeElement('CreatedDate');
    	//$this->removeElement('LastUpdated');
    	$this->getElement('Save')->setLabel('Delete')->setAttrib('class', 'btn btn-danger');
    }
    
    public function changeModeToClass($grades, $gradesText) {
    	$this->getElement('TeachableInClass')->setValue($gradesText);
    	$this->getElement('TeachableInClass')->setAttrib('subs', $grades);
    }
    
    public function changeModeToSubjects($subjects, $subjectsText) {
    	$this->getElement('TeachableSubjects')->setValue($subjectsText);
    	$this->getElement('TeachableSubjects')->setAttrib('subs', $subjects);
    }
    
    public function changeModeToDistricts($districts, $districtsText) {
    	$this->getElement('TeachableDistricts')->setValue($districtsText);
    	$this->getElement('TeachableDistricts')->setAttrib('subs', $districts);
    }
}