<?php

class Application_Form_Core_Images extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $imageId = new Zend_Form_Element_Hidden('ImageId');
        $imageId->setDecorators(array('ViewHelper'));
        $this->addElement($imageId);

        $imageCode = new Zend_Form_Element_Text('ImageCode');
        $imageCode->setLabel('ImageCode');
        $imageCode->addFilter('StringTrim');
        $imageCode->setRequired(false);
        $imageCode->setDecorators(array('ViewHelper'));
        $this->addElement($imageCode);

        $imageName = new Zend_Form_Element_Text('ImageName');
        $imageName->setLabel('ImageTitle');
        $imageName->addFilter('StringTrim');
        $imageName->setRequired(true);
        $imageName->setDecorators(array('ViewHelper'));
        $this->addElement($imageName);

        $imageDesc = new Zend_Form_Element_Textarea('ImageDesc');
        $imageDesc->setLabel('ImageDesc');
        $imageDesc->setRequired(true);
        $imageDesc->setDecorators(array('ViewHelper'));
        $this->addElement($imageDesc);
        
        $imageUrl = new Zend_Form_Element_Text('ImageUrl');
        $imageUrl->setLabel('ImageUrl');
        $imageUrl->addFilter('StringTrim');
        $imageUrl->setRequired(true);
        $imageUrl->setDecorators(array('ViewHelper'));
        $this->addElement($imageUrl);

        $recommendWidth = new Zend_Form_Element_Text('RecommendWidth');
        $recommendWidth->setLabel('RecommendWidth');
        $recommendWidth->addFilter('StringTrim');
        $recommendWidth->addValidator('Int');
        $recommendWidth->setRequired(true);
        $recommendWidth->setDecorators(array('ViewHelper'));
        $this->addElement($recommendWidth);

        $recommendHeight = new Zend_Form_Element_Text('RecommendHeight');
        $recommendHeight->setLabel('RecommendHeight');
        $recommendHeight->addFilter('StringTrim');
        $recommendHeight->addValidator('Int');
        $recommendHeight->setRequired(true);
        $recommendHeight->setDecorators(array('ViewHelper'));
        $this->addElement($recommendHeight);

        $section = new Zend_Form_Element_Select('Section');
        $section->setLabel('Section');
        $section->setMultiOptions(array('Home' => 'Home', 'Contact-About' => 'Contact-About', 'Left-Banner' => 'Left-Banner', ));
        $section->setRequired(false);
        $section->setDecorators(array('ViewHelper'));
        $this->addElement($section);
        
        $isDisabled = new Zend_Form_Element_Checkbox('IsDisabled');
        $isDisabled->setLabel('Disabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

        $lastUpdated = new Zend_Form_Element_Text('LastUpdated');
        $lastUpdated->setLabel('LastUpdated');
        $lastUpdated->addFilter('StringTrim');
        $lastUpdated->setRequired(false);
        $lastUpdated->setAttrib('disabled', true);
        $lastUpdated->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdated);

        $lastUpdatedBy = new Zend_Form_Element_Text('LastUpdatedBy');
        $lastUpdatedBy->setLabel('LastUpdatedBy');
        $lastUpdatedBy->addFilter('StringTrim');
        $lastUpdatedBy->setRequired(false);
        $lastUpdatedBy->setAttrib('disabled', true);
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
    	$this->removeElement('LastUpdated');
    	$this->removeElement('LastUpdatedBy');
    	$this->getElement('Save')->setLabel('Add');
    }
    
    public function changeModeToUpdate($menuId) {
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