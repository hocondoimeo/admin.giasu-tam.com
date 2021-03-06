<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_Users extends Base_Db_Table_Abstract {


/********************************************************************
* Define table Users
********************************************************************/
    protected $_name        = 'Users';
    protected $_primary     = array('UserId',);

    protected $_dependentTables = array(

    );

    protected $_referenceMap    = array(

    );


/********************************************************************
* Define field search, sort
********************************************************************/
    public $searchFields = array();
    public $sortFields   = array();

    public function init() {
        parent::init();

         /* Define field to search */
        $this->searchFields = array(
            "UserId"                       => "Users.UserId                   = '{{param}}'",
            "Email"                        => "Users.Email                    LIKE '%{{param}}%'",
            "LastName"                     => "Users.LastName                 LIKE '%{{param}}%'",
            "FirstName"                    => "Users.FirstName                LIKE '%{{param}}%'",
            "UserName"                     => "Users.UserName                 LIKE '%{{param}}%'",
            //"LastLogin"                    => "Users.LastLogin                = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "UserId_Sort"                  => "Users.UserId                   {{param}}",
            "Password_Sort"                => "Users.Password                 {{param}}",
            "Email_Sort"                   => "Users.Email                    {{param}}",
            "LastName_Sort"                => "Users.LastName                 {{param}}",
            "FirstName_Sort"               => "Users.FirstName                {{param}}",
            "UserName_Sort"                => "Users.UserName                 {{param}}",
            "IsDisabled_Sort"              => "Users.IsDisabled               {{param}}",
            "LastLogin_Sort"               => "Users.LastLogin                {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/

    public function getAdminUsers(){
    	$select = $this->select()->from($this,'count(UserId) as AUsers')->where('OpenId is null AND (UserName = "admin")');
    	$result = $this->fetchRow($select);
    	if($result) return $result->AUsers;
    	else return null;
    }
    
    public function getDefaultUsers(){
    	$select = $this->select()->from($this,'count(UserId) as DUsers')->where('OpenId is null AND (UserName = "guest")');
    	$result = $this->fetchRow($select);
    	if($result) return $result->DUsers;
    	else return null;
    }
    
    public function getFacebookUsers(){
    	$select = $this->select()->from($this,'count(UserId) as FUsers')->where('OpenId like "fb_%"');
    	$result = $this->fetchRow($select);
    	if($result) return $result->FUsers;
    	else return null;
    }
    
    public function getGoogleUsers(){
    	$select = $this->select()->from($this,'count(UserId) as GUsers')->where('OpenId like "gg_%"');
    	$result = $this->fetchRow($select);
    	if($result) return $result->GUsers;
    	else return null;
    }
    
    public function getTwitterUsers(){
    	$select = $this->select()->from($this,'count(UserId) as TwUsers')->where('OpenId like "tw_%"');
    	$result = $this->fetchRow($select);
    	if($result) return $result->TwUsers;
    	else return null;
    }
    
    public function getTotalUsers(){
    	$select = $this->select()->from($this,'count(UserId) as TUsers');
    	$result = $this->fetchRow($select);
    	if($result) return $result->TUsers;
    	else return null;
    }
}