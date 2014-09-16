<?php

class Application_Form_Core_News extends Zend_Form
{
	protected $_cateModel;
		
    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    { 	
    	
        $newsId = new Zend_Form_Element_Hidden('NewsId');
        $newsId->setDecorators(array('ViewHelper'));
        $this->addElement($newsId);

        $title = new Zend_Form_Element_Text('Title');
        $title->setLabel('Title');
        $title->addFilter('StringTrim');
        $title->setRequired(true);
        $title->setDecorators(array('ViewHelper'));
        $this->addElement($title);

        $summary = new Zend_Form_Element_Textarea('Summary');
        $summary->setLabel('Summary');
        $summary->setRequired(true);
        $summary->setDecorators(array('ViewHelper'));
        $this->addElement($summary);

        $staffId = new Zend_Form_Element_Text('UserId');
        $staffId->setLabel('UserId');
        $staffId->addFilter('StringTrim');
        $staffId->addValidator('Int');
        $staffId->setRequired(true);
        $staffId->setDecorators(array('ViewHelper'));
        //$this->addElement($staffId);

        $content = new Zend_Form_Element_Textarea('Content');
        $content->setLabel('Content');
        $content->setRequired(true);
        $content->setDecorators(array('ViewHelper'));
        $this->addElement($content);

        $imageUrl = new Zend_Form_Element_Text('ImageUrl');
        $imageUrl->setLabel('ImageUrl');
        $imageUrl->addFilter('StringTrim');
        $imageUrl->setRequired(false);
        $imageUrl->setDecorators(array('ViewHelper'));
        $this->addElement($imageUrl);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
        $createdDate->addValidator('Date');
        $createdDate->setRequired(true);
        $createdDate->setDecorators(array('ViewHelper'));
        $this->addElement($createdDate);

        $isPrivate = new Zend_Form_Element_Text('IsPrivate');
        $isPrivate->setLabel('IsPrivate');
        $isPrivate->addFilter('StringTrim');
        $isPrivate->addValidator('Int');
        $isPrivate->setRequired(false);
        $isPrivate->setDecorators(array('ViewHelper'));
        $this->addElement($isPrivate);

        
        
        $newsCategoryId = new Zend_Form_Element_Select('NewsCategoryId');
        $newsCategoryId->setLabel('NewsCategoryId');
        $newsCategoryId->addFilter('StringTrim');
        $newsCategoryId->addValidator('Int');
        $newsCategoryId->setRequired(true);
        $newsCategoryId->setDecorators(array('ViewHelper'));
        $this->addElement($newsCategoryId);
        
        $submit = new Zend_Form_Element_Submit('Submit');
        $submit->setLabel('Submit');
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
    	$this->getElement('Submit')->setLabel('Add');
    	
    	$cateModel =  new Application_Model_Core_NewsCategories();
    	$this->getElement('NewsCategoryId')
    	->addMultiOptions($cateModel->getFormPairs());
    }
    
    public function changeModeToUpdate($cateId) {
    	$this->removeElement('CreatedDate');
    	$this->getElement('Submit')->setLabel('Save changes');    
    
    	$cateModel =  new Application_Model_Core_NewsCategories();
    	$this->getElement('NewsCategoryId')
    	->addMultiOptions($cateModel->getFormPairs($cateId));
    }
}