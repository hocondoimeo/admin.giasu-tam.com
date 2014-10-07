<?php


/**
 * Controller for Users controller
 *
 * @author  kissconcept
 * @version $Id$
 */
class UsersController extends Zend_Controller_Action
{
    /**
     * Init model
     */
    public function init() {
        $this->_model = new Application_Model_Core_Users();
        //$this->_controllerName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
    }
    /**
    * Function show all Sites
    */
    public function indexAction() {
        $this->_helper->redirector('show-users');
    }    
    
   /**
    * Function show all Users
    * @return list Users
    * @author 
    */
    public function showUsersAction() {
        /*Get parameters filter*/
        $params            = $this->_getAllParams();
        $params['page']    = $this->_getParam('page',1);
        $params['perpage'] = $this->_getParam('perpage',NUMBER_OF_ITEM_PER_PAGE);
        $params['where'] = array('Users.UserId != 1 AND (UserName != "Admin" OR  UserName != "admin")');
        $params['foreign'] = array('table' => 'Contacts', 'key' => 'UserId', 'cols' => array('ContactId'));
        $params['group'] = 'Users.UserId';
        $cols = array('Users.UserId', 'Email', 'LastName', 'FirstName', 'UserName', 'IsDisabled', 'LastLogin', 'OpenId', 'count(ContactId) as Contacts');
        
        /*Get all data*/
        $paginator = Zend_Paginator::factory($this->_model->getQuerySelectAll($params, $cols));
        $paginator->setCurrentPageNumber($params['page']);
        $paginator->setItemCountPerPage($params['perpage']);

        /*Assign varible to view*/
        $this->view->paginator = $paginator;
        $this->view->assign($params);
        $this->view->message = $this->_helper->flashMessenger->getMessages();
    }
    
