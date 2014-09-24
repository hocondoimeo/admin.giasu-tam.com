<?php


/**
 * Controller for News controller
 *
 * @author  kissconcept
 * @version $Id$
 */
class NewsController extends Zend_Controller_Action
{
    /**
     * Init model
     */
    public function init() {
        $this->_model = new Application_Model_Core_News();
        //$this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    /**
    * Function show all Sites
    */
    public function indexAction() {
        $this->_helper->redirector('show-news');
    }    
    
   /**
    * Function show all News
    * @return list News
    * @author 
    */
    public function showNewsAction() {
        /*Get parameters filter*/
        $params            = $this->_getAllParams();
        $params['page']    = $this->_getParam('page',1);
        $params['perpage'] = $this->_getParam('perpage',NUMBER_OF_ITEM_PER_PAGE);
        $params['foreign'] = array('table' => 'NewsCategories', 'key' => 'NewsCategoryId', 'cols' => array('NewsCategoryName'));
        
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
    * Add record News
    * @param array $formData
    * @return
    * @author 
    */
    public function addNewsAction() {
        $form = new Application_Form_Core_News();
        $form->changeModeToAdd();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	
            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['LastUpdatedBy'] = USER_ID;
            	if(isset($data['NewsId'])) unset($data['NewsId']);
            	
            	//copy new image from 'tmp' to 'images' folder then remove it
            	$fileName = Common_FileUploader_qqUploadedFileXhr::copyImage($data['ImageUrl'], IMAGE_UPLOAD_PATH_TMP, IMAGE_UPLOAD_PATH);
            	//copy exist image from 'images' to 'backup' folder then remove it
            	//$fileNameBackup = Common_FileUploader_qqUploadedFileXhr::copyImage($data['OldImageName'], IMAGE_UPLOAD_PATH, IMAGE_UPLOAD_PATH_BACKUP);            	 
            	
                if($this->_model->add($data)){
                    $msg = str_replace(array("{subject}"),array("News"),'success/The {subject} has been added successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
                }else {
                	if (file_exists(IMAGE_UPLOAD_PATH_TMP.$fileName))
                		unlink(IMAGE_UPLOAD_PATH_TMP.$fileName);
                	$this->_helper->flashMessenger->addMessage(array('danger/database error'));
                }
                $this->_helper->redirector('show-news');
            }else{
            	$this->view->imageUrl = (isset($_POST['ImageUrl'])  && !empty($_POST['ImageUrl']))?$_POST['ImageUrl']:'';
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
            }
        }
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-news';
    }
    	
    /**
    * Update record News.
    * @param array $formData
    * @return
    * @author 
    */
    public function updateNewsAction() {
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-news');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-news');
        }
    
        $form = new Application_Form_Core_News();
        $form->changeModeToUpdate($id);

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();	
            if($form->isValid($formData)) {
            	$data = $_POST;
            	
            	//$data['IsDisabled'] = isset($_POST['selectStatus'])?1:0;
            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['LastUpdatedBy'] = USER_ID;
            	
            	if (($data['Avatar'] !== $data['OldImageName'])){
	            	//copy new image from 'tmp' to 'images' folder then remove it
	            	$fileName = Common_FileUploader_qqUploadedFileXhr::copyImage($data['ImageUrl'], IMAGE_UPLOAD_PATH_TMP, IMAGE_UPLOAD_PATH);
	            	//copy exist image from 'images' to 'backup' folder then remove it
	            	$fileNameBackup = Common_FileUploader_qqUploadedFileXhr::copyImage($data['OldImageName'], IMAGE_UPLOAD_PATH, IMAGE_UPLOAD_PATH_BACKUP);
            	}
            	
            	//if($fileName || $fileNameBackup){
            		if($this->_model->edit($data)){
            			$msg = str_replace(array("{subject}"),array("News"),'success/The {subject} has been updated successfully.');
                 		$this->_helper->flashMessenger->addMessage($msg);
            		}else{
            			if (($data['Avatar'] !== $data['OldImageName']) && file_exists(IMAGE_UPLOAD_PATH_TMP.$fileName))
            				unlink(IMAGE_UPLOAD_PATH_TMP.$fileName);
            			$this->_helper->flashMessenger->addMessage(array('danger/database error'));
            		}
            	/* }else
            		$this->_helper->flashMessenger->addMessage(MSG_ERROR_PHP); */
                 	$this->_helper->redirector('show-news');
            }else{
            	$this->view->imageUrl = (isset($_POST['ImageUrl'])  && !empty($_POST['ImageUrl']))?$_POST['ImageUrl']:'';
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
           }
        }
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-news';
        $this->_helper->viewRenderer->setRender('add-news');
    }
    
    /**
    * Delete record News.
    * @param $id
    * @return
    * @author 
    */
    public function deleteNewsAction(){
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-news');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-news');
        }
       
        $form = new Application_Form_Core_News();
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
            $id = $formData['NewsId'];
            if(isset($id) && !empty($id) && $this->_model->deleteRow($id)) {
            		$fileName = isset($formData['ImageUrl'])?$formData['ImageUrl']:'';
            		if (file_exists(IMAGE_UPLOAD_PATH.$fileName))
            			unlink(IMAGE_UPLOAD_PATH.$fileName);
                    $msg = str_replace(array("{subject}"),array("News"),'success/The {subject} has been deleted successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
            }
                 	 $this->_helper->redirector('show-news');
        }
         
        $this->view->id = $id;
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-news';
        $this->_helper->viewRenderer->setRender('add-news');
    }
    
    /**
     * Function upload image
     * @return json string
     * @author
     */
    
    public function ajaxUploadAction(){
    	$this->_helper->layout->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    
    	if ($this->_request->isPost()) {
	    		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
	    		$allowedExtensions = unserialize(IMAGE_ALLOWED_EXT);
	    		// max file size in bytes
	    		$sizeLimit = IMAGE_SIZE_LIMIT * 1024;
	    
	    		$uploader = new Common_FileUploader_qqFileUploader($allowedExtensions, $sizeLimit);
	    		$result = $uploader->handleUpload(IMAGE_UPLOAD_PATH_TMP, true);
	    		// to pass data through iframe you will need to encode all html tags
	    		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	    	}else
	    		echo '{success:true}';
	    }
    
    /**
    * Function show all News
    * @return list News
    * @author 
    */
    public function ajaxShowNewsAction() {
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
    * Add record News
    * @param array $formData
    * @author 
    */
    public function ajaxAddNewsAction() {
    
        $this->_helper->layout->disableLayout();
        
        $form = new Application_Form_Core_News();

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
    * Update record News
    * @param array $formData
    * @author 
    */
    public function ajaxUpdateNewsAction() {
    
        $this->_helper->layout->disableLayout();
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            die('0');
        }
    
        $form = new Application_Form_Core_News();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['NewsId'] = $id;
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
    * Delete record News.
    * @param $id
    * @author 
    */
    public function ajaxDeleteNewsAction(){
        
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