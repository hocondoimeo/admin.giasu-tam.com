<?php

class Application_Form_Core_MultiConfigs extends Zend_Form
{

    /**
     * @author code generate
     * @return mixed
     */
    public function __construct($option = array())
    {
        $configName = new Zend_Form_Element_Text('MultiConfigName');
        $configName->setLabel('ConfigName');
        $configName->addFilter('StringTrim');
        $configName->setRequired(true);
        $configName->setDescription('Enter names of your selection. Eg: one, two, three...');
        $configName->setDecorators(array('ViewHelper'));
        $this->addElement($configName);

        $configCode = new Zend_Form_Element_Text('MultiConfigValue');
        $configCode->setLabel('ConfigValue');
        $configCode->addFilter('StringTrim');
        $configCode->setRequired(false);
        $configCode->setDescription('Enter values of your selection. Eg: one, two, three...');
        $configCode->setDecorators(array('ViewHelper'));
        $this->addElement($configCode);
                
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
}