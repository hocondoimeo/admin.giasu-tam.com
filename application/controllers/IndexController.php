<?php
/**
 * Controller Index
 *
 * @author      code generate
 * @package   	KiSS
 * @version     $Id$
 * @todo remove
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * (non-PHPdoc)
     * @see Zend_Controller_Action::init()
     */
    public function init () {}
    /**
     * Home page - Main Panel
     *
     */
    public function indexAction() {
    	$ClassesModel = new Application_Model_Core_Classes();
    	$this->view->aClasses = $ClassesModel->getAvailableClasses();
    	$this->view->nClasses = $ClassesModel->getNewClasses();
    	$this->view->uClasses = $ClassesModel->getUnAvailableClasses();
    	$this->view->tClasses = $ClassesModel->getTotalClasses();

    	$ConfigsModel = new Application_Model_Core_Configs();
    	//$this->view->aConfigs = $ConfigsModel->getModifiedConfigs();
    	//$this->view->nConfigs = $ConfigsModel->getNewConfigs();
    	//$this->view->uConfigs = $ConfigsModel->getDisabledConfigs();
    	//$this->view->tConfigs = $ConfigsModel->getTotalConfigs();
    	
    	$ImagesModel = new Application_Model_Core_Images();
    	$this->view->aImages = $ImagesModel->getModifiedImages();
    	//$this->view->nImages = $ImagesModel->getNewImages();
    	$this->view->uImages = $ImagesModel->getDisabledImages();
    	$this->view->tImages = $ImagesModel->getTotalImages();
    	
    	$NewsModel = new Application_Model_Core_News();
    	$this->view->aNews = $NewsModel->getModifiedNews();
    	$this->view->nNews = $NewsModel->getNewNews();
    	$this->view->uNews = $NewsModel->getDisabledNews();
    	$this->view->tNews = $NewsModel->getTotalNews();
    	
    	$TutorsModel = new Application_Model_Core_Tutors();
    	$this->view->aTutors = $TutorsModel->getAvailableTutors();
    	$this->view->nTutors = $TutorsModel->getNewTutors();
    	$this->view->uTutors = $TutorsModel->getUnAvailableTutors();
    	$this->view->tTutors = $TutorsModel->getTotalTutors();
    	
    	$UsersModel = new Application_Model_Core_Users();
    	$this->view->admin = $UsersModel->getAdminUsers();
    	$this->view->default = $UsersModel->getDefaultUsers();
    	$this->view->facebook = $UsersModel->getFacebookUsers();
    	$this->view->google = $UsersModel->getGoogleUsers();
    	$this->view->twitter = $UsersModel->getTwitterUsers();
    	$this->view->totalUsers = $UsersModel->getTotalUsers();
    	
    	$ContactsModel = new Application_Model_Core_Contacts();
    	
    	$GradesModel = new Application_Model_Core_Grades();
    	$this->view->grades = $GradesModel->getAvailableGrades();
    	$DistrictsModel = new Application_Model_Core_Districts();
    	$this->view->districts = $DistrictsModel->getAvailableDistricts();
    	$SubjectsModel = new Application_Model_Core_Subjects();
    	$this->view->subjects = $SubjectsModel->getAvailableSubjects();
    }
    
    



}
