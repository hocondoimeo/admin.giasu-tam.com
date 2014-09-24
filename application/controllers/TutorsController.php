<?php


/**
 * Controller for Tutors controller
 *
 * @author  kissconcept
 * @version $Id$
 */
class TutorsController extends Zend_Controller_Action
{
    /**
     * Init model
     */
    public function init() {
        $this->_model = new Application_Model_Core_Tutors();
        //$this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    /**
    * Function show all Sites
    */
    public function indexAction() {
        $this->_helper->redirector('show-tutors');
    }    
    
   /**
    * Function show all Tutors
    * @return list Tutors
    * @author 
    */
    public function showTutorsAction() {
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
    * Add record Tutors
    * @param array $formData
    * @return
    * @author 
    */
    public function addTutorsAction() {
        $form = new Application_Form_Core_Tutors();
        $form->changeModeToAdd();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	
            	$data['LastUpdated'] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['LastUpdatedBy'] = USER_ID;
            	if(isset($data['TutorId'])) unset($data['TutorId']);
            	
            	//copy new image from 'tmp' to 'images' folder then remove it
            	$fileName = Common_FileUploader_qqUploadedFileXhr::copyImage($data['Avatar'], IMAGE_UPLOAD_PATH_TMP, IMAGE_UPLOAD_PATH);
            	//copy exist image from 'images' to 'backup' folder then remove it
            	//$fileNameBackup = Common_FileUploader_qqUploadedFileXhr::copyImage($data['OldImageName'], IMAGE_UPLOAD_PATH, IMAGE_UPLOAD_PATH_BACKUP);            	 
            	
                if($id = $this->_model->add($data)){
                	$email = $_POST["Email"];
                	$mailSubject = null;$mailMessageContent = null;
                	$mailUserName =null;$mailFrom = null;
                	$configMails = null;
                	try{
                		$modelConfig = new Application_Model_Core_Configs();
                		$configMails = $modelConfig->getConfigValueByCategoryCode("GROUP_CONFIG_MAIL");
                		foreach ($configMails as $key=>$configMail){
                			switch ($configMail["ConfigCode"]){
                				case "mail-subject": $mailSubject = $configMail["ConfigValue"];break;
                				case "mail-message-content": $mailMessageContent = $configMail["ConfigValue"];break;
                				case "mail-user-name": $mailUserName = $configMail["ConfigValue"];break;
                				case "mail-user-name-from": $mailFrom = $configMail["ConfigValue"];break;
                			}
                		}
                	}catch (Zend_Exception $e){
                	
                	}
                	 
                	$rsInitMail = $this->_initMail($configMails);
                	if($rsInitMail[0]){
                		$subject = $mailSubject;
                		 
                		$message = str_replace(array("{id}"),array($id), $mailMessageContent);
                		$sendResult = $this->sendMail($email, $subject, $message,$mailUserName,$mailFrom);
                		 
	                		if($sendResult[0]){     			
	                				$msg = str_replace(array("{subject}"),array("Tutors"),'success/The {subject} has been added successfully.');
				                 	$this->_helper->flashMessenger->addMessage($msg);
	                		}
	                		else{
	                			$this->view->messageStatus = 'danger/Add new tutor failed.';
	                		}
                	 }
                }else{
	                	if (file_exists(IMAGE_UPLOAD_PATH_TMP.$fileName))
            				unlink(IMAGE_UPLOAD_PATH_TMP.$fileName);
            			$this->_helper->flashMessenger->addMessage(array('danger/database error'));
            	}
                $this->_helper->redirector('show-tutors');
            }else{
            	$this->view->avatar = (isset($_POST['Avatar'])  && !empty($_POST['Avatar']))?$_POST['Avatar']:'';
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
            }
        }
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-tutors';        
    	//$this->view->controller = Regex.Replace('Tutors', "(?<=[a-z])([A-Z])", "-$1");
    }
    	
