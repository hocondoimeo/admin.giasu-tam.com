<?php


/**
 * Controller for Configs controller
 *
 * @author  kissconcept
 * @version $Id$
 */
class ConfigsController extends Zend_Controller_Action
{
    /**
     * Init model
     */
    public function init() {
        $this->_model = new Application_Model_Core_Configs();
        //$this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    /**
    * Function show all Sites
    */
    public function indexAction() {
        $this->_helper->redirector('show-configs');
    }    
    
   /**
    * Function show all Configs
    * @return list Configs
    * @author 
    */
    public function showConfigsAction() {
        /*Get parameters filter*/
        $params            = $this->_getAllParams();
        $params['page']    = $this->_getParam('page',1);
        $params['perpage'] = $this->_getParam('perpage',NUMBER_OF_ITEM_PER_PAGE);
        $params['foreign'] = array('table' => 'ConfigCategories', 'key' => 'ConfigCategoryId', 'cols' => array('ConfigCategoryName'));
        
        /*Get all data*/
        $paginator = Zend_Paginator::factory($this->_model->getQuerySelectAll($params));
        $paginator->setCurrentPageNumber($params['page']);
        $paginator->setItemCountPerPage($params['perpage']);

        /*Assign varible to view*/
        $this->view->paginator = $paginator;
        $this->view->assign($params);
        $this->view->message = $this->_helper->flashMessenger->getMessages();
    }
    
    /**
    * Add record Configs
    * @param array $formData
    * @return
    * @author 
    */
    public function addConfigsAction() {
    	$this->view->multi = $this->_request->getParam('multi',null);
    	
        $form = new Application_Form_Core_Configs();
        $form->changeModeToAdd();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $data = $_POST;            	
            	if(!empty($data['MultiConfigName']) && !empty($data['MultiConfigValue'])){
            		$keyArr = explode(',', $data['MultiConfigName']);
            		$valueArr = explode(',', $data['MultiConfigName']);
            		$returnArr = array();
            		if(count($keyArr) && count($valueArr)){
            			$returnArr = array_combine($keyArr, $valueArr);
            			$form->changeModeToAddMulti($returnArr);
            			$this->view->multi = 1;
            		}
            	}else{
            		if(isset($formData['Section'])) unset($formData['Section']);
            		if($form->isValid($formData)) {
            			if(isset($data['MultiConfigName']) && !empty($data['MultiConfigName'])) 
            				$data['ConfigName'] .= '@Multi@'.$data['MultiConfigName']; 
            			$data['LastUpdatedBy'] = USER_ID;
            			if(isset($data['ConfigId'])) unset($data['ConfigId']);
            			 
            			if($this->_model->add($data)){
            				$msg = str_replace(array("{subject}"),array("Configs"),'success/The {subject} has been added successfully.');
            				$this->_helper->flashMessenger->addMessage($msg);
            			}
            			$this->_helper->redirector('show-configs');
            		}else{
            			if(isset($data['MultiConfigName']) && !empty($data['MultiConfigName'])){
            				$this->view->multi = 1;
            				$form->changeModeToAddMulti(unserialize($data['MultiConfigName']), $data['ConfigValue']);
            			}
            			$msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
            			foreach ($form->getMessages() as $key=>$messageFormError){
            				$msg .= '/'.$key;
            			}
            			$this->view->message = array($msg);
            		}		
            	}
        }
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-configs';        
    }
    	
