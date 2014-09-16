<?php

class Application_Form_Core_NewsCategories extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $newsCategoryId = new Zend_Form_Element_Hidden('NewsCategoryId');
        $newsCategoryId->setDecorators(array('ViewHelper'));
        $this->addElement($newsCategoryId);

        $newsCategoryName = new Zend_Form_Element_Text('NewsCategoryName');
        $newsCategoryName->setLabel('NewsCategoryName');
        $newsCategoryName->addFilter('StringTrim');
        $newsCategoryName->setRequired(true);
        $newsCategoryName->setDecorators(array('ViewHelper'));
        $this->addElement($newsCategoryName);

        $newsCategoryCode = new Zend_Form_Element_Text('NewsCategoryCode');
        $newsCategoryCode->setLabel('NewsCategoryCode');
        $newsCategoryCode->addFilter('StringTrim');
        $newsCategoryCode->setRequired(true);
        $newsCategoryCode->setDecorators(array('ViewHelper'));
        $this->addElement($newsCategoryCode);

        $createdDate = new Zend_Form_Element_Text('CreatedDate');
        $createdDate->setLabel('CreatedDate');
        $createdDate->addFilter('StringTrim');
        $createdDate->addValidator('Date');
        $createdDate->setRequired(true);
        $createdDate->setDecorators(array('ViewHelper'));
        $this->addElement($createdDate);

        $isDisabled = new Zend_Form_Element_Text('IsDisabled');
        $isDisabled->setLabel('IsDisabled');
        $isDisabled->addFilter('StringTrim');
        $isDisabled->addValidator('Int');
        $isDisabled->setRequired(true);
        $isDisabled->setDecorators(array('ViewHelper'));
        $this->addElement($isDisabled);

    }
}