<?php


/**
 * Controller for Images controller
 *
 * @author  kissconcept
 * @version $Id$
 */
class ImagesController extends Zend_Controller_Action
{
    /**
     * Init model
     */
    public function init() {
        $this->_model = new Application_Model_Core_Images();
        //$this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    /**
    * Function show all Sites
    */
    public function indexAction() {
        $this->_helper->redirector('show-images');
    }    
    
   /**
    * Function show all Images
    * @return list Images
    * @author 
    */
    public function showImagesAction() {
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
    * Add record Images
    * @param array $formData
    * @return
    * @author 
    */
    public function addImagesAction() {
        $form = new Application_Form_Core_Images();
        $form->changeModeToAdd();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	
            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['LastUpdatedBy'] = USER_ID;
            	if(isset($data['ImageId'])) unset($data['ImageId']);
            	
            	//copy new image from 'tmp' to 'images' folder then remove it
            	$fileName = Common_FileUploader_qqUploadedFileXhr::copyImage($data['ImageUrl'], IMAGE_CAROUSEL_UPLOAD_TMP, IMAGE_CAROUSEL_UPLOAD_PATH);
            	//copy exist image from 'images' to 'backup' folder then remove it
            	//$fileNameBackup = Common_FileUploader_qqUploadedFileXhr::copyImage($data['OldImageName'], IMAGE_CAROUSEL_UPLOAD_PATH, IMAGE_CAROUSEL_UPLOAD_BACKUP);
            	
                if($this->_model->add($data)){
                    $msg = str_replace(array("{subject}"),array("Images"),'success/The {subject} has been added successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
                }
                $this->_helper->redirector('show-images');
            }else{
            	if (file_exists(IMAGE_CAROUSEL_UPLOAD_TMP.$fileName))
            		unlink(IMAGE_CAROUSEL_UPLOAD_TMP.$fileName);
            	$this->view->imageUrl = (isset($_POST['ImageUrl'])  && !empty($_POST['ImageUrl']))?$_POST['ImageUrl']:'';
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
            }
        }
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-images';        
    }
    	
    /**
    * Update record Images.
    * @param array $formData
    * @return
    * @author 
    */
    public function updateImagesAction() {
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-images');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-images');
        }
    
        $form = new Application_Form_Core_Images();
        $form->changeModeToUpdate($id);

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	
            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['LastUpdatedBy'] = USER_ID;
            	
            	if (($data['ImageUrl'] !== $data['OldImageName'])){
            		//copy new image from 'tmp' to 'images' folder then remove it
            		$fileName = Common_FileUploader_qqUploadedFileXhr::copyImage($data['ImageUrl'], IMAGE_CAROUSEL_UPLOAD_TMP, IMAGE_CAROUSEL_UPLOAD_PATH);
            		//copy exist image from 'images' to 'backup' folder then remove it
            		if($data['OldImageName'] !== 'none.gif')
            			$fileNameBackup = Common_FileUploader_qqUploadedFileXhr::copyImage($data['OldImageName'], IMAGE_CAROUSEL_UPLOAD_PATH, IMAGE_CAROUSEL_UPLOAD_BACKUP);
            	}
            	
                if($this->_model->edit($data)){
                    $msg = str_replace(array("{subject}"),array("Images"),'success/The {subject} has been updated successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
                }
                 	$this->_helper->redirector('show-images');
            }else{
            	if (($data['ImageUrl'] !== $data['OldImageName']) && file_exists(IMAGE_CAROUSEL_UPLOAD_TMP.$fileName))
            		unlink(IMAGE_CAROUSEL_UPLOAD_TMP.$fileName);
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
        $this->view->showAllUrl = 'show-images';
        $controller = ltrim(preg_replace("/([A-Z])/", "-$1", 'Images'), '-');
        $this->_helper->viewRenderer->setRender('add-'.$controller);
    }
    
    /**
    * Delete record Images.
    * @param $id
    * @return
    * @author 
    */
    public function deleteImagesAction(){
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-images');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-images');
        }
       
        $form = new Application_Form_Core_Images();
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
            $id = $formData['ImageId'];
            if(isset($id) && !empty($id) && $this->_model->deleteRow($id)) {
	            	if (!empty($row->ImageUrl) && file_exists(IMAGE_CAROUSEL_UPLOAD_PATH.$row->ImageUrl))
	            		unlink(IMAGE_CAROUSEL_UPLOAD_PATH.$row->ImageUrl);
                    $msg = str_replace(array("{subject}"),array("Images"),'success/The {subject} has been deleted successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
            }
                 	 $this->_helper->redirector('show-images');
        }
         
        $this->view->id = $id;
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-images';
        $controller = ltrim(preg_replace("/([A-Z])/", "-$1", 'Images'), '-');
        $this->_helper->viewRenderer->setRender('add-'.$controller);
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
    		$result = $uploader->handleUpload(IMAGE_CAROUSEL_UPLOAD_TMP, true);
    		// to pass data through iframe you will need to encode all html tags
    		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    	}else
    		echo '{success:true}';
    }
    
    /**
    * Function show all Images
    * @return list Images
    * @author 
    */
    public function ajaxShowImagesAction() {
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
    * Add record Images
    * @param array $formData
    * @author 
    */
    public function ajaxAddImagesAction() {
    
        $this->_helper->layout->disableLayout();
        
        $form = new Application_Form_Core_Images();

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
    * Update record Images
    * @param array $formData
    * @author 
    */
    public function ajaxUpdateImagesAction() {
    
        $this->_helper->layout->disableLayout();
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            die('0');
        }
    
        $form = new Application_Form_Core_Images();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['ImageId'] = $id;
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
    * Delete record Images.
    * @param $id
    * @author 
    */
    public function ajaxDeleteImagesAction(){
        
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