    /**
    * Add record Users
    * @param array $formData
    * @return
    * @author 
    */
    public function addUsersAction() {
        $form = new Application_Form_Core_Users();
        $form->changeModeToAdd();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;
            	
            	$data["LastLogin"] = Zend_Date::now()->toString(DATE_FORMAT_DATABASE);
            	$data['Password'] = sha1($_POST['Password']);
            	if(isset($data['UserId'])) unset($data['UserId']);
            	
                if($this->_model->add($data)){
                	
                	$this->_sendEmailToUser($data['FirstName'].' '.$data['LastName'], $data['Email'], 'users/show-users');
                	
                    $msg = str_replace(array("{subject}"),array("Users"),'success/The {subject} has been added successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
                }
                $this->_helper->redirector('show-users');
            }else{
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
            }
        }
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-users';
    }
    	
    /**
    * Update record Users.
    * @param array $formData
    * @return
    * @author 
    */
    public function updateUsersAction() {
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-users');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-users');
        }
    
        $form = new Application_Form_Core_Users();
        $form->changeModeToUpdate($id);
        $email = $form->getElement('Email')->getValue();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            if($form->isValid($formData)) {
            	$data = $_POST;//var_dump($data);die;
            	if(!empty($data['Password']))
            		$data['Password'] = sha1($_POST['Password']);
            	else 
            		unset($data['Password']);
            	
            	if(!empty($data['Email']) && ($data['Email'] == $email))
            		unset($data['Email']);
            	
                if($this->_model->edit($data)){
                    $msg = str_replace(array("{subject}"),array("Users"),'success/The {subject} has been updated successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
                }
                 	$this->_helper->redirector('show-users');
            }else{
                 $msg ='danger/There are validation error(s) on the form. Please review the following field(s):';
                 foreach ($form->getMessages() as $key=>$messageFormError){
                      $msg .= '/'.$key;
                 }
                 $this->view->message = array($msg);
           }
        }
        $row->Password = '';
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-users';
        $this->_helper->viewRenderer->setRender('add-users');
    }
    
    /**
    * Delete record Users.
    * @param $id
    * @return
    * @author 
    */
    public function deleteUsersAction(){
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-users');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            $this->_helper->flashMessenger->addMessage('%%ERROR_URL%%');
            $this->_helper->redirector('show-users');
        }
       
        $form = new Application_Form_Core_Users();
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
            $id = $formData['UserId'];
            if(isset($id) && !empty($id) && $this->_model->deleteRow($id)) {
                    $msg = str_replace(array("{subject}"),array("Users"),'success/The {subject} has been deleted successfully.');
                 	$this->_helper->flashMessenger->addMessage($msg);
            }
                 	 $this->_helper->redirector('show-users');
        }
         
        $this->view->id = $id;
        $form->populate($row->toArray());
        $this->view->form = $form;
        $this->view->showAllUrl = 'show-users';
        $this->_helper->viewRenderer->setRender('add-users');
    }
    
    /**
    * Function show all Users
    * @return list Users
    * @author 
    */
    public function ajaxShowUsersAction() {
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
    * Add record Users
    * @param array $formData
    * @author 
    */
    public function ajaxAddUsersAction() {
    
        $this->_helper->layout->disableLayout();
        
        $form = new Application_Form_Core_Users();

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
    * Update record Users
    * @param array $formData
    * @author 
    */
    public function ajaxUpdateUsersAction() {
    
        $this->_helper->layout->disableLayout();
        
        /* Check valid data */
        if(null == $id = $this->_request->getParam('id',null)){
            die('0');
        }

        $row = $this->_model->find($id)->current();
        if(!$row) {
            die('0');
        }
    
        $form = new Application_Form_Core_Users();

        /* Proccess data post*/
        if($this->_request->isPost()) {
            $formData = $this->_request->getPost();
            $formData['UserId'] = $id;
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
    * Delete record Users.
    * @param $id
    * @author 
    */
    public function ajaxDeleteUsersAction(){
        
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
     * login action
     * @author tri.van
     * @since Tue Now 3, 9:48 AM
     */
    public function loginAction(){
    	$this->_helper->layout()->setLayout('admin-login');
    
    	//save backlink
    	$backLink = null;
    	if (isset($_SERVER['HTTP_REFERER'])) {
    		if (strstr($backLink, "/login") != "/login"){
    			$backLink = $_SERVER['HTTP_REFERER'];
    			$this->view->backLink = $backLink;
    		}
    	}
    
    	//check authentication first
    	$zendAuth = Zend_Auth::getInstance();
    	if ($zendAuth->hasIdentity()) {
    		$this->_redirect("/");
    	}
    
    	if($this->_request->isPost()){
    
    		if(!empty($_POST["backLink"])) $backLink = $_POST["backLink"];
    
    		$auth = new Application_Plugin_Initializer();
    		if(empty($_POST['username']) || empty($_POST['password']))
    			$this->view->rs = false;
    		else{
    			$data = array();
    			$data['Email'] = $_POST['username'];
    			$data['Password'] = sha1($_POST['password']);
    			$rs = $auth->login($data);
    			if(!$rs) $this->view->rs = false;
    			else {
    				//save LastLogin to database
    				$this->_model->update(array("LastLogin"=>Zend_Date::now()->toString(DATE_FORMAT_DATABASE)
    				),"UserId = ".USER_ID);
    
    				//if choice remember password
    				if(isset($_POST["remember"])) {
    					$saveHandler = Zend_Session::getSaveHandler();
    					$saveHandler->setOverrideLifetime(true);
    					$saveHandler->setLifetime(SESSION_LIFE_TIME_REMEMBER);
    				}
    
    				//redirect
    				if(empty($backLink)) $this->_redirect("/	");
    				else {
    					if(isset($_SESSION['sessionBackLink']['link'])){
    						$link = $_SESSION['sessionBackLink']['link'];
    						Zend_Session::namespaceUnset('sessionBackLink');
    						$this->_redirect($link);
    					}
    					else $this->_redirect($backLink);
    				}
    			}
    		}
    	}
    }
    
    public function logoutAction(){
    	$auth = new Application_Plugin_Initializer();
    	$auth->logout();
    }
    
    private function _sendEmailToUser($name, $email, $urlRedirect){
    	$mailUserName =null; $mailFrom = null; $configMails = null;
    	try{
    		$modelConfig = new Application_Model_Core_Configs();
    		$configMails = $modelConfig->getConfigValueByCategoryCode("GROUP_CONFIG_MAIL");
    		foreach ($configMails as $key=>$configMail){
    			switch ($configMail["ConfigCode"]){
    				case "mail-user-name": $mailUserName = $configMail["ConfigValue"];break;
    				case "mail-user-name-from": $mailFrom = $configMail["ConfigValue"];break;
    			}
    		}
    		$tutorConfig = $modelConfig->getConfigDetail("dang-ky-tim-gia-su");
    	}catch (Zend_Exception $e){
    		 
    	}
    	 
    	$rsInitMail = $this->_initMail($configMails);
    	if($rsInitMail[0]){
    		$subject = $tutorConfig['ConfigName'];
    
    		// initialize template
    		$html = new Zend_View();
    		$html->setScriptPath(APPLICATION_PATH . '/views/scripts/email_templates/');
    
    		$html->assign('name', $name);
    
    		$message = $html->render('register-user.phtml');
    
    		$sendResult = $this->sendMail($email, $subject, $message,$mailUserName,$mailFrom);
    
    		if($sendResult[0]){
    			$this->_redirect($urlRedirect);
    		}else{
    			$this->view->messageStatus = 'danger/.';
    		}
    	}else{
    		$this->view->messageStatus = 'danger/.';
    	}
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