    /**
    * Update record Configs.
    * @param array $formData
    * @return
    * @author 
    */
    public function updateConfigsAction() {
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-configs');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-configs');
        }
    
        $form = new Application_Form_Core_Configs();
        $multiName = ''; $multiData = '';
        if(strpos($row->ConfigName, '@Multi@') !== false){
        	$this->view->multi = 1;
        	$multi = explode('@Multi@', $row->ConfigName);
        	if(count($multi) >1){ 
        		$multiData = $multi[1];
        		$multiName = $multi[0];
        	}
        }
       $form->changeModeToUpdate($id, $multiData, $row->ConfigValue);

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	 
            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['LastUpdatedBy'] = USER_ID;
            	
            	if(isset($data['MultiConfigName']) && !empty($data['MultiConfigName']))
            		$data['ConfigName'] .= '@Multi@'.$data['MultiConfigName'];
            	
                if($this->_model->edit($data)){
                    $msg = str_replace(array("{subject}"),array("Configs"),'success/The {subject} has been updated successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
                }
                 	$this->_helper->redirector('show-configs');
            }else{
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
           }
        }else{
        	//$form->changeModeToUpdate($multiData);
        }
        $dataForm = $row->toArray();
        if(!empty($multiName)) $dataForm['ConfigName'] = $multiName;
        $form->populate($dataForm);
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-configs';
        $this->_helper->viewRenderer->setRender('add-configs');
    }
    
    /**
    * Delete record Configs.
    * @param $id
    * @return
    * @author 
    */
    public function deleteConfigsAction(){
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-configs');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-configs');
        }
       
        $form = new Application_Form_Core_Configs();
        $form->changeModeToDelete($id) ;
        
        foreach($form->getElements() as $element){
        	if($element instanceof Zend_Form_Element_Text ||
                 $element instanceof Zend_Form_Element_Checkbox ||
                 $element instanceof Zend_Form_Element_Select)
        		$element->setAttrib('disabled', true);
        }

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $id = $formData['ConfigId'];
            if(isset($id) && !empty($id) && $this->_model->deleteRow($id)) {
                    $msg = str_replace(array("{subject}"),array("Configs"),'success/The {subject} has been deleted successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
            }
                 	 $this->_helper->redirector('show-configs');
        }
         
        $this->view->id = $id;
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-configs';
        $this->_helper->viewRenderer->setRender('add-configs');
    }
    
    /**
    * Function show all Configs
    * @return list Configs
    * @author 
    */
    public function ajaxShowConfigsAction() {
        $this->_helper->layout->disableLayout();
        
        /*Get parameters filter*/
        $params            = $this->_getAllParams();
        $params['page']    = $this->_getParam('page',1);
        $params['perpage'] = $this->_getParam('perpage',20);
        
        /*Get all data*/
        $paginator = Zend_Paginator::factory($this->_model->getQuerySelectAll($params));
        $paginator->setCurrentPageNumber($params['page']);
        $paginator->setItemCountPerPage($params['perpage']);

        /*Assign varible to view*/
        $this->view->paginator = $paginator;
        $this->view->assign($params);
    }
    


    /**
     * Add record Configs
     * @param array $formData
     * @return
     * @author
     */
    public function ajaxAddMultiConfigsAction() {
    	$this->_helper->layout->disableLayout();
    	
    	$this->view->multi = $this->_request->getParam('multi',null);
    	$form = new Application_Form_Core_MultiConfigs();
    	 
    	$this->view->form = $form;
    	$this->view->showAllUrl = 'show-configs';
    }
    
   /**
    * Add record Configs
    * @param array $formData
    * @author 
    */
    public function ajaxAddConfigsAction() {
    
        $this->_helper->layout->disableLayout();
        
        $form = new Application_Form_Core_Configs();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
                if($this->_model->add($formData)){
                    die('1');
                }
            }
        }
        $form->populate($form->getValues());
        $this->view->form = $form;
    }
    
   /**
    * Update record Configs
    * @param array $formData
    * @author 
    */
    public function ajaxUpdateConfigsAction() {
    
        $this->_helper->layout->disableLayout();
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            die('0');
        }
    
        $form = new Application_Form_Core_Configs();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['ConfigId'] = $id;
            if($form->isValid($formData)) {
                if($this->_model->edit($form->getValues())){
                    die('1');
                }
            }
        }
        $form->populate($form->getValues());
        $this->view->form = $form;
    }
    
    /**
    * Delete record Configs.
    * @param $id
    * @author 
    */
    public function ajaxDeleteConfigsAction(){
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if($row) {
            if($row->delete()){
                die('1');
            }
        }
        die('0');
    }
}