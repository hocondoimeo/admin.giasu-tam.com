<?php


/**
 * Controller for Classes controller
 *
 * @author  kissconcept
 * @version $Id$
 */
class ClassesController extends Zend_Controller_Action
{
    /**
     * Init model
     */
    public function init() {
        $this->_model = new Application_Model_Core_Classes();
        //$this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    /**
    * Function show all Sites
    */
    public function indexAction() {
        $this->_helper->redirector('show-classes');
    }    
    
   /**
    * Function show all Classes
    * @return list Classes
    * @author 
    */
    public function showClassesAction() {
        /*Get parameters filter*/
        $params            = $this->_getAllParams();
        $params['page']    = $this->_getParam('page',1);
        $params['perpage'] = $this->_getParam('perpage',NUMBER_OF_ITEM_PER_PAGE);
        
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
    * Add record Classes
    * @param array $formData
    * @return
    * @author 
    */
    public function addClassesAction() {
        $form = new Application_Form_Core_Classes();
        $form->changeModeToAdd();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	if($data['ClassStatus'] && count(explode(',', $data['ClassTutors'])) >1){
            		$msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
            		$msg .= '/Class Status is checked when Class Tutors contained only one number';
            		$this->view->message = array($msg);
            	}else{            	
	            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
	            	$data['LastUpdatedBy'] = USER_ID;
	            	if(isset($data['ClassId'])) unset($data['ClassId']);
	            	
	                if($this->_model->add($data)){
	                    $msg = str_replace(array("{subject}"),array("Classes"),'success/The {subject} has been added successfully.');
	                 	$this->_helper->flashMessenger->addMessage($msg);
	                }
                	$this->_helper->redirector('show-classes');
            	}
            }else{
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
            }
        }
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-classes';        
    }
    	
    /**
    * Update record Classes.
    * @param array $formData
    * @return
    * @author 
    */
    public function updateClassesAction() {
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-classes');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-classes');
        }
    
        $form = new Application_Form_Core_Classes();
        $form->changeModeToDistrictId();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
	            $data = $_POST;
            	if($data['ClassStatus'] && count(explode(',', $data['ClassTutors'])) > 1){
            		$msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
            		$msg .= '/Class Status is checked when Class Tutors contained only one number';
            		$this->view->message = array($msg);
            	}else{	            	
	            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
	            	$data['LastUpdatedBy'] = USER_ID;
	            	
	                if($this->_model->edit($data)){
	                    $msg = str_replace(array("{subject}"),array("Classes"),'success/The {subject} has been updated successfully.');
	                 	$this->_helper->flashMessenger->addMessage($msg);
	                }
                	$this->_helper->redirector('show-classes');
            	}
            }else{
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
           }
        }
            
        $form->populate($row->toArray());
        $form->changeModeToUpdate($row->ClassSubjects);
        
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-classes';
        $controller = ltrim(preg_replace("/([A-Z])/", "-$1", 'Classes'), '-');
        $this->_helper->viewRenderer->setRender('add-'.$controller);
    }
    
    /**
    * Delete record Classes.
    * @param $id
    * @return
    * @author 
    */
    public function deleteClassesAction(){
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-classes');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-classes');
        }
       
        $form = new Application_Form_Core_Classes();
        $form->changeModeToDelete($id) ;
        
        foreach($form->getElements() as $element){
        	if($element instanceof Zend_Form_Element_Text ||
                 $element instanceof Zend_Form_Element_Checkbox ||
                 $element instanceof Zend_Form_Element_Select ||
                 $element instanceof Zend_Form_Element_Textarea)
        		$element->setAttrib('disabled', true);
        }

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $id = $formData['ClassId'];
            if(isset($id) && !empty($id) && $this->_model->deleteRow($id)) {
                    $msg = str_replace(array("{subject}"),array("Classes"),'success/The {subject} has been deleted successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
            }
                 	 $this->_helper->redirector('show-classes');
        }
         
        $this->view->id = $id;
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-classes';
        $controller = ltrim(preg_replace("/([A-Z])/", "-$1", 'Classes'), '-');
        $this->_helper->viewRenderer->setRender('add-'.$controller);
    }
    
    /**
    * Function show all Classes
    * @return list Classes
    * @author 
    */
    public function ajaxShowClassesAction() {
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
    * Add record Classes
    * @param array $formData
    * @author 
    */
    public function ajaxAddClassesAction() {
    
        $this->_helper->layout->disableLayout();
        
        $form = new Application_Form_Core_Classes();

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
    * Update record Classes
    * @param array $formData
    * @author 
    */
    public function ajaxUpdateClassesAction() {
    
        $this->_helper->layout->disableLayout();
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            die('0');
        }
    
        $form = new Application_Form_Core_Classes();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['ClassId'] = $id;
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
    * Delete record Classes.
    * @param $id
    * @author 
    */
    public function ajaxDeleteClassesAction(){
        
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