<?php
/**
 * Model for Application_Model_Crawler_SiteLinks
 *
 * @version $Id$
 */

class Application_Model_Core_News extends Base_Db_Table_Abstract {


/********************************************************************
* Define table News
********************************************************************/
    protected $_name        = 'News';
    protected $_primary     = array('NewsId',);

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
            "NewsId"                       => "News.NewsId                    = '{{param}}'",
            "Title"                        => "News.Title                     LIKE '%{{param}}%'",
            "Summary"                      => "News.Summary                   LIKE '%{{param}}%'",
            "UserId"                      => "News.UserId                   = '{{param}}'",
            "Content"                      => "News.Content                   LIKE '%{{param}}%'",
            "ImageUrl"                     => "News.ImageUrl                  LIKE '%{{param}}%'",
            "CreatedDate"                  => "News.CreatedDate               = '{{param}}'",
            "IsPrivate"                    => "News.IsPrivate                 = '{{param}}'",
            "NewsCategoryId"               => "News.NewsCategoryId            = '{{param}}'",
        );
        $this->searchFields['All'] = implode(" OR ", $this->searchFields);

        $this->sortFields = array(
            "NewsId_Sort"                  => "News.NewsId                    {{param}}",
            "Title_Sort"                   => "News.Title                     {{param}}",
            "Summary_Sort"                 => "News.Summary                   {{param}}",
            "UserId_Sort"                 => "News.UserId                   {{param}}",
            "Content_Sort"                 => "News.Content                   {{param}}",
            "ImageUrl_Sort"                => "News.ImageUrl                  {{param}}",
            "CreatedDate_Sort"             => "News.CreatedDate               {{param}}",
            "IsPrivate_Sort"               => "News.IsPrivate                 {{param}}",
            "NewsCategoryId_Sort"          => "News.NewsCategoryId            {{param}}",
        );
    }

/********************************************************************
* PUT YOUR CODE HERE
********************************************************************/
    
    public function getNewsByCate($cateId) {
    	return $this->_db->fetchOne("SELECT Position FROM {$this->_name} ORDER BY CreatedDate");
    }
    
    public function getAllNews() {
    	return $this->_db->fetchOne("SELECT Position FROM {$this->_name} ORDER BY CreatedDate DESC");
    }

    public function getModifiedNews(){
    	$select = $this->select()->from($this,'count(NewsId) as ANews')->where('LastUpdated > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
    	$result = $this->fetchRow($select);
    	if($result) return $result->ANews;
    	else return null;
    }
    
    public function getNewNews(){
    	$select = $this->select()->from($this,'count(NewsId) as NNews')->where('CreatedDate > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
    	$result = $this->fetchRow($select);
    	if($result) return $result->NNews;
    	else return null;
    }
    
    public function getDisabledNews(){
    	$select = $this->select()->from($this,'count(NewsId) as UNews')->where('IsDisabled = 1');
    	$result = $this->fetchRow($select);
    	if($result) return $result->UNews;
    	else return null;
    }
    
    public function getTotalNews(){
    	$select = $this->select()->from($this,'count(NewsId) as TNews');
    	$result = $this->fetchRow($select);
    	if($result) return $result->TNews;
    	else return null;
    }
}