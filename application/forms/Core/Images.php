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
        $imageName->setLabel('ImageName');
        $imageName->addFilter('StringTrim');
        $imageName->setRequired(true);
        $imageName->setDecorators(array('ViewHelper'));
        $this->addElement($imageName);

        $imageDesc = new Zend_Form_Element_Textarea('ImageDesc');
        $imageDesc->setLabel('ImageDesc');
        $imageDesc->setRequired(true);
        $imageDesc->setDecorators(array('ViewHelper'));
        $this->addElement($imageDesc);

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
        $section->setMultiOptions(array('Contact-About' => 'Contact-About', 'Home' => 'Home', 'People' => 'People', 'Technology' => 'Technology'));
        $section->setRequired(false);
        $section->setDecorators(array('ViewHelper'));
        $this->addElement($section);

        $lastUpdated = new Zend_Form_Element_Text('LastUpdated');
        $lastUpdated->setLabel('LastUpdated');
        $lastUpdated->addFilter('StringTrim');
        $lastUpdated->addValidator('Date');
        $lastUpdated->setRequired(true);
        $lastUpdated->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdated);

        $lastUpdatedBy = new Zend_Form_Element_Text('LastUpdatedBy');
        $lastUpdatedBy->setLabel('LastUpdatedBy');
        $lastUpdatedBy->addFilter('StringTrim');
        $lastUpdatedBy->addValidator('Int');
        $lastUpdatedBy->setRequired(true);
        $lastUpdatedBy->setDecorators(array('ViewHelper'));
        $this->addElement($lastUpdatedBy);

    }
}