    /**
    * Update record Tutors.
    * @param array $formData
    * @return
    * @author 
    */
    public function updateTutorsAction() {
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-tutors');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-tutors');
        }
    
        $form = new Application_Form_Core_Tutors();
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
	            	$fileName = Common_FileUploader_qqUploadedFileXhr::copyImage($data['Avatar'], IMAGE_UPLOAD_PATH_TMP, IMAGE_UPLOAD_PATH);
	            	//copy exist image from 'images' to 'backup' folder then remove it
	            	$fileNameBackup = Common_FileUploader_qqUploadedFileXhr::copyImage($data['OldImageName'], IMAGE_UPLOAD_PATH, IMAGE_UPLOAD_PATH_BACKUP);
            	}
            	
            	//if($fileName || $fileNameBackup){
            		if($this->_model->edit($data)){
	                    $msg = str_replace(array("{subject}"),array("Tutors"),'success/The {subject} has been updated successfully.');
	                 	$this->_helper->flashMessenger->addMessage($msg);
	                }else{
	                	if (($data['Avatar'] !== $data['OldImageName']) && file_exists(IMAGE_UPLOAD_PATH_TMP.$fileName))
            				unlink(IMAGE_UPLOAD_PATH_TMP.$fileName);
            			$this->_helper->flashMessenger->addMessage(array('danger/database error'));
            		}
            	/* }else
            		 $this->_helper->flashMessenger->addMessage(MSG_ERROR_PHP); */
                 	$this->_helper->redirector('show-tutors');
            }else{
            	$this->view->avatar = (isset($_POST['Avatar'])  && !empty($_POST['Avatar']))?$_POST['Avatar']:'';
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
           }
        }
            
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-tutors';
        $this->_helper->viewRenderer->setRender('add-tutors');
        //$this->view->controller = Regex.Replace('Tutors', "(?<=[a-z])([A-Z])", "-$1");
    }
    
    /**
    * Delete record Tutors.
    * @param $id
    * @return
    * @author 
    */
    public function deleteTutorsAction(){
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-tutors');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-tutors');
        }
       
        $form = new Application_Form_Core_Tutors();
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
            $id = $formData['TutorId'];
           	if($row && $this->_model->deleteRow($id)) {
                    $msg = str_replace(array("{subject}"),array("Tutors"),'success/The {subject} has been deleted successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
            }
                 	 $this->_helper->redirector('show-tutors');
        }
         
        $this->view->id = $id;
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-tutors';
        $this->_helper->viewRenderer->setRender('add-tutors');
    }
    
    /**
    * Function show all Tutors
    * @return list Tutors
    * @author 
    */
    public function ajaxShowTutorsAction() {
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
    * Add record Tutors
    * @param array $formData
    * @author 
    */
    public function ajaxAddTutorsAction() {
    
        $this->_helper->layout->disableLayout();
        
        $form = new Application_Form_Core_Tutors();

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
    * Update record Tutors
    * @param array $formData
    * @author 
    */
    public function ajaxUpdateTutorsAction() {
    
        $this->_helper->layout->disableLayout();
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            die('0');
        }
    
        $form = new Application_Form_Core_Tutors();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['TutorId'] = $id;
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
    * Delete record Tutors.
    * @param $id
    * @author 
    */
    public function ajaxDeleteTutorsAction(){
        
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
    
    /**
     * init mail
     * @author tri.van
     * @since Tue Now 3, 9:48 AM
     */
    private function _initMail($configMails){
    	try {
    
    		$mailUserName = null;$mailPassword=null;
    		$mailSSL =null;$mailPort = null;
    
    		//get config mail from DB
    		foreach ($configMails as $key=>$configMail){
    			switch ($configMail["ConfigCode"]){
    				case "mail-user-name": $mailUserName = $configMail["ConfigValue"];break;
    				case "mail-password": $mailPassword = $configMail["ConfigValue"];break;
    				case "mail-ssl": $mailSSL = $configMail["ConfigValue"];break;
    				case "mail-port": $mailPort = $configMail["ConfigValue"];break;
    				case "mail-server": $mailServer = $configMail["ConfigValue"];break;
    			}
    		}
    
    		$config = array(
    				'auth' => 'login',
    				'username' => $mailUserName,
    				'password' => $mailPassword,
    				'ssl' => $mailSSL,
    				'port' => (int)$mailPort
    		);
    
    		$mailTransport = new Zend_Mail_Transport_Smtp($mailServer, $config);
    		Zend_Mail::setDefaultTransport($mailTransport);
    		return array(true,"");
    	} catch (Zend_Exception $e){
    		return array(false,$e->getMessage());
    	}
    }
    
    /**
     * send mail helper
     * @author tri.van
     * @param $email
     * @param $subject
     * @param $message
     * @param $mailUserName
     * @param $mailFrom
     * @since Tue Now 3, 9:48 AM
     */
    private function sendMail($email,$subject,$message,$mailUserName,$mailFrom){
    	try {
    		//Prepare email
    		$mail = new Zend_Mail('UTF-8');
    		//add headers avoid the mail direction to 'spam'/ 'junk' folder
    		$mail->addHeader('MIME-Version', '1.0');
    		$mail->addHeader('Content-Type', 'text/html');
    		$mail->addHeader('Content-Transfer-Encoding', '8bit');
    		$mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
    
    		$mail->setFrom($mailUserName, $mailFrom);
    		//add reply to avoid the mail direction to 'spam'/ 'junk' folder
    		$mail->setReplyTo($mailFrom, $subject);
    
    		$mail->addTo($email);
    		$mail->setSubject($subject);
    		$mail->setBodyHtml($message);
    
    		//Send it!
    		$mail->send();
    		return array(true,"");
    	} catch (Exception $e){
    		$sent = $e->getMessage();
    		return array(false,$sent);
    	}
    